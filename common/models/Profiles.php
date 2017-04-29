<?php

namespace webdoka\yiiecommerce\common\models;

use webdoka\yiiecommerce\common\queries\ProfilesQuery;
use app\models\User;
use Yii;

/**
 * This is the model class for table "profiles".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $default_account_id
 * @property string $type
 * @property string $name
 * @property string $last_name
 * @property string $ur_name
 * @property string $legal_adress
 * @property string $country
 * @property string $region
 * @property string $city
 * @property string $individual_adress
 * @property string $inn
 * @property string $phone
 * @property integer $status
 *
 * @property Accounts[] $accounts
 * @property Carts[] $carts
 * @property Orders[] $orders
 * @property Users $user
 */
class Profiles extends \yii\db\ActiveRecord
{
    

    const LIST_PRODUCT = 'shopListProduct';
    const VIEW_PRODUCT = 'shopViewProduct';
    const CREATE_PRODUCT = 'shopCreateProduct';
    const UPDATE_PRODUCT = 'shopUpdateProduct';
    const DELETE_PRODUCT = 'shopDeleteProduct';

    const INDIVIDUAL_TYPE = 'individual';
    const LEGAL_TYPE = 'legal';

    const STATUS_CUSTOMER = 0;
    const STATUS_RECIPIENT = 1;

    public $bothprofiles = 1;
    public $from;
    public $to;

    public static function getTypeLists()
    {
        return [
        self::INDIVIDUAL_TYPE => Yii::t('shop', 'Individual'),
        self::LEGAL_TYPE => Yii::t('shop', 'Legal'),
        ];
    }

    public static function getStatusLists()
    {
        return [
        self::STATUS_CUSTOMER => Yii::t('shop', 'Customer'),
        self::STATUS_RECIPIENT => Yii::t('shop', 'Recipient'),
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'profiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'profile_name', 'name', 'country', 'city', 'individual_adress', 'phone'], 'required'],
            [['user_id', 'default_account_id', 'status', 'parent_profile'], 'integer'],
            [['type'], 'string'],
            [['profile_name', 'name', 'last_name', 'ur_name', 'legal_adress', 'country', 'region', 'city', 'individual_adress', 'inn', 'phone'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'user_id' => Yii::t('shop', 'User ID'),
            'default_account_id' => Yii::t('shop', 'Default Account ID'),
            'type' => Yii::t('shop', 'Type'),
            'profile_name' => Yii::t('shop', 'Profile name'),
            'name' => Yii::t('shop', 'Name'),
            'last_name' => Yii::t('shop', 'Last Name'),
            'ur_name' => Yii::t('shop', 'Legal Name'),
            'legal_adress' => Yii::t('shop', 'Legal Adress'),
            'country' => Yii::t('shop', 'Country'),
            'region' => Yii::t('shop', 'Region'),
            'city' => Yii::t('shop', 'City'),
            'individual_adress' => Yii::t('shop', 'Individual Adress'),
            'inn' => Yii::t('shop', 'Inn'),
            'phone' => Yii::t('shop', 'Phone'),
            'status' => Yii::t('shop', 'Status'),
            "bothprofiles" => Yii::t('shop', 'The customer and the recipient are the same?'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Accounts::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Carts::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['profile_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['parent_profile' => 'id']);
    }    

    /**
     * @inheritdoc
     * @return ProfilesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfilesQuery(get_called_class());
    }
}
