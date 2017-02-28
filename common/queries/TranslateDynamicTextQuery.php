<?php

namespace webdoka\yiiecommerce\common\queries;
use webdoka\yiiecommerce\common\models\TranslateDynamicText;
/**
 * This is the ActiveQuery class for [[TranslateDynamicText]].
 *
 * @see TranslateDynamicText
 */
class TranslateDynamicTextQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return TranslateDynamicText[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TranslateDynamicText|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
