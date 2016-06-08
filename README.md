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

Run migrations `yii migrate --migrationPath=vendor/webdoka/yii-ecommerce/migrations`

Add module to `config/web.php`:
```
'modules' => [
    'shop' => [
        'class' => 'webdoka\yiiecommerce\Module',
    ],
],
```
Add component cart to `config/web.php`:
```
'components' => [
    'cart' => [
        'class' => 'webdoka\yiiecommerce\components\Cart'
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
            '<module:shop>/' => '<module>/catalog/index',
            '<module:shop>/catalog/<category:\w+>' => '<module>/catalog/index',
        ],
    ],
```
If php has not installed ext_intl, specify currency symbol manually:
```
'formatter' => [
    'class' => 'yii\i18n\Formatter',
    'numberFormatterSymbols' => [
        NumberFormatter::CURRENCY_SYMBOL => '&dollar; ',
    ]
],
```
To change theme you can use Yii2 view component, added to `config/web.php` following:
```
'components' => [
    ...,
    'view' => [
        'theme' => [
            'pathMap' => [
                '@vendor/webdoka/yii-ecommerce/views' => '@app/views', // "@app/view" You can specify path to your theme path
            ],
        ],
    ],
```
Now can access url `http://example/shop/`