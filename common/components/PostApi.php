<?php
/*
*
*
<?php
use webdoka\yiiecommerce\common\components\PostApi;

    $postApi = new PostApi();
Определяем код города
		$from = $postApi->getCodeCity('Москва');
Определяем код регионап
        $to = $postApi->getCodeRegion('Курская область');
Определяем код страны
        $country = $postApi->getCodeCountry('Украина');
Расчитывем стоимость посылки, параметры 1 куда, 2 вес, откуда(не обязательный при международный пересылках)
        $request = $postApi->getCalculate($country, '1,5', $from);
Определяем макимально допустимый вес
        echo $postApi->getMaxWeight();

                var_dump($request);

?>
*
*
*/


namespace webdoka\yiiecommerce\common\components;

use yii\base\Component;
use yii\di\Instance;
use linslin\yii2\curl;
use yii\helpers\ArrayHelper;

/**
 * Class Cart
 * @package webdoka\yiiecommerce\common\components
 */
class PostApi extends Component
{

    public $curl;
    public $APIurl = 'http://emspost.ru/api/rest/';
    /**
     * Init positions
     */
    public function init()
    {
        $this->curl = new curl\Curl();
    }


    private function getLocations($type)
    {
        $response = $this->curl->setGetParams(
            [
            'method' => 'ems.get.locations',
            'type' => $type,
            'plain'=>'true'
            ]
        )
        ->get($this->APIurl);
        return $response;
    }

    public function getCalculate($to, $weight, $from = null)
    {
        if ($from != null) {
            $reqfrom=['from'=>$from];
        } else {
            $reqfrom=[];
        }

        $req=[
        'method' => 'ems.calculate',
        'type' => 'att',
        'to'=>$to,
        'weight'=>$weight
        ];

        $response = $this->curl->setGetParams(
            ArrayHelper::merge($reqfrom, $req)
        )
        ->get($this->APIurl);
        return json_decode($response, true);
    }

    public function getMaxWeight()
    {

        $response = $this->curl->setGetParams(
            [
            'method' => 'ems.get.max.weight'
            ]
        )
        ->get($this->APIurl);
        return json_decode($response, true)['rsp']['max_weight'];
    }
    

    public function getCountryes()
    {
        return $this->getLocations('countries');
    }

    public function getRegions()
    {
        return $this->getLocations('regions');
    }

    public function getCityes()
    {
        return $this->getLocations('cities');
    }


    public function getCountryesList()
    {
        return json_decode($this->countryes, true);
    }

    public function getRegionsList()
    {
        return json_decode($this->regions, true);
    }

    public function getCityesList()
    {
        return json_decode($this->cityes, true);
    }


    public function getCodeCountry($country)
    {
        $country = mb_strtoupper($country, "UTF-8");
        $countrys = $this->countryesList;
        if (isset($countrys["rsp"]["stat"]) && $countrys["rsp"]["stat"]=='ok') {
            foreach ($countrys["rsp"]["locations"] as $key => $value) {
                if ($value['name']==$country) {
                    $codcountry = $value['value'];
                }
            }
            return $codcountry;
        } else {
            return false;
        }
    }

    public function getCodeRegion($region)
    {
        $region = mb_strtoupper($region, "UTF-8");
        $regions = $this->regionsList;
        if (isset($regions["rsp"]["stat"]) && $regions["rsp"]["stat"]=='ok') {
            foreach ($regions["rsp"]["locations"] as $key => $value) {
                if ($value['name']==$region) {
                    $codregion = $value['value'];
                }
            }
            return $codregion;
        } else {
            return false;
        }
    }

    public function getCodeCity($city)
    {
        $city = mb_strtoupper($city, "UTF-8");
        $cityes = $this->cityesList;
        if (isset($cityes["rsp"]["stat"]) && $cityes["rsp"]["stat"]=='ok') {
            foreach ($cityes["rsp"]["locations"] as $key => $value) {
                if ($value['name']==$city) {
                    $codcity = $value['value'];
                }
            }
            return $codcity;
        } else {
            return false;
        }
    }
}
