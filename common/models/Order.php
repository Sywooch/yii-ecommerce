<?php

namespace webdoka\yiiecommerce\common\models;

use webdoka\yiiecommerce\common\models\Profiles;
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
 * @property integer $profile_id
 * @property integer $payment_type_id
 * @property float $total
 *
 * @property OrderItem[] $orderItems
 */
class Order extends \yii\db\ActiveRecord
{

    const STATUS_AWAITING_PAYMENT = 'Awaiting payment';
    const STATUS_PAID = 'Paid';
    const STATUS_DELIVERY = 'Delivery';
    const STATUS_DONE = 'Done';
    const STATUS_CANCEL = 'Cancel';
    const STATUS_EXPIRED = 'Expired';
    const LIST_ORDER = 'shopListOrder';
    const VIEW_ORDER = 'shopViewOrder';
    const CREATE_ORDER = 'shopCreateOrder';
    const UPDATE_ORDER = 'shopUpdateOrder';
    const DELETE_ORDER = 'shopDeleteOrder';

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
            [['status', 'profile_id', 'payment_type_id'], 'required'],
            [['created_at', 'updated_at', 'profile_id', 'payment_type_id'], 'integer'],
            [['status'], 'string', 'max' => 255],
            [['payment_type_id'], 'exist', 'skipOnError' => false, 'targetClass' => PaymentType::className(), 'targetAttribute' => ['payment_type_id' => 'id']],
            [['profile_id'], 'exist', 'skipOnError' => false, 'targetClass' => Profiles::className(), 'targetAttribute' => ['profile_id' => 'id']],
            [['total'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'status' => Yii::t('shop', 'Status'),
            'profile_id' => Yii::t('shop', 'Profile'),
            'payment_type_id' => Yii::t('shop', 'Payment Type'),
            'total' => Yii::t('shop', 'Total'),
            'created_at' => Yii::t('shop', 'Created At'),
            'updated_at' => Yii::t('shop', 'Updated At'),
            'paymentType' => Yii::t('shop', 'Payment Type'),
            'country' => Yii::t('shop', 'Country'),
            'tax' => Yii::t('shop', 'Tax'),
        ];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->status = self::STATUS_AWAITING_PAYMENT;
        }

        return parent::beforeValidate();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(Profiles::className(), ['id' => 'profile_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecipient()
    {
        return $this->hasOne(Profiles::className(), ['id' => 'recipient_id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaymentType()
    {
        return $this->hasOne(PaymentType::className(), ['id' => 'payment_type_id']);
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
    public function getOrderSets()
    {
        return $this->hasMany(OrderSet::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderHistory()
    {
        return $this->hasMany(OrderHistory::className(), ['order_id' => 'id'])->orderBy(['id' => 'ASC']);
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
     * @return \yii\db\ActiveQuery
     */
    public function getOrdersTransactions()
    {
        return $this->hasMany(OrderTransaction::className(), ['order_id' => 'id']);
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

        if ($this->isRelationPopulated('orderSets')) {
            if ($this->isNewRecord) {
                $this->unlinkAll('orderSets');
            }
            foreach ($relatedRecords['orderSets'] as $relatedRecord) {
                $this->link('orderSets', $relatedRecord);
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

        if (array_key_exists('status', $changedAttributes)) {
            $orderHistory = new OrderHistory();
            $orderHistory->order_id = $this->id;
            $orderHistory->status = $this->status;
            $orderHistory->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_AWAITING_PAYMENT => self::STATUS_AWAITING_PAYMENT,
            self::STATUS_PAID => self::STATUS_PAID,
            self::STATUS_DELIVERY => self::STATUS_DELIVERY,
            self::STATUS_DONE => self::STATUS_DONE,
            self::STATUS_CANCEL => self::STATUS_CANCEL,
            self::STATUS_EXPIRED => self::STATUS_EXPIRED,
        ];
    }

}
