<?php

namespace webdoka\yiiecommerce\common\components;

use webdoka\yiiecommerce\common\models\CartProduct;
use yii\base\Component;
use yii\di\Instance;
use yii\web\Session;
use webdoka\yiiecommerce\common\models\Cart as CartModel;

/**
 * Class Cart
 * @package webdoka\yiiecommerce\common\components
 */
class Cart extends Component
{
    /**
     * @var array of IPosition
     */
    protected $_positions = [];

    public $id = __CLASS__;
    public $session = 'session';

    /**
     * Init positions
     */
    public function init()
    {
        $this->loadFromSession();
    }

    /**
     * Load positions from session by cart id
     * @throws \yii\base\InvalidConfigException
     */
    public function loadFromSession()
    {
        // Default load from session
        $this->session = Instance::ensure($this->session, Session::className());
        if ($this->session[$this->id]) {
            $this->_positions = unserialize($this->session[$this->id]);
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

            if (empty($cart->products) && !empty($this->_positions)) {
                // Synch session -> db
                $this->saveToSession();

            } elseif (!empty($cart->products)) {
                // Synch db -> session
                $this->_positions = [];

                foreach ($cart->products as $product) {
                    if ($cartProduct = CartProduct::find()->where(['cart_id' => $cart->id, 'product_id' => $product->id])->one()) {
                        $product->setQuantity($cartProduct->quantity);

                        if (!isset($this->_positions[$product->id])) {
                            $this->_positions[$product->id] = $product;
                        }
                    }
                }

                $this->session[$this->id] = serialize($this->_positions);
            }
        }
    }

    /**
     * Save serialized positions to session
     */
    public function saveToSession()
    {
        // Default save to session
        $this->session[$this->id] = serialize($this->_positions);

        if (!\Yii::$app->user->isGuest) {
            $profileId = \Yii::$app->user->identity->profile->id;

            if ($cart = CartModel::find()->where(['profile_id' => $profileId])->one()) {
                $cart->unlinkAll('cartProducts', true);

                foreach ($this->_positions as $position) {
                    $cartProduct = new CartProduct();
                    $cartProduct->cart_id = $cart->id;
                    $cartProduct->product_id = $position->id;
                    $cartProduct->quantity = $position->quantity;
                    $cartProduct->save();
                }
            }
        }
    }

    /**
     * Returns positions
     * @return array
     */
    public function getPositions()
    {
        return $this->_positions;
    }

    /**
     * Set positions filtered by instance of IPosition
     * @param $positions
     */
    public function setPositions($positions)
    {
        $this->_positions = array_filter($positions, function ($position) {
            return $position instanceof IPosition;
        });

        $this->saveToSession();
    }

    /**
     * Check on empty
     * @return bool
     */
    public function getIsEmpty()
    {
        return empty($this->_positions);
    }

    /**
     * Returns count of positions
     * @return int
     */
    public function getCount()
    {
        $count = 0;

        foreach ($this->_positions as $position)
            $count += $position->getQuantity();

        return $count;
    }

    /**
     * Returns summary cost of existing positions
     */
    public function getCost()
    {
        $cost = 0;

        foreach ($this->_positions as $position) {
            $cost += $position->getCostWithDiscounters($position->getQuantity());
        }

        return $cost;
    }

    /**
     * Put position to cart, or increase existing quantity
     * @param IPosition $position
     */
    public function put(IPosition $position)
    {
        $id = $position->getId();

        if ($position->getQuantity() == 0)
            $position->setQuantity(1);

        if (isset($this->_positions[$id]))
            $this->_positions[$id]->setQuantity($this->_positions[$id]->getQuantity() + $position->getQuantity());
        else
            $this->_positions[$position->getId()] = $position;

        $this->saveToSession();
    }

    /**
     * If position quantity == 0, removes position, else updates this
     * @param IPosition $position
     */
    public function update(IPosition $position)
    {
        if (!$position->getQuantity()) {
            $this->remove($position);
            return;
        }

        if (isset($this->_positions[$position->getId()]))
            $this->_positions[$position->getId()]->setQuantity($position->getQuantity());
        else
            $this->_positions[$position->getId()] = $position;

        $this->saveToSession();
    }

    /**
     * Remove position
     * @param IPosition $position
     */
    public function remove(IPosition $position)
    {
        $this->removeById($position->getId());
    }

    /**
     * Remove position by id
     * @param $id
     */
    public function removeById($id)
    {
        if (array_key_exists($id, $this->_positions)) {
            unset($this->_positions[$id]);
            $this->saveToSession();
        }
    }

    /**
     * Remove all positions
     */
    public function removeAll()
    {
        $this->_positions = [];
        $this->saveToSession();
    }

    /**
     * Return hash of cart, that's can be useful for detecting of cart changes
     * @return string
     */
    public function getHash()
    {
        $data = [];

        foreach ($this->_positions as $position)
            $data[] = [$position->getId(), $position->getQuantity(), $position->realPrice];

        return md5(serialize($data));
    }
}