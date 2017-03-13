<?php

use yii\db\Migration;
use webdoka\yiiecommerce\common\models\Account;
use webdoka\yiiecommerce\common\models\Cart;
use webdoka\yiiecommerce\common\models\Order;

class m160811_045341_relink_to_profile extends Migration
{

    public function up()
    {
        $this->dropForeignKey('fk-accounts-user_id-users-id', 'accounts');

        foreach (Account::find()->all() as $account) {
            $profile = $account->user->profile;

            $account->user_id = $profile->id;
            $account->save();
        }

        $this->renameColumn('accounts', 'user_id', 'profile_id');
        $this->addForeignKey('fk-accounts-profile_id-profiles-id', 'accounts', 'profile_id', 'profiles', 'id');

        // Carts
        foreach (Cart::find()->all() as $cart) {
            $profile = $cart->user->profile;

            $cart->user_id = $profile->id;
            $cart->save();
        }

        $this->renameColumn('carts', 'user_id', 'profile_id');
        $this->addForeignKey('fk-carts-profile_id-profiles-id', 'carts', 'profile_id', 'profiles', 'id');

        // Orders
        $this->dropForeignKey('fk-orders-user_id-users-id', 'orders');

        foreach (Order::find()->all() as $order) {
            $profile = $order->user->profile;

            $order->user_id = $profile->id;
            $order->save();
        }

        $this->renameColumn('orders', 'user_id', 'profile_id');
        $this->addForeignKey('fk-orders-profile_id-profiles-id', 'orders', 'profile_id', 'profiles', 'id');
    }

    public function down()
    {
        echo "m160811_045341_relink_to_profile cannot be reverted.\n";

        return false;
    }

    /*
      // Use safeUp/safeDown to run migration code within a transaction
      public function safeUp()
      {
      }

      public function safeDown()
      {
      }
     */
}
