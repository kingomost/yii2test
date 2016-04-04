<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class OperationsForm extends Model
{
	public $ip_second_user			= false;
	public $operation 				= false;
	public $valute    				= false;
	public $summa     				= false;
	public $secret     				= false;
	public $valid_array     		= [];
	
	public function __construct ($operation, $valute) 
	{
		$this->operation 	= $operation;
		$this->valute 		= $valute;
		
		array_push($this->valid_array, [['ip_second_user'], 'required', 'message'=>'необходимо заполнить']);
		array_push($this->valid_array, [['ip_second_user'], 'trim']);
		array_push($this->valid_array, [['ip_second_user'], 'ip', 'message'=>'это не IP']);
		
		array_push($this->valid_array, [['operation'], 'required']);
		array_push($this->valid_array, [['operation'], 'trim']);
		array_push($this->valid_array, [['operation'], 'string', 'min'=>3, 'max'=>5]);//количество симолов - несущественно это
		
		array_push($this->valid_array, [['valute'], 'required']);
		array_push($this->valid_array, [['valute'], 'trim']);
		array_push($this->valid_array, [['valute'], 'string', 'min'=>3, 'max'=>7]);//количество симолов - несущественно это
		
		array_push($this->valid_array, [['summa'], 'required']);
		
		if ($operation === 'send' || $operation === 'pin')
		{
			$row_user = (new Users())->find()->where(['user_ip' => Yii::$app->session->get('autorization')])->one();
			array_push($this->valid_array, ['summa', 'number', 'min'=>0.01, 'max'=>$row_user->{$valute}]);
		}
		if ($operation === 'pin')
		{
			array_push($this->valid_array, [['secret'], 'required']);
			array_push($this->valid_array, [['secret'], 'trim']);
			array_push($this->valid_array, [['secret'], 'string', 'min'=>5, 'max'=>15]);
		}
		if ($operation === 'ask')
		{
			array_push($this->valid_array, ['summa', 'number', 'min'=>0.01, 'max'=>1000]);
		}
	}
	
	
	public function rules()
    {
        return 	$this->valid_array;		
    }
	
}

?>