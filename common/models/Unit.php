<?php

namespace webdoka\yiiecommerce\common\models;

use Yii;

/**
 * This is the model class for table "units".
 *
 * @property integer $id
 * @property string $uid
 * @property string $name
 *
 * @property Product[] $products
 */
class Unit extends UidModel
{
    const LIST_UNIT = 'shopListUnit';
    const VIEW_UNIT = 'shopViewUnit';
    const CREATE_UNIT = 'shopCreateUnit';
    const UPDATE_UNIT = 'shopUpdateUnit';
    const DELETE_UNIT = 'shopDeleteUnit';
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'units';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['uid', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasMany(Product::className(), ['unit_id' => 'id']);
    }
}