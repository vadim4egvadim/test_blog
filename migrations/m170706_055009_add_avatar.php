<?php

use yii\db\Migration;
use yii\db\Schema;
class m170706_055009_add_avatar extends Migration
{
    public function safeUp()
    {
        $this->addColumn( '{{%authors}}','file',  Schema::TYPE_STRING);
    }

    public function safeDown()
    {
        echo "m170706_055009_add_avatar cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170706_055009_add_avatar cannot be reverted.\n";

        return false;
    }
    */
}
