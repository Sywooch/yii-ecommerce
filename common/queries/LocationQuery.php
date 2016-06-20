<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\Location;

/**
 * This is the ActiveQuery class for [[Location]].
 *
 * @see Locations
 */
class LocationQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Location[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Location|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
