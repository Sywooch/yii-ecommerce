<?php

namespace webdoka\yiiecommerce\common\queries;

use webdoka\yiiecommerce\common\models\Invoice;

/**
 * This is the ActiveQuery class for [[Invoice]].
 *
 * @see Invoice
 */
class InvoiceQuery extends \yii\db\ActiveQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * @inheritdoc
     * @return Invoice[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Invoice|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    /**
     * @return $this
     */
    public function pending() {
        return $this->andWhere(['status' => Invoice::PENDING_STATUS]);
    }

    /**
     * @return $this
     */
    public function success() {
        return $this->andWhere(['status' => Invoice::SUCCESS_STATUS]);
    }

    /**
     * @return $this
     */
    public function fail() {
        return $this->andWhere(['status' => Invoice::FAIL_STATUS]);
    }

}
