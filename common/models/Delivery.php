<?php

namespace webdoka\yiiecommerce\common\models;

use webdoka\yiiecommerce\common\queries\DeliveryQuery;
use webdoka\yiiecommerce\common\models\DeliveriesLocationsPak;
use webdoka\yiiecommerce\common\models\DeliveriDiscount;
use webdoka\yiiecommerce\common\models\DeliverieHasDiscount;
use Yii;

/**
 * This is the model class for table "delivery".
 *
 * @property integer $id
 * @property string $uid
 * @property string $name
 * @property double $cost
 * @property integer $storage_id
 *
 * @property Location $location
 */
class Delivery extends UidModel
{

    const LIST_DELIVERY = 'shopListDelivery';
    const VIEW_DELIVERY = 'shopViewDelivery';
    const CREATE_DELIVERY = 'shopCreateDelivery';
    const UPDATE_DELIVERY = 'shopUpdateDelivery';
    const DELETE_DELIVERY = 'shopDeleteDelivery';
    
    const TYPE_EXWORKS = 0; 
    const TYPE_POST = 1;
    const TYPE_COURIER = 2;
   
    public static function getTypeLists()
    {
        return [
        self::TYPE_EXWORKS => Yii::t('shop', 'Ex Works'),
        self::TYPE_POST => Yii::t('shop', 'Post'),
        self::TYPE_COURIER => Yii::t('shop', 'Courier'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deliveries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'cost'], 'required'],
            [['cost'], 'number'],
            [['storage_id','pak_id','type'], 'integer'],
            [['uid', 'name'], 'string', 'max' => 255],
            [['storage_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storage::className(), 'targetAttribute' => ['storage_id' => 'id']],
            [['pak_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeliveriesLocationsPak::className(), 'targetAttribute' => ['pak_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('shop', 'ID'),
            'uid' => Yii::t('shop', 'Uid'),
            'name' => Yii::t('shop', 'Name'),
            'cost' => Yii::t('shop', 'Cost'),
            'storage_id' => Yii::t('shop', 'Storage ID'),
            'pak_id' => Yii::t('shop', 'Deliveries locations paks'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorage()
    {
        return $this->hasOne(Storage::className(), ['id' => 'storage_id']);
    }


    /**
     * Returns product discounts
     * @return \yii\db\ActiveQuery
     */
    public function getDeliverieHasDiscount()
    {
        return $this->hasMany(DeliverieHasDiscount::className(), ['deliveri_id' => 'id']);
    }    

    /**
     * Returns discounts
     * @return \yii\db\ActiveQuery
     */
    public function getDiscounts()
    {
        return $this->hasMany(DeliveriDiscount::className(), ['id' => 'discount_id'])
            //->andWhere(['dimension' => Discount::SET_DIMENSION])
            ->via('deliverieHasDiscount');
    }    

    /**
     * @inheritdoc
     * @return DeliveryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DeliveryQuery(get_called_class());
    }

    /**
     * After save get related records, and unlink/link them if it needs.
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes)
    {
        $relatedRecords = $this->getRelatedRecords();

        if (array_key_exists('deliverieHasDiscount', $relatedRecords)) {
            $this->unlinkAll('deliverieHasDiscount', true);
            foreach ($relatedRecords['deliverieHasDiscount'] as $discount) {
                $this->link('deliverieHasDiscount', $discount);
            }
        }
    }


}
