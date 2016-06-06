# E-commerce модуль для Yii 2
### Installing

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
To change theme you can use Yii2 view component for this:
```
'components' => [
    ...,
    'view' => [
        'theme' => [
            'pathMap' => [
                '@vendor/webdoka/yii-ecommerce/views' => '@app/views',
            ],
        ],
    ],
```