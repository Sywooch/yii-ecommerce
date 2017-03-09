<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\ProductsOptions;
use creocoder\nestedsets\NestedSetsQueryBehavior;
use Yii;

/**
 * This is the ActiveQuery class for [[ProductsOptions]].
 *
 * @see ProductsOptions
 */
class ProductsOptionsQuery extends \yii\db\ActiveQuery {

    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

    public function active() {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return ProductsOptions[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductsOptions|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
