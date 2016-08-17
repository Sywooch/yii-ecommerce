<?php

namespace webdoka\yiiecommerce\backend\commands;

use yii\console\Controller;

class ShopRbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        $actions = [];

        $listSet = $auth->createPermission('shopListSet');
        $listSet->description = 'List shop set';
        $viewSet = $auth->createPermission('shopViewSet');
        $viewSet->description = 'View shop set';
        $createSet = $auth->createPermission('shopCreateSet');
        $createSet->description = 'Create shop set';
        $updateSet = $auth->createPermission('shopUpdateSet');
        $updateSet->description = 'Update shop set';
        $deleteSet = $auth->createPermission('shopDeleteSet');
        $deleteSet->description = 'Delete shop set';

        $actions[] = $listSet;
        $actions[] = $viewSet;
        $actions[] = $createSet;
        $actions[] = $updateSet;
        $actions[] = $deleteSet;
        
        $listCountry = $auth->createPermission('shopListCountry');
        $listCountry->description = 'List shop country';
        $viewCountry = $auth->createPermission('shopViewCountry');
        $viewCountry->description = 'View shop country';
        $createCountry = $auth->createPermission('shopCreateCountry');
        $createCountry->description = 'Create shop country';
        $updateCountry = $auth->createPermission('shopUpdateCountry');
        $updateCountry->description = 'Update shop country';
        $deleteCountry = $auth->createPermission('shopDeleteCountry');
        $deleteCountry->description = 'Delete shop country';

        $actions[] = $listCountry;
        $actions[] = $viewCountry;
        $actions[] = $createCountry;
        $actions[] = $updateCountry;
        $actions[] = $deleteCountry;
        
        $listDiscount = $auth->createPermission('shopListDiscount');
        $listDiscount->description = 'List shop discount';
        $viewDiscount = $auth->createPermission('shopViewDiscount');
        $viewDiscount->description = 'View shop discount';
        $createDiscount = $auth->createPermission('shopCreateDiscount');
        $createDiscount->description = 'Create shop discount';
        $updateDiscount = $auth->createPermission('shopUpdateDiscount');
        $updateDiscount->description = 'Update shop discount';
        $deleteDiscount = $auth->createPermission('shopDeleteDiscount');
        $deleteDiscount->description = 'Delete shop discount';

        $actions[] = $listDiscount;
        $actions[] = $viewDiscount;
        $actions[] = $createDiscount;
        $actions[] = $updateDiscount;
        $actions[] = $deleteDiscount;
        
        $listPaymentType = $auth->createPermission('shopListPaymentType');
        $listPaymentType->description = 'List shop payment type';
        $viewPaymentType = $auth->createPermission('shopViewPaymentType');
        $viewPaymentType->description = 'View shop payment type';
        $createPaymentType = $auth->createPermission('shopCreatePaymentType');
        $createPaymentType->description = 'Create shop payment type';
        $updatePaymentType = $auth->createPermission('shopUpdatePaymentType');
        $updatePaymentType->description = 'Update shop payment type';
        $deletePaymentType = $auth->createPermission('shopDeletePaymentType');
        $deletePaymentType->description = 'Delete shop payment type';

        $actions[] = $listPaymentType;
        $actions[] = $viewPaymentType;
        $actions[] = $createPaymentType;
        $actions[] = $updatePaymentType;
        $actions[] = $deletePaymentType;
        
        $listOrder = $auth->createPermission('shopListOrder');
        $listOrder->description = 'List shop order';
        $viewOrder = $auth->createPermission('shopViewOrder');
        $viewOrder->description = 'View shop order';
        $createOrder = $auth->createPermission('shopCreateOrder');
        $createOrder->description = 'Create shop order';
        $updateOrder = $auth->createPermission('shopUpdateOrder');
        $updateOrder->description = 'Update shop order';
        $deleteOrder = $auth->createPermission('shopDeleteOrder');
        $deleteOrder->description = 'Delete shop order';

        $actions[] = $listOrder;
        $actions[] = $viewOrder;
        $actions[] = $createOrder;
        $actions[] = $updateOrder;
        $actions[] = $deleteOrder;
        
        $listPrice = $auth->createPermission('shopListPrice');
        $listPrice->description = 'List shop price';
        $viewPrice = $auth->createPermission('shopViewPrice');
        $viewPrice->description = 'View shop price';
        $createPrice = $auth->createPermission('shopCreatePrice');
        $createPrice->description = 'Create shop price';
        $updatePrice = $auth->createPermission('shopUpdatePrice');
        $updatePrice->description = 'Update shop price';
        $deletePrice = $auth->createPermission('shopDeletePrice');
        $deletePrice->description = 'Delete shop price';

        $actions[] = $listPrice;
        $actions[] = $viewPrice;
        $actions[] = $createPrice;
        $actions[] = $updatePrice;
        $actions[] = $deletePrice;
        
        $listTransaction = $auth->createPermission('shopListTransaction');
        $listTransaction->description = 'List shop transaction';
        $viewTransaction = $auth->createPermission('shopViewTransaction');
        $viewTransaction->description = 'View shop transaction';
        $createTransaction = $auth->createPermission('shopCreateTransaction');
        $createTransaction->description = 'Create shop transaction';
        $updateTransaction = $auth->createPermission('shopUpdateTransaction');
        $updateTransaction->description = 'Update shop transaction';
        $deleteTransaction = $auth->createPermission('shopDeleteTransaction');
        $deleteTransaction->description = 'Delete shop transaction';

        $actions[] = $listTransaction;
        $actions[] = $viewTransaction;
        $actions[] = $createTransaction;
        $actions[] = $updateTransaction;
        $actions[] = $deleteTransaction;
        
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