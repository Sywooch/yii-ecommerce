<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\DeliveriesLocationsPak;
use webdoka\yiiecommerce\common\models\LocationsPakDeliveries;

/**
 * This is the ActiveQuery class for [[DeliveriesLocationsPak]].
 *
 * @see DeliveriesLocationsPak
 */
class DeliveriesLocationsPakQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return DeliveriesLocationsPak[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return DeliveriesLocationsPak|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
