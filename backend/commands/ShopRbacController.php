<?php

namespace webdoka\yiiecommerce\backend\commands;

use yii\console\Controller;

class ShopRbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        $actions = [];

        $listProperty = $auth->createPermission('shopListProperty');
        $listProperty->description = 'List shop property';
        $viewProperty = $auth->createPermission('shopViewProperty');
        $viewProperty->description = 'View shop property';
        $createProperty = $auth->createPermission('shopCreateProperty');
        $createProperty->description = 'Create shop property';
        $updateProperty = $auth->createPermission('shopUpdateProperty');
        $updateProperty->description = 'Update shop property';
        $deleteProperty = $auth->createPermission('shopDeleteProperty');
        $deleteProperty->description = 'Delete shop property';

        $actions[] = $listProperty;
        $actions[] = $viewProperty;
        $actions[] = $createProperty;
        $actions[] = $updateProperty;
        $actions[] = $deleteProperty;
        
        $listUnit = $auth->createPermission('shopListUnit');
        $listUnit->description = 'List shop unit';
        $viewUnit = $auth->createPermission('shopViewUnit');
        $viewUnit->description = 'View shop unit';
        $createUnit = $auth->createPermission('shopCreateUnit');
        $createUnit->description = 'Create shop unit';
        $updateUnit = $auth->createPermission('shopUpdateUnit');
        $updateUnit->description = 'Update shop unit';
        $deleteUnit = $auth->createPermission('shopDeleteUnit');
        $deleteUnit->description = 'Delete shop unit';

        $actions[] = $listUnit;
        $actions[] = $viewUnit;
        $actions[] = $createUnit;
        $actions[] = $updateUnit;
        $actions[] = $deleteUnit;
        
        $listAccount = $auth->createPermission('shopListAccount');
        $listAccount->description = 'List shop account';
        $viewAccount = $auth->createPermission('shopViewAccount');
        $viewAccount->description = 'View shop account';
        $createAccount = $auth->createPermission('shopCreateAccount');
        $createAccount->description = 'Create shop account';
        $updateAccount = $auth->createPermission('shopUpdateAccount');
        $updateAccount->description = 'Update shop account';
        $deleteAccount = $auth->createPermission('shopDeleteAccount');
        $deleteAccount->description = 'Delete shop account';

        $actions[] = $listAccount;
        $actions[] = $viewAccount;
        $actions[] = $createAccount;
        $actions[] = $updateAccount;
        $actions[] = $deleteAccount;
        
        $listCurrency = $auth->createPermission('shopListCurrency');
        $listCurrency->description = 'List shop currency';
        $viewCurrency = $auth->createPermission('shopViewCurrency');
        $viewCurrency->description = 'View shop currency';
        $createCurrency = $auth->createPermission('shopCreateCurrency');
        $createCurrency->description = 'Create shop currency';
        $updateCurrency = $auth->createPermission('shopUpdateCurrency');
        $updateCurrency->description = 'Update shop currency';
        $deleteCurrency = $auth->createPermission('shopDeleteCurrency');
        $deleteCurrency->description = 'Delete shop currency';

        $actions[] = $listCurrency;
        $actions[] = $viewCurrency;
        $actions[] = $createCurrency;
        $actions[] = $updateCurrency;
        $actions[] = $deleteCurrency;
        
        $listDelivery = $auth->createPermission('shopListDelivery');
        $listDelivery->description = 'List shop delivery';
        $viewDelivery = $auth->createPermission('shopViewDelivery');
        $viewDelivery->description = 'View shop delivery';
        $createDelivery = $auth->createPermission('shopCreateDelivery');
        $createDelivery->description = 'Create shop delivery';
        $updateDelivery = $auth->createPermission('shopUpdateDelivery');
        $updateDelivery->description = 'Update shop delivery';
        $deleteDelivery = $auth->createPermission('shopDeleteDelivery');
        $deleteDelivery->description = 'Delete shop delivery';

        $actions[] = $listDelivery;
        $actions[] = $viewDelivery;
        $actions[] = $createDelivery;
        $actions[] = $updateDelivery;
        $actions[] = $deleteDelivery;
        
        $listStorage = $auth->createPermission('shopListStorage');
        $listStorage->description = 'List shop storage';
        $viewStorage = $auth->createPermission('shopViewStorage');
        $viewStorage->description = 'View shop storage';
        $createStorage = $auth->createPermission('shopCreateStorage');
        $createStorage->description = 'Create shop storage';
        $updateStorage = $auth->createPermission('shopUpdateStorage');
        $updateStorage->description = 'Update shop storage';
        $deleteStorage = $auth->createPermission('shopDeleteStorage');
        $deleteStorage->description = 'Delete shop storage';

        $actions[] = $listStorage;
        $actions[] = $viewStorage;
        $actions[] = $createStorage;
        $actions[] = $updateStorage;
        $actions[] = $deleteStorage;
        
        $listLocation = $auth->createPermission('shopListLocation');
        $listLocation->description = 'List shop locations';
        $viewLocation = $auth->createPermission('shopViewLocation');
        $viewLocation->description = 'View shop location';
        $createLocation = $auth->createPermission('shopCreateLocation');
        $createLocation->description = 'Create shop location';
        $updateLocation = $auth->createPermission('shopUpdateLocation');
        $updateLocation->description = 'Update shop location';
        $deleteLocation = $auth->createPermission('shopDeleteLocation');
        $deleteLocation->description = 'Delete shop location';

        $actions[] = $listLocation;
        $actions[] = $viewLocation;
        $actions[] = $createLocation;
        $actions[] = $updateLocation;
        $actions[] = $deleteLocation;
        
        $listFeature = $auth->createPermission('shopListFeature');
        $listFeature->description = 'List shop features';
        $viewFeature = $auth->createPermission('shopViewFeature');
        $viewFeature->description = 'View shop feature';
        $createFeature = $auth->createPermission('shopCreateFeature');
        $createFeature->description = 'Create shop feature';
        $updateFeature = $auth->createPermission('shopUpdateFeature');
        $updateFeature->description = 'Update shop feature';
        $deleteFeature = $auth->createPermission('shopDeleteFeature');
        $deleteFeature->description = 'Delete shop feature';

        $actions[] = $listFeature;
        $actions[] = $viewFeature;
        $actions[] = $createFeature;
        $actions[] = $updateFeature;
        $actions[] = $deleteFeature;

        $listCategory = $auth->createPermission('shopListCategory');
        $listCategory->description = 'List shop categories';
        $viewCategory = $auth->createPermission('shopViewCategory');
        $viewCategory->description = 'View shop category';
        $createCategory = $auth->createPermission('shopCreateCategory');
        $createCategory->description = 'Create shop category';
        $updateCategory = $auth->createPermission('shopUpdateCategory');
        $updateCategory->description = 'Update shop category';
        $deleteCategory = $auth->createPermission('shopDeleteCategory');
        $deleteCategory->description = 'Delete shop category';

        $actions[] = $listCategory;
        $actions[] = $viewCategory;
        $actions[] = $createCategory;
        $actions[] = $updateCategory;
        $actions[] = $deleteCategory;

        $listProduct = $auth->createPermission('shopListProduct');
        $listProduct->description = 'List shop products';
        $viewProduct = $auth->createPermission('shopViewProduct');
        $viewProduct->description = 'View shop product';
        $createProduct = $auth->createPermission('shopCreateProduct');
        $createProduct->description = 'Create shop product';
        $updateProduct = $auth->createPermission('shopUpdateProduct');
        $updateProduct->description = 'Update shop product';
        $deleteProduct = $auth->createPermission('shopDeleteProduct');
        $deleteProduct->description = 'Delete shop product';

        $actions[] = $listProduct;
        $actions[] = $viewProduct;
        $actions[] = $createProduct;
        $actions[] = $updateProduct;
        $actions[] = $deleteProduct;

        foreach ($actions as $action) {
            $auth->add($action);
        }
    }
}