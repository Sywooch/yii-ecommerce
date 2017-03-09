<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\Discount;

/**
 * This is the ActiveQuery class for [[Discount]].
 *
 * @see Discount
 */
class DiscountQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return Discount[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Discount|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * Scope for date range
     */
    public function available() {
        $this->andWhere('started_at IS NULL OR started_at <= NOW()');
        $this->andWhere('finished_at IS NULL OR finished_at >= NOW()');

        return $this;
    }

    /**
     * @return $this
     */
    public function set() {
        return $this->andWhere(['dimension' => Discount::SET_DIMENSION]);
    }

    /**
     * @return $this
     */
    public function percent() {
        return $this->andWhere(['dimension' => Discount::PERCENT_DIMENSION]);
    }

    /**
     * @return $this
     */
    public function fixed() {
        return $this->andWhere(['dimension' => Discount::FIXED_DIMENSION]);
    }

}
