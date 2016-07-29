<?php

namespace webdoka\yiiecommerce\common\components;

use yii\base\Component;

class Robokassa extends Component
{
    const URL = 'https://merchant.roboxchange.com/Index.aspx?MrchLogin=%s&OutSum=%s&OutSumCurrency=%s&InvId=%s&Desc=%s&SignatureValue=%s';

    public
        $shopId = false,
        $password1 = false,
        $password2 = false,
        $testPassword1 = false,
        $testPassword2 = false;
}