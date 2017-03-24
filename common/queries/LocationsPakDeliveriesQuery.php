<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\LocationsPakDeliveries;

/**
 * This is the ActiveQuery class for [[LocationsPakDeliveries]].
 *
 * @see LocationsPakDeliveries
 */
class LocationsPakDeliveriesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return LocationsPakDeliveries[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return LocationsPakDeliveries|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
