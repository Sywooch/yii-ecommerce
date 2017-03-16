<?php

namespace webdoka\yiiecommerce\common\components;

use Yii;
use yii\helpers\Url;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;


class Paypal extends Component
{
    /**
     * Last error message(s)
     * @var array
     */
    protected $_errors = [];


    public $user;

    public $pwd;

    public $signature;

    public $version;

    public $endPoint = 'https://api-3t.sandbox.paypal.com/nvp';

    public $successURL = '/shop/paypal/success';

    public $cancelURL = '/shop/paypal/cancelled';

    public $merchantUrl = 'https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit';

    /**
     * Make API request
     *
     * @param string $method string API method to request
     * @param array $params Additional request parameters
     * @return array / boolean Response array / boolean false on failure
     */
    public function request($method, $params = array())
    {

        $this->_errors = array();

        if (empty($method)) {
            $this->_errors = ['API method is missing'];
            return false;
        }

        $credentials = [
            'USER' => $this->user,
            'PWD' => $this->pwd,
            'SIGNATURE' => $this->signature,
        ];

        if (isset($params['order_id'])) {

            $requestUrl = [
                'RETURNURL' => Url::to([$this->successURL, 'uid' => Yii::$app->user->id, 'order_id' => $params['order_id']], true),
                'CANCELURL' => Url::to([$this->cancelURL, 'uid' => Yii::$app->user->id, 'order_id' => $params['order_id']], true)
            ];

            unset($params['order_id']);

        } else {


            $requestUrl = [
                'RETURNURL' => Url::to([$this->successURL, 'uid' => Yii::$app->user->id], true),
                'CANCELURL' => Url::to([$this->cancelURL, 'uid' => Yii::$app->user->id], true)
            ];

        }


        $requestParams = [
            'METHOD' => $method,
            'VERSION' => $this->version
        ];

        $query = ArrayHelper::merge($requestParams, $credentials, $requestUrl, $params);


        $request = http_build_query($query);

        $curlOptions = array(
            CURLOPT_URL => $this->endPoint,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_SSL_VERIFYHOST => FALSE,
            CURLOPT_SSLVERSION => 'CURL_SSLVERSION_TLSv1_2',
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $request
        );

        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $this->_errors = curl_error($ch);
            curl_close($ch);
            //return $this->_errors;
            return false;

        } else {
            curl_close($ch);
            $responseArray = [];
            parse_str($response, $responseArray);
            return $responseArray;
        }
    }

    public function redirect($token)
    {
        Yii::$app->getResponse()->redirect($this->merchantUrl . '&token=' . urlencode($token));
    }

}