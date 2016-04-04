<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


class OperationsExpect extends Model
{
	public $id;
	public $tip;
	public $secret;
	public $hidden_reshenie;
	public $valid_array = [];
	
	public function __construct ($id, $reshenie = false, $tip = false)
	{
		$this->id = $id;
		if ($reshenie) $this->hidden_reshenie = $reshenie;
		if ($tip) $this->tip = $tip;
		array_push($this->valid_array, [['id'], 'trim']);
		array_push($this->valid_array, [['id'], 'required', 'message'=>'']);
		array_push($this->valid_array, [['id'], 'number', 'message'=>'']);
		array_push($this->valid_array, [['hidden_reshenie'], 'trim']);
		array_push($this->valid_array, [['hidden_reshenie'], 'string', 'min'=>2, 'max'=>3, 'message'=>'']);
		array_push($this->valid_array, [['hidden_reshenie'], 'trim']);
		array_push($this->valid_array, [['tip'], 'string', 'min'=>2, 'max'=>7, 'message'=>'']);
		if ($this->hidden_reshenie === 'yes' && $this->tip === 'pin') 
		{
			array_push($this->valid_array, [['secret'], 'string', 'min'=>5, 'max'=>15, 'message'=>'']);
		}
	}
	
	public function rules()
    {	
        return 	$this->valid_array;		
    }
	
}

?>