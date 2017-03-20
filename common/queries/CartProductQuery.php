<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\CartProduct;

/**
 * This is the ActiveQuery class for [[CartProduct]].
 *
 * @see CartProduct
 */
class CartProductQuery extends \yii\db\ActiveQuery
{

    /**
     * @return $this
     */
    public function noSet()
    {
        return $this->andWhere('cart_set_id IS NULL');
    }

    /**
     * @inheritdoc
     * @return CartProduct[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return CartProduct|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
