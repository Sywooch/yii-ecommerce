<?php

use yii\db\Migration;
use webdoka\yiiecommerce\common\models\Account;
use app\models\User;
use webdoka\yiiecommerce\common\models\Cart;

class m160811_042810_create_profile extends Migration {

    public function up() {
        $this->createTable('profiles', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'default_account_id' => $this->integer()->defaultValue(null),
        ]);

        $this->addForeignKey('fk-profiles-user_id-users-id', 'profiles', 'user_id', 'users', 'id');

        // Accounts
        $users = User::find()->all();
        foreach ($users as $user) {
            $account = Account::find()->where(['user_id' => $user->id])->default1()->one();

            $this->insert('profiles', [
                'user_id' => $user->id,
                'default_account_id' => $account ? $account->id : null,
            ]);
        }
    }

    public function down() {
        $this->dropForeignKey('fk-profiles-user_id-users-id', 'profiles');
        $this->dropTable('profiles');
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
