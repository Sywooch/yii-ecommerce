<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\ProductsOptionsPrices;

/**
 * This is the ActiveQuery class for [[ProductsOptionsPrices]].
 *
 * @see ProductsOptionsPrices
 */
class ProductsOptionsPricesQuery extends \yii\db\ActiveQuery {

    public function active() {
        return $this->andWhere('[[status]]=1');
    }

    /**
     * @inheritdoc
     * @return ProductsOptionsPrices[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProductsOptionsPrices|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

}
