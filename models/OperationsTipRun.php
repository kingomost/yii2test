<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use app\models\Users;
use app\models\Operations;

class OperationsTipRun extends Model
{
	public $resalt_info = '';
	public $arr_info = [
							'Перевод больше, чем на счету',
							'Тут ошибка при записи ID операций, надо перехватывать исключениями, не дойдет до сюда - fatal',
							'Операция Send успешно выполнена.',
							'Операция Pin успешно выполнена.',
							'Большая сумма для перевода за раз.',
							'Операция Ask успешно выполнена.',
							'Операции с самим собой не выполняются.',
							'Такого пользователя нет в системе.',
					];
					
	public function __construct ($model) {
		if (Yii::$app->session->get('autorization') == $model->ip_second_user) $this->resalt_info = $this->arr_info[6];
		elseif (!$this->qIssetThisUserTable($model->ip_second_user)) $this->resalt_info = $this->arr_info[7];
		elseif (method_exists ($this, $model->operation)) $this->resalt_info = $this->{$model->operation}($model);
		else $this->resalt_info = 'Добавлена новая операция или изменено название. На текущий момент есть send, pin, ask';
	}
	
	private function send ($model) {
		$row_first_user 				= (new Users())->find()->where(['user_ip' => Yii::$app->session->get('autorization')])->one();
		$row_second_user 				= (new Users())->find()->where(['user_ip' => $model->ip_second_user])->one();
		if ($row_first_user->{$model->valute} < $model->summa) 
		{
			return $this->arr_info[0];
		} 
		$operations_I 					= new Operations();
		$operations_I->start_time 		= time();//это для операций старт
		$operations_I->finish_time 		= null;//это для операции финиш
		$operations_I->ip_first 		= Yii::$app->session->get('autorization');//это инициатор
		$operations_I->ip_second 		= $model->ip_second_user;//это тот, кого он выбрал
		$operations_I->tip 				= $model->operation;//это тип операции - мы сейчас на SEND - так явно и запишем
		$operations_I->valute 			= $model->valute;//это валюта
		$operations_I->secret 			= null;//Секрет
		$operations_I->status 			= false;//тк с первого еще не списали а второму не отдали
		$operations_I->summa 			= $model->summa;//сумма
		$operations_I->insert();
		$row_first_user->{$model->valute} -= $model->summa;
		$row_first_user->save();
		$row_second_user->{$model->valute} += $model->summa;
		$row_second_user->save();
		if (! $this->qWritiIdOperationOboim ($operations_I->id, [$row_first_user->operation_table, $row_second_user->operation_table])) 
		{
			return $this->arr_info[1];
		} 
		$buf = Operations::findOne($operations_I->id);
		$buf->finish_time = time();
		$buf->save();
		$buf->status = true;
		$buf->save();
		return $this->arr_info[2];
	}
	
	private function pin ($model) {
		$row_first_user 				= (new Users())->find()->where(['user_ip' => Yii::$app->session->get('autorization')])->one();
		$row_second_user 				= (new Users())->find()->where(['user_ip' => $model->ip_second_user])->one();
		if ($row_first_user->{$model->valute} < $model->summa) 
		{
			return $this->arr_info[0];
		} 
		$operations_I 					= new Operations();
		$operations_I->start_time 		= time();
		$operations_I->finish_time 		= null;
		$operations_I->ip_first 		= Yii::$app->session->get('autorization');
		$operations_I->ip_second 		= $model->ip_second_user;
		$operations_I->tip 				= $model->operation;
		$operations_I->valute 			= $model->valute;
		$operations_I->secret 			= $model->secret;
		$operations_I->status 			= false;
		$operations_I->summa 			= $model->summa;
		$operations_I->insert();
		$row_first_user->{$model->valute} -= $model->summa;
		$row_first_user->save();
		if (! $this->qWritiIdOperationOboim ($operations_I->id, [$row_first_user->operation_table, $row_second_user->operation_table])) 
		{
			return $this->arr_info[1];
		} 
		return $this->arr_info[3];
	}
	
	private function ask ($model) {
		$row_first_user 				= (new Users())->find()->where(['user_ip' => Yii::$app->session->get('autorization')])->one();
		$row_second_user 				= (new Users())->find()->where(['user_ip' => $model->ip_second_user])->one();
		if ($model->summa > 1000) 
		{
			return $this->arr_info[4];
		} 
		$operations_I 					= new Operations();
		$operations_I->start_time 		= time();
		$operations_I->finish_time 		= null;
		$operations_I->ip_first 		= Yii::$app->session->get('autorization');
		$operations_I->ip_second 		= $model->ip_second_user;
		$operations_I->tip 				= $model->operation;
		$operations_I->valute 			= $model->valute;
		$operations_I->secret 			= null;
		$operations_I->status 			= false;
		$operations_I->summa 			= $model->summa;
		$operations_I->insert();
		if (! $this->qWritiIdOperationOboim ($operations_I->id, [$row_first_user->operation_table, $row_second_user->operation_table])) 
		{
			return $this->arr_info[1];
		} 
		return $this->arr_info[5];
	}
	
	private function qWritiIdOperationOboim ($id_operation, $arr_users_table_call) {
		for ($i=0; $i<count($arr_users_table_call); $i++) {
			(new \PDO(Yii::$app->db->dsn, Yii::$app->db->username, Yii::$app->db->password))->
					exec('INSERT INTO '.$arr_users_table_call[$i].' (id, operation_id) VALUES (null, '.$id_operation.')');
		}
		return true;
	}
	
	private function qIssetThisUserTable ($ip) {
		if (is_null((new Users())->find()->where(['user_ip' => $ip])->one())) return false;
		return true;
	}
	
	public function resalt_info () {
		return $this->resalt_info;
	}
	
}

?>