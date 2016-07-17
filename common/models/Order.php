<?php

namespace webdoka\yiiecommerce\common\models;

use app\models\User;
use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $notes
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $user_id
 *
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 'New';
    const STATUS_IN_PROGRESS = 'In progress';
    const STATUS_DONE = 'Done';


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'user_id'], 'required'],
            [['created_at', 'updated_at', 'user_id'], 'integer'],
            [['status'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => false, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
            'user_id' => 'User',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->status = self::STATUS_NEW;
        }

        return parent::beforeValidate();
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
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersProperties()
    {
        return $this->hasMany(OrderProperty::className(), ['order_id' => 'id']);
    }

    /**
     * @return $this
     */
    public function getProperties()
    {
        return $this->hasMany(Property::className(), ['id' => 'property_id'])->via('ordersProperties');
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $relatedRecords = $this->getRelatedRecords();

        if ($this->isRelationPopulated('orderItems')) {
            if ($this->isNewRecord) {
                $this->unlinkAll('orderItems');
            }
            foreach ($relatedRecords['orderItems'] as $relatedRecord) {
                $this->link('orderItems', $relatedRecord);
            }
        }

        if ($this->isRelationPopulated('ordersProperties')) {
            if ($this->isNewRecord) {
                $this->unlinkAll('ordersProperties');
            }
            foreach ($relatedRecords['ordersProperties'] as $relatedRecord) {

                $this->link('ordersProperties', $relatedRecord, ['value' => $relatedRecord->value]);
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }
}
