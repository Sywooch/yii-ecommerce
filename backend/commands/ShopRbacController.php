<?php

namespace webdoka\yiiecommerce\backend\commands;

use yii\console\Controller;

class ShopRbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        $actions = [];

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