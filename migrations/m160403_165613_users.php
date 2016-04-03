<?php

use yii\db\Migration;

class m160403_165613_users extends Migration
{
    
	public function up()
    {
		$this->createTable('users', [
										'user_ip' 			=> $this->string()->notNull()->unique(),
										'user_pass' 		=> $this->string()->notNull()->unique(),
										'operation_table' 	=> $this->string()->notNull()->unique(),
										'dollar' 			=> $this->float(),
										'rubl' 				=> $this->float(),
										'frank' 			=> $this->float(),
									]);
		
    }

    public function down()
    {
        $this->dropTable('users');

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
