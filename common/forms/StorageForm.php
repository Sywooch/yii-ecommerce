<?php

namespace webdoka\yiiecommerce\common\forms;

use webdoka\yiiecommerce\common\models\Location;
use webdoka\yiiecommerce\common\models\Storage;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * Class StorageForm
 * @package webdoka\yiiecommerce\common\forms
 */
class StorageForm extends Storage
{
    public
        $country,
        $city,
        $address,
        $iconImage;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge([
            [['country', 'city', 'address'], 'required'],
            [['address'], 'integer'],
            [['country', 'city'], 'string', 'max' => 255],
            [['iconImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ], parent::rules());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country' => 'Country',
            'city' => 'City',
            'street' => 'Address',
        ];
    }

    /**
     * Uploads icon
     * @return bool
     */
    public function upload()
    {
        if ($this->validate() && $this->iconImage) {
            $this->iconImage->saveAs(
                Yii::getAlias('@webroot/uploads/' . $this->iconImage->baseName . '.' . $this->iconImage->extension)
            );
            return true;
        } else {
            return false;
        }
    }

    /**
     * Sets icon as instance
     * @return bool
     */
    public function beforeValidate()
    {
        if (Yii::$app->request->isPost) {
            $this->iconImage = UploadedFile::getInstance($this, 'iconImage');
        }

        return parent::beforeValidate();
    }

    /**
     * Sets icon as path
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if ($this->upload()) {
            $this->icon = $this->iconImage ? $this->iconImage->baseName . '.' . $this->iconImage->extension : null;
            return true;
        }

        return parent::beforeSave($insert);
    }

    /**
     * Returns all countries
     * @return array
     */
    public static function getCountries()
    {
        return Location::find()
            ->select('country')
            ->indexBy('country')
            ->orderBy(['country' => 'asc'])
            ->column();
    }

    /**
     * Returns all cities by country
     * @param $country
     * @return array
     */
    public static function getCitiesByCountry($country)
    {
        return Location::find()
            ->where(['country' => $country])
            ->select('city')
            ->indexBy('city')
            ->orderBy(['city' => 'asc'])
            ->column();
    }

    /**
     * Returns all addresses by country and city
     * @param $country
     * @return array
     */
    public static function getAddressByCountryAndCity($country, $city)
    {
        return Location::find()
            ->where([
                'country' => $country,
                'city' => $city,
            ])
            ->select('address, id')
            ->indexBy('id')
            ->orderBy(['address' => 'asc'])
            ->column();
    }

    /**
     * Returns all storages by country and city
     * @param $country
     * @return array
     */
    public static function getStoragesByCountryAndCity($country, $city)
    {
        return Storage::find()
            ->alias('t')
            ->joinWith('location l')
            ->where([
                'l.country' => $country,
                'l.city' => $city,
            ])
            ->select('t.name as tname, t.id as tid')
            ->indexBy('tid')
            ->orderBy(['tname' => 'asc'])
            ->column();
    }
}