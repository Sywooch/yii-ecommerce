<?php

namespace webdoka\yiiecommerce\common\models;

use app\models\Profile;
use Yii;
use webdoka\yiiecommerce\common\queries\PropertyQuery;
use yii\base\Exception;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * This is the model class for table "properties".
 *
 * @property integer $id
 * @property string $label
 * @property string $name
 * @property string $type
 * @property integer $required
 *
 * @property OrderProperty[] $ordersProperties
 */
class Property extends \yii\db\ActiveRecord
{

    const INPUT_TYPE = 'input';
    const CHECKBOX_TYPE = 'checkbox';
    const TEXTAREA_TYPE = 'textarea';
    const LIST_PROPERTY = 'shopListProperty';
    const VIEW_PROPERTY = 'shopViewProperty';
    const CREATE_PROPERTY = 'shopCreateProperty';
    const UPDATE_PROPERTY = 'shopUpdateProperty';
    const DELETE_PROPERTY = 'shopDeleteProperty';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'properties';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'name', 'profile_type'], 'required'],
            [['type'], 'string'],
            [['profile_type'], 'string'],
            [['required'], 'integer'],
            [['label', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'label' => Yii::t('shop', 'Label'),
            'name' => Yii::t('shop', 'Name'),
            'type' => Yii::t('shop', 'Type'),
            'profile_type' => Yii::t('shop', 'Profile type'),
            'required' => Yii::t('shop', 'Required'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersProperties()
    {
        return $this->hasMany(OrderProperty::className(), ['property_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PropertyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PropertyQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [
            self::INPUT_TYPE => ucfirst(self::INPUT_TYPE),
            self::CHECKBOX_TYPE => ucfirst(self::CHECKBOX_TYPE),
            self::TEXTAREA_TYPE => ucfirst(self::TEXTAREA_TYPE),
        ];
    }

    /**
     * @return array
     */
    public static function getProfileTypes()
    {
        return Profile::getTypes();
    }

}
