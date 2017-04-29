<?php

namespace webdoka\yiiecommerce\common\queries;

/**
 * This is the ActiveQuery class for [[DeliverieHasDiscount]].
 *
 * @see DeliverieHasDiscount
 */
class DeliverieHasDiscountQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DeliverieHasDiscount[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DeliverieHasDiscount|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
