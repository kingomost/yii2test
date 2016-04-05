<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $user_ip
 * @property string $user_pass
 * @property string $operation_table
 * @property double $dollar
 * @property double $rubl
 * @property double $frank
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_ip', 'user_pass', 'operation_table'], 'required'],
            [['dollar', 'rubl', 'frank'], 'number'],
            [['user_ip', 'user_pass', 'operation_table'], 'string', 'max' => 255],
            [['user_ip'], 'unique'],
            [['user_pass'], 'unique'],
            [['operation_table'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_ip' => 'User Ip',
            'user_pass' => 'User Pass',
            'operation_table' => 'Operation Table',
            'dollar' => 'Dollar',
            'rubl' => 'Rubl',
            'frank' => 'Frank',
        ];
    }
}
