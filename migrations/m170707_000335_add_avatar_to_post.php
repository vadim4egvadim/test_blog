<?php

use yii\db\Migration;
use yii\db\Schema;

class m170707_000335_add_avatar_to_post extends Migration
{
    public function safeUp()
    {
        $this->addColumn( '{{%post}}','file',  Schema::TYPE_STRING);
    }

    public function safeDown()
    {
        echo "m170707_000335_add_avatar_to_post cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170707_000335_add_avatar_to_post cannot be reverted.\n";

        return false;
    }
    */
}
