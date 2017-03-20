<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\OrderHistory;

/**
 * This is the ActiveQuery class for [[OrderHistory]].
 *
 * @see OrderHistory
 */
class OrderHistoryQuery extends \yii\db\ActiveQuery
{
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return OrderHistory[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return OrderHistory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
