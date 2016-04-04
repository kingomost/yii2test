<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use app\models\Users;
use app\models\Operations;

class OperationsExpectRun extends Model
{
	private $data;
	public $arr_info = [
							'Невозможно закрыть инициированные вами операции. Это должен сделать второй участник.',
							'ip... все равно такой ошибки не будет',
							'Этот участник уже удалился из системы. Без него закрыть операцию нельзя.',
							'Не хватает средств, чтобы подтвердить это запрос.',
							'Запрос подтвержден и выполнен перевод.',
							'Запрос отклонен.',
							'Нужно ввести правильный пин-код.',
							'Неизвестная',
							'Код правильный и сумма зачислена',
							'Перевод с кодом отклонен и сумма вернулась на счет инициатора.',
					];
	
	
	public function Run ($model) 
	{
		$this->data = $this->return_all_data_one_operation($model->id);
		if (!$this->qIssetThisUserTable($this->data->ip_first)) return $this->arr_info[2];
		elseif (Yii::$app->session->get('autorization') == $this->data->ip_first) return $this->arr_info[0];
		elseif (Yii::$app->session->get('autorization') !== $this->data->ip_second) return $this->arr_info[1];
		elseif (method_exists ($this, $model->tip)) return $this->{$model->tip}($model);
		else return  'Добавлена новая операция или изменено название. На текущий момент есть send, pin, ask. send тут недоступен.';
	}
	
	private function ask ($model) 
	{
		if ($model->hidden_reshenie === 'yes') 
		{
			$row_second_user = (new Users())->find()->where(['user_ip' => $this->data->ip_second])->one();//это активный соответственно
			if ($row_second_user->{$this->data->valute} >= $this->data->summa) 
			{
				//заберем
				$row_second_user->{$this->data->valute} -= $this->data->summa;
				$row_second_user->save();
				//отдадим
				$row_first_user = (new Users())->find()->where(['user_ip' => $this->data->ip_first])->one();//это инициатор
				$row_first_user->{$this->data->valute} += $this->data->summa;
				$row_first_user->save();
				//пометим в таблице операций
				$metim = Operations::findOne($this->data->id);
				$metim->status = true;
				$metim->save();
				$metim->finish_time = time();
				$metim->save();
				return $this->arr_info[4];
			} 
			else 
			{
				return $this->arr_info[3];
			}
		}
		elseif ($model->hidden_reshenie === 'no')
		{
			$metim = Operations::findOne($this->data->id);
			$metim->finish_time = time();
			$metim->save();
			return $this->arr_info[5];
		}
		else{
			return $this->arr_info[7];
		}
	}
	
	private function pin ($model) 
	{
		if ($model->hidden_reshenie === 'yes') 
		{
			if ($model->secret === $this->data->secret) 
			{
				//зачисляем
				$row_second_user = (new Users())->find()->where(['user_ip' => $this->data->ip_second])->one();
				$row_second_user->{$this->data->valute} += $this->data->summa;
				$row_second_user->save();
				//метим
				$metim = Operations::findOne($this->data->id);
				$metim->status = true;
				$metim->save();
				$metim->finish_time = time();
				$metim->save();
				return $this->arr_info[8];
			} 
			else 
			{
				return $this->arr_info[6];
			}
		}
		elseif ($model->hidden_reshenie === 'no')
		{
			//возвращаем
			$row_first_user = Users::findOne($this->data->ip_first);
			$row_first_user->{$this->data->valute} += $this->data->summa;
			$row_first_user->save();
			//метим в статусе фолс а время - что закрыто
			$metim = Operations::findOne($this->data->id);
			$metim->finish_time = time();
			$metim->save();
			return $this->arr_info[9];
		}
		else{
			return $this->arr_info[7];
		}
	}
	
	public static function return_expect_operation ($ip) {
		$list_operation = [];
		$user_row_in_table = (new Users())->find()->where(['user_ip' => $ip])->one();
		$connect = new \PDO(Yii::$app->db->dsn, Yii::$app->db->username, Yii::$app->db->password);
		$all_user_operation = $connect->query('SELECT operation_id FROM '.$user_row_in_table->operation_table.';');
		foreach ($all_user_operation as $buf) 
		{
			$one_operation = (new Operations())->find()->where(['id' => $buf['operation_id']])->one();
			if ($one_operation->status == false && $one_operation->finish_time == null) {
				$list_operation[] = [
										'id'			=>$one_operation->id,
										'start_time'	=>$one_operation->start_time,
										'ip_first'		=>$one_operation->ip_first,
										'ip_second'		=>$one_operation->ip_second,
										'valute'		=>$one_operation->valute,
										'qtip'			=>$one_operation->tip,
										'summa'			=>$one_operation->summa,
									];
			}
		}
		return array_reverse($list_operation);
	}
	
	public static function return_public_data_one_operation ($id) {
		$row = (new Operations())->find()->where(['id' => $id])->one();
		$data = [
							'id'			=>$row->id,
							'start_time'	=>$row->start_time,
							'ip_first'		=>$row->ip_first,
							'ip_second'		=>$row->ip_second,
							'valute'		=>$row->valute,
							'qtip'			=>$row->tip,
							'summa'			=>$row->summa,
					];
		return $data;
	}
	
	private function return_all_data_one_operation ($id) //сразу без  разбора
	{
		return (new Operations())->find()->where(['id' => $id])->one();
	}
	
	public static function isset_expect_operation ($ip, $id) //именно для этого пользователя, а не для какого-то, инициатор не он - он second
	{
		$one_operation = (new Operations())->find()->where(['id' => $id])->one();
		if (!is_null($one_operation) && $one_operation->ip_second === $ip && $one_operation->finish_time == null) return true;
		return false;
	}
	
	private function qIssetThisUserTable ($ip) 
	{
		if (is_null((new Users())->find()->where(['user_ip' => $ip])->one())) return false;
		return true;
	}
	
}

?>