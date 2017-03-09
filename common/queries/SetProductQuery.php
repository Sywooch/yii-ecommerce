<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\SetProduct;

/**
 * This is the ActiveQuery class for [[SetProduct]].
 *
 * @see SetProduct
 */
class SetProductQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return SetProduct[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return SetProduct|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
