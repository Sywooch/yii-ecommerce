<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\OrderItem;

/**
 * This is the ActiveQuery class for [[OrderItem]].
 *
 * @see OrderItem
 */
class OrderItemQuery extends \yii\db\ActiveQuery
{
    public function noSet()
    {
        return $this->andWhere('order_set_id IS NULL');
    }

    /**
     * @inheritdoc
     * @return OrderItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrderItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
