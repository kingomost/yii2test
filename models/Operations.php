<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Operations extends ActiveRecord 
{
	
	public static function tableName()
    {
        return 'operations';
    }
	
}

?>