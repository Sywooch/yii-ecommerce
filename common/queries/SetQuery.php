<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\Set;

/**
 * This is the ActiveQuery class for [[Set]].
 *
 * @see Set
 */
class SetQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return Set[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Set|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
