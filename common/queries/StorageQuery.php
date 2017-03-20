<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\Storage;

/**
 * This is the ActiveQuery class for [[Storage]].
 *
 * @see Storage
 */
class StorageQuery extends \yii\db\ActiveQuery
{
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return Storage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Storage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
