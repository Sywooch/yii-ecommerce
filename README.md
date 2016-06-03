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
        ],
    ],
```