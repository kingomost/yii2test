<?php

use yii\db\Migration;

class m160403_165747_operations extends Migration
{

	public function up()
    {
		$this->createTable('operations', 	[
												'id' 			=> $this->primaryKey(),
												'start_time' 	=> $this->integer()->notNull(),
												'finish_time' 	=> $this->integer(),
												'ip_first' 		=> $this->string()->notNull(),
												'ip_second' 	=> $this->string()->notNull(),
												'valuta' 		=> $this->string()->notNull(),
												'tip' 			=> $this->string()->notNull(),
												'status' 		=> $this->boolean(),
												'secret' 		=> $this->string(),
												'summa' 		=> $this->float()->notNull(),
											]);
    }

    public function down()
    {
        $this->dropTable('operations');

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
