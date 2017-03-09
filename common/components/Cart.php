<?php

namespace webdoka\yiiecommerce\common\components;

use webdoka\yiiecommerce\common\models\CartProduct;
use webdoka\yiiecommerce\common\models\CartSet;
use webdoka\yiiecommerce\common\models\Set;
use yii\base\Component;
use yii\di\Instance;
use yii\web\Session;
use webdoka\yiiecommerce\common\models\Cart as CartModel;

/**
 * Class Cart
 * @package webdoka\yiiecommerce\common\components
 */
class Cart extends Component {

    const SETS = '_sets';
    const POSITIONS = '_positions';

    protected $_positions = [], $_sets = [];
    public $id = __CLASS__;
    public $session = 'session';

    /**
     * Init positions
     */
    public function init() {
        $this->loadFromSession();
    }

    /**
     * Load positions from session by cart id
     * @throws \yii\base\InvalidConfigException
     */
    public function loadFromSession() {
        // Default load from session
        $this->session = Instance::ensure($this->session, Session::className());
        if ($this->session[$this->id . self::POSITIONS]) {
            $this->_positions = unserialize($this->session[$this->id . self::POSITIONS]);
        }
        if ($this->session[$this->id . self::SETS]) {
            $this->_sets = unserialize($this->session[$this->id . self::SETS]);
        }

        // Load from db
        if (!\Yii::$app->user->isGuest) {
            $profileId = \Yii::$app->user->identity->profile->id;

            if (!$cart = CartModel::find()->where(['profile_id' => $profileId])->one()) {
                // Create Cart if this is not exists
                $cart = new CartModel();
                $cart->profile_id = $profileId;
                $cart->save();
            }

            if (
                    empty($cart->productsNoSet) && !empty($this->_positions) ||
                    empty($cart->sets) && !empty($this->_sets)
            ) {

                // Sync session -> db
                $this->saveToSession();
            } elseif (
                    !empty($cart->productsNoSet) && empty($this->_positions) ||
                    !empty($cart->sets) && empty($this->_sets)) {

                // Sync db -> session
                $this->_positions = [];
                $this->_sets = [];

                foreach ($cart->cartProducts as $cartProduct) {
                    if (!$cartProduct->cart_set_id) {
                        $product = $cartProduct->product;
                        $product->setQuantity($cartProduct->quantity);
                        $product->setOption_id($cartProduct->option_id);

                        if (array_key_exists($product->id . $cartProduct->option_id, $this->_positions)) {
                            $this->_positions[$product->id . $cartProduct->option_id] = $product;
                        }
                    }
                }

                foreach ($cart->cartSets as $cartSet) {
                    if ($set = Set::find()->where(['id' => $cartSet->set_id])->one()) {
                        $set->populateRelation('setsProducts', $cartSet->cartsProducts);

                        $this->_sets[$set->tmpId] = $set;
                    }
                }

                $this->session[$this->id . self::POSITIONS] = serialize($this->_positions);
                $this->session[$this->id . self::SETS] = serialize($this->_sets);
            }
        }
    }

    /**
     * Save serialized positions to session
     */
    public function saveToSession() {
        // Default save to session
        $this->session[$this->id . self::POSITIONS] = serialize($this->_positions);
        $this->session[$this->id . self::SETS] = serialize($this->_sets);

        if (!\Yii::$app->user->isGuest) {
            $profileId = \Yii::$app->user->identity->profile->id;

            if ($cart = CartModel::find()->where(['profile_id' => $profileId])->one()) {
                $cart->unlinkAll('cartProducts', true);
                $cart->unlinkAll('cartSets', true);

                foreach ($this->_positions as $position) {

                    $optid = $this->session[$position->id . '-optionid'];

                    $cartProduct = new CartProduct();
                    $cartProduct->cart_id = $cart->id;
                    $cartProduct->product_id = $position->id;
                    $cartProduct->quantity = $position->quantity;
                    $cartProduct->option_id = $position->option_id;
                    $cartProduct->save();
                }

                foreach ($this->_sets as $set) {
                    $cartSet = new CartSet();
                    $cartSet->cart_id = $cart->id;
                    $cartSet->set_id = $set->id;

                    if ($cartSet->save()) {
                        foreach ($set->setsProducts as $setProduct) {
                            $cartProduct = new CartProduct();
                            $cartProduct->cart_id = $cart->id;
                            $cartProduct->product_id = $setProduct->product_id;
                            $cartProduct->quantity = $setProduct->quantity;
                            $cartProduct->cart_set_id = $cartSet->id;
                            $cartProduct->save();
                        }
                    }
                }
            }
        }
    }

    /**
     * Returns positions
     * @return array
     */
    public function getPositions() {
        return $this->_positions;
    }

    /**
     * Set positions filtered by instance of IPosition
     * @param $positions
     */
    public function setPositions($positions) {
        $this->_positions = array_filter($positions, function ($position) {
            return $position instanceof IPosition;
        });

        $this->saveToSession();
    }

    /**
     * Returns sets
     * @return array
     */
    public function getSets() {
        return $this->_sets;
    }

    /**
     * Set sets filtered by instance of IPosition
     * @param $sets
     */
    public function setSets($sets) {
        $this->_sets = array_filter($sets, function ($position) {
            return $position instanceof IPosition;
        });

        $this->saveToSession();
    }

    /**
     * Check on empty
     * @return bool
     */
    public function getIsEmpty() {
        return empty($this->_positions);
    }

    /**
     * Returns count of positions
     * @return int
     */
    public function getCount() {
        $count = 0;

        foreach ($this->_positions as $position) {
            $count += $position->getQuantity();
        }

        $count += count($this->_sets);

        return $count;
    }

    /**
     * Returns summary cost of existing positions and sets
     */
    public function getCost() {
        $cost = 0;

        foreach ($this->_positions as $position) {

            $cost += $position->getCostWithDiscounters($position->getQuantity(), $position->getOption_id());
        }

        foreach ($this->_sets as $set) {
            $cost += $set->getCostWithDiscounters();
        }

        return $cost;
    }

    /**
     * Put position to cart, or increase existing quantity
     * @param IPosition $position
     */
    public function put(IPosition $position) {
        $id = $position->getId();
        $optid = $this->session[$position->id . '-optionid'];

        $position->setOption_id($optid);

        if ($position->getQuantity() == 0)
            $position->setQuantity(1);

        if (isset($this->_positions[$id . $optid])) {
            $this->_positions[$id . $optid]->setQuantity($this->_positions[$id . $optid]->getQuantity() + $position->getQuantity());
            $this->_positions[$id . $optid]->setOption_id((int) $optid);
        } else {
            $this->_positions[$position->getId() . $optid] = $position;
        }

        $this->saveToSession();
    }

    /**
     * Put position to cart, or increase existing quantity
     * @param Set $set
     */
    public function putSet(Set $set) {
        $this->_sets[$set->tmpId] = $set;

        $this->saveToSession();
    }

    /**
     * If position quantity == 0, removes position, else updates this
     * @param IPosition $position
     */
    public function update(IPosition $position) {
        if (!$position->getQuantity()) {
            $this->remove($position);
            return;
        }
        $optid = $this->session[$position->id . '-optionid'];
        $position->setOption_id($optid);

        if (isset($this->_positions[$position->getId() . $optid])) {
            $this->_positions[$position->getId() . $optid]->setQuantity($position->getQuantity());
            $this->_positions[$position->getId() . $optid]->setOption_id((int) $optid);
        } else {
            $this->_positions[$position->getId() . $optid] = $position;
        }

        $this->saveToSession();
    }

    /**
     * If position quantity == 0, removes position, else updates this
     * @param IPosition $position
     */
    public function updateopt(IPosition $position, $option, $oldoption, $quant) {


        $id = $position->getId();

        $position->setOption_id($option);
        $position->setQuantity((int) $quant);

        if (isset($this->_positions[$id . $oldoption]) && isset($this->_positions[$id . $option])) {
            $this->_positions[$id . $option]->setQuantity($this->_positions[$id . $option]->getQuantity() + (int) $quant);
            $this->_positions[$id . $option]->setOption_id((int) $option);
            $this->remove($position, $oldoption);
        } else {
            $this->remove($position, $oldoption);
            if (isset($this->_positions[$id . $option])) {
                $this->_positions[$id . $option]->setQuantity((int) $quant);
                $this->_positions[$id . $option]->setOption_id((int) $option);
            } else {
                $this->_positions[$position->getId() . $option] = $position;
            }
        }

        $this->saveToSession();
    }

    /**
     * Remove position
     * @param IPosition $position
     */
    public function remove(IPosition $position, $optionid) {
        $this->removeById($position->getId(), $optionid);
    }

    /**
     * Remove position by id
     * @param $id
     */
    public function removeById($id, $optionid) {

        if ($optionid != null) {
            $optid = $optionid;
        } else {
            $optid = 0;
        }

        if (array_key_exists($id . $optid, $this->_positions)) {
            unset($this->_positions[$id . $optid]);
            $this->saveToSession();
        }
    }

    /**
     * @param $id
     */
    public function removeSetById($id) {
        if (array_key_exists($id, $this->_sets)) {
            unset($this->_sets[$id]);
            $this->saveToSession();
        }
    }

    /**
     * Remove all positions and sets
     */
    public function removeAll() {
        $this->_positions = [];
        $this->_sets = [];

        $this->saveToSession();
    }

    /**
     * Return hash of cart, that's can be useful for detecting of cart changes
     * @return string
     */
    public function getHash() {
        $data = [];

        foreach ($this->_positions as $position)
            $data[] = [$position->getId(), $position->getQuantity(), $position->realPrice];

        foreach ($this->_sets as $set)
            $data[] = [$set->getId(), $set->getCostWithDiscounters()];

        return md5(serialize($data));
    }

}
