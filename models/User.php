<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\Request;
use yii\db\ActiveRecord;
use yii\db\Migration;
use app\models\Users;
use app\controllers\SiteController;

class User extends Model
{
	public $autorization 	= false;
	public $user_ip     	= false;
	public $pass     		= false;
	
	public function user_autorization () {
		if (!is_null(Yii::$app->session->get('autorization'))) //заходит авторизированный пользователь
		{
			$row_user = (new Users())->find()->where(['user_ip' => Yii::$app->session->get('autorization')])->one();
			if (!is_null($row_user)) return $row_user->user_ip;
			return $this->create_new_user ($row_user);
			return false;
		} 
		elseif ($this->load(Yii::$app->request->post()) && $this->validate()) 
		{
			if ($this->user_ip !==false && $this->pass !==false && $this->pass === $this->user_ip) //условие где пароль равен этому же ID
			{
				Yii::$app->session->set('autorization', $this->user_ip);
				$row_user = (new Users())->find()->where(['user_ip' => Yii::$app->session->get('autorization')])->one();
				if (!is_null($row_user)) return $row_user->user_ip;
				return $this->create_new_user ($row_user); //если он только регистрируется - создадим ему таблицу
			}
		}
		Yii::$app->session->remove('autorization');	
		return false;
	}
	
	public function rules()
    {
        return 	[
					[['user_ip'], 'required', 'message'=>'должно быть не пустое поле'],
					[['user_ip'], 'ip', 'message'=>'это не IP'],
					[['pass'], 'required', 'message'=>'должно быть не пустое поле'],
					[['pass'], 'ip', 'message'=>'это не IP'],
				];
    }
	
	public function return_balanc ($ip)
	{
		$arr = [];
		$row_user = (new Users())->find()->where(['user_ip' => $ip])->one();
		$all_valute = SiteController::$arr_valute;
		foreach ($all_valute as $valute=>$t) $arr[$valute] = $row_user->{$valute};
		return $arr;
	}
	
	private function create_new_user ($row_user)
    {
		$balanc_new_user 	= SiteController::$balanc_new_user;
		$all_valute 		= SiteController::$arr_valute;
		$new_user = new Users();
		foreach ($all_valute as $valute=>$t) $new_user->{$valute} 	= $balanc_new_user;
		$new_user->user_ip 											= $this->user_ip;
		$new_user->user_pass 										= $this->pass;
		$new_user->operation_table 									= 'point'.str_replace ('.', 's', $this->user_ip);
		$new_user->insert();
		$migrate = new Migration();
		$migrate->createTable(
			$new_user->operation_table, [
											'id' =>  $migrate->primaryKey(),
											'operation_id' => $migrate->integer()->notNull()->unique(),
							]);
		return $new_user->user_ip;
	}
	
}
	
?>