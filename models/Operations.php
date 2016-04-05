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
	
	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['start_time', 'ip_first', 'ip_second', 'valute', 'tip', 'summa'], 'required'],
            [['start_time', 'finish_time', 'status'], 'integer'],
            [['summa'], 'number'],
            [['ip_first', 'ip_second', 'valute', 'tip', 'secret'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_time' => 'Start Time',
            'finish_time' => 'Finish Time',
            'ip_first' => 'Ip First',
            'ip_second' => 'Ip Second',
            'valute' => 'Valute',
            'tip' => 'Tip',
            'status' => 'Status',
            'secret' => 'Secret',
            'summa' => 'Summa',
        ];
    }
	
}

?>