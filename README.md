# E-commerce модуль для Yii 2
### Installing

Add following to `composer.json`:

```
"repositories": [
    {
      "url": "https://github.com/webdoka/yii-ecommerce",
      "type": "git"
    },
    ...
  ],
```
```
"require-dev": {
    "webdoka/yii-ecommerce": "*",
    ...
  },
```

Run migrations `yii migrate --migrationPath=vendor/webdoka/yii-ecommerce/common/migrations`

Add module to `config/web.php`:
```
'modules' => [
    'shop' => [
        'class' => 'webdoka\yiiecommerce\frontend\Module',
    ],
],
```
Add components cart and billing to `config/web.php`:
```
'components' => [
    'cart' => [
        'class' => 'webdoka\yiiecommerce\common\components\Cart'
    ],
    'billing' => [
        'class' => 'webdoka\yiiecommerce\common\components\Billing'
    ],
    'robokassa' => [
        'class' => 'webdoka\yiiecommerce\common\components\Robokassa',
        'shopId' => 'SHOP_ID',
        'password1' => 'PASSWORD1',
        'password2' => PASSWORD2'',
        'testPassword1' => 'TEST_PASSWORD1',
        'testPassword2' => 'TEST_PASSWORD2',
    ],
    ...
]
```
Add default route for module:
```
'components' => [
    ...,
    'urlManager' => [
        ...,
        'suffix' => '/',
        'rules' => [
            '<module:shop>/catalog/<category:\w+>' => '<module>/catalog/index',
        ],
    ],
```
Shop module uses formatting, install intl if not yet `sudo apt-get install php5-intl` and restart server. Add following to `config/web.php`:
```
'components' => [
    ...,
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'numberFormatterSymbols' => [
            NumberFormatter::CURRENCY_SYMBOL => '&dollar; ',
        ]
    ],
],
```
To change theme you can use Yii2 view component, added to `config/web.php` following:
```
'components' => [
    ...,
    'view' => [
        'theme' => [
            'pathMap' => [
                '@vendor/webdoka/yii-ecommerce/frontend/views' => '@app/views', // "@app/views" You can specify path to your theme path
            ],
        ],
    ],
```
For RBAC need add to `config/web.php` and `config/console.php` following:
```
'components' => [
    ...,
    'authManager' => [
        'class' => 'yii\rbac\DbManager', // Or you can use PhpManager
    ],
],
```
If you still use DbManager need run migration `yii migrate --migrationPath=@yii/rbac/migrations`.
After that, you need set module `shop` in your `config/console.php`:
```
'bootstrap' => [
        ...,
        'shop'
    ],
'modules' => [
    'shop' => [
        'class' => 'webdoka\yiiecommerce\backend\Module',
    ],
],
```
And now run command `yii shop-rbac/init`.

Now can access url `http://example/shop/`

### Shop admin
Shop is divided to two modules (frontend, backend). Usually, admin panel is in a separate module `admin`, where you can integrate our shop admin.
```
public function init()
{
    parent::init();
   ...
    $this->setModule('shop', 'webdoka\yiiecommerce\backend\Module');
}
```
And now, it's access in `/admin/shop/`, `/admin/shop/feature/`, `/admin/shop/feature/create` and so on.

