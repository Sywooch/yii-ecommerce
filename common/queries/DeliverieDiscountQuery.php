<?php

namespace webdoka\yiiecommerce\common\queries;

/**
 * This is the ActiveQuery class for [[DeliveriDiscount]].
 *
 * @see DeliveriDiscount
 */
class DeliverieDiscountQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DeliveriDiscount[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DeliveriDiscount|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
