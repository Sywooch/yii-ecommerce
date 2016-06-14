<?php

namespace webdoka\yiiecommerce\commands;

use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;

        $actions = [];

        $viewFeature = $auth->createPermission('shopViewFeature');
        $viewFeature->description = 'View shop feature';
        $createFeature = $auth->createPermission('shopCreateFeature');
        $createFeature->description = 'Create shop feature';
        $updateFeature = $auth->createPermission('shopUpdateFeature');
        $updateFeature->description = 'Update shop feature';
        $deleteFeature = $auth->createPermission('shopDeleteFeature');
        $deleteFeature->description = 'Delete shop feature';
        
        $actions[] = $viewFeature;
        $actions[] = $createFeature;
        $actions[] = $updateFeature;
        $actions[] = $deleteFeature;

        $viewCategory = $auth->createPermission('shopViewCategory');
        $viewCategory->description = 'View shop category';
        $createCategory = $auth->createPermission('shopCreateCategory');
        $createCategory->description = 'Create shop category';
        $updateCategory = $auth->createPermission('shopUpdateCategory');
        $updateCategory->description = 'Update shop category';
        $deleteCategory = $auth->createPermission('shopDeleteCategory');
        $deleteCategory->description = 'Delete shop category';

        $actions[] = $viewCategory;
        $actions[] = $createCategory;
        $actions[] = $updateCategory;
        $actions[] = $deleteCategory;

        $viewProduct = $auth->createPermission('shopViewProduct');
        $viewProduct->description = 'View shop product';
        $createProduct = $auth->createPermission('shopCreateProduct');
        $createProduct->description = 'Create shop product';
        $updateProduct = $auth->createPermission('shopUpdateProduct');
        $updateProduct->description = 'Update shop product';
        $deleteProduct = $auth->createPermission('shopDeleteProduct');
        $deleteProduct->description = 'Delete shop product';

        $actions[] = $viewProduct;
        $actions[] = $createProduct;
        $actions[] = $updateProduct;
        $actions[] = $deleteProduct;

        foreach ($actions as $action) {
            $auth->add($action);
        }
    }
}