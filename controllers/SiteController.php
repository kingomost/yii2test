<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

use app\models\User;
use app\models\Users;
use app\models\OperationsForm;
use app\models\OperationsExpectForm;
use app\models\OperationsTipRun;
use app\models\OperationsExpect;
use app\models\OperationsExpectRun;


class SiteController extends Controller
{
	private 		$user_ip 				= false;
	private 		$user_balanc			= [];
	private		 	$info 					= '';
	public static 	$balanc_new_user 		= 77;
	public static  	$arr_valute 			= ['dollar'=>'доллар', 'rubl'=>'рубль', 'frank'=>'франк',];
	public static  	$arr_operation 			= ['send'=>'перевести', 'pin'=>'отправить с пин-кодом', 'ask'=>'запросить перевод',];
	
	
    public function actionIndex() // вход или регистрация
    {
		$this->user_ip  = (new User())->user_autorization(); // либо входит, либо и входит, и регистрируется одновременно
		if ($this->user_ip !== false) {
			$this->info = 'Вход выполнен!';
			return $this->actionStart();
		}
		$model = new User();
		return $this->render('index', [
										'model'=>$model,
									]);
    }
	
	public function actionStart() // стартовая страница, на которой отображается баланс
    {
		$this->user_ip  = (new User())->user_autorization();
		if ($this->user_ip == false) return $this->actionError();
		$this->user_balanc = (new User())->return_balanc ($this->user_ip);
		return $this->render('start', [
										'user_ip'=>$this->user_ip,
										'user_balanc'=>$this->user_balanc,
										'info'=>$this->info,
									]);
    }
	
	public function actionOperations($operation = false, $valute = false) //различные операции
    {
        $this->user_ip  = (new User())->user_autorization();
		if (!$this->user_ip) return $this->actionError();
		$for_render = [];
		if ($operation && $valute) 
		{
			$model = new OperationsForm ($operation, $valute);
			if ($model->load(Yii::$app->request->post()) && $model->validate()) //это действие - совершение операции 
			{
				$this->info = (new OperationsTipRun($model))->resalt_info();
				return $this->actionOperations(false, false);
			}
			elseif (array_key_exists($operation, self::$arr_operation)  && array_key_exists($valute, self::$arr_valute)) //а это форму для совершения операции
			{
				$for_render = array_merge ($for_render, ['model'=>$model]);
				$for_render = array_merge ($for_render, ['valute'=>$valute]);
				$for_render = array_merge ($for_render, ['valute_nazvanie'=>self::$arr_valute[$valute]]);
				$for_render = array_merge ($for_render, ['operation'=>$operation]);
				$for_render = array_merge ($for_render, ['operation_nazvanie'=>self::$arr_operation[$operation]]);
			}
			else
			{
				$this->info = 'Вы передали некорректную операцию или валюту.';
			}
		}
		if (!$operation || !$valute) 
		{
			$for_render = array_merge ($for_render, ['arr_valute'=>self::$arr_valute]);
			$for_render = array_merge ($for_render, ['arr_operation'=>self::$arr_operation]);
		}
		$for_render = array_merge ($for_render, ['info'=>$this->info]);
		$for_render = array_merge ($for_render, ['user_ip'=>$this->user_ip]);
		return $this->render('operations', $for_render );
    }
	
	public function actionExpect($id = false) // в процессе выполнений
    {
        $this->user_ip  = (new User())->user_autorization();
		if (!$this->user_ip) return $this->actionError();
		$for_render = [];
		if ($id) 
		{
			$model = new OperationsExpect ($id);
			
			if ($model->load(Yii::$app->request->post())) //это действие - совершение операции 
			{
				
				if (OperationsExpectRun::isset_expect_operation ($this->user_ip, $model->id) && $model->id === $id) {
					if (!is_null($model->id) && !is_null($model->hidden_reshenie) && !is_null($model->tip)) 
					{
						$new_model = new OperationsExpect ($model->id, $model->hidden_reshenie, $model->tip);
						if ($new_model->load(Yii::$app->request->post()) && $new_model->validate()) 
						{
							$obj_do_expect = new OperationsExpectRun($new_model);
							$this->info = $obj_do_expect->resalt_info();
						}
						else{
							$this->info = 'Некорректные данные.';
						}
					}
					return $this->actionExpect(false);
				}
				$this->info = 'Вы передали некорректный ID.';
				return $this->actionError();
			}
			elseif (OperationsExpectRun::isset_expect_operation ($this->user_ip, $id)) //это для формы и проверка, что ему эту форму можно дать
			{
				$data 			= OperationsExpectRun::return_public_data_one_operation($id);
				$model_yes 		= new OperationsExpect ($id, 'yes', $data['qtip']);
				$model_no 		= new OperationsExpect ($id, 'no',  $data['qtip']);
				$for_render 	= array_merge ($for_render, ['model_yes'=>$model_yes]);
				$for_render 	= array_merge ($for_render, ['model_no'=>$model_no]);
				$for_render 	= array_merge ($for_render, ['data'=>$data]);
			}
			else
			{
				$this->info = 'Вы передали некорректный ID.';
			}
		} else //это для ссылок по которым юзер может на доступные ему действия перейти
		{
			$wait = OperationsExpectRun::return_expect_operation($this->user_ip);
			$for_render = array_merge ($for_render, ['wait'=>$wait]);
		}
		$for_render = array_merge ($for_render, ['info'=>$this->info]);
		$for_render = array_merge ($for_render, ['user_ip'=>$this->user_ip]);
		return $this->render('expect', $for_render );
    }
	
	public function actionHistory() // история выполненных
    {
        $this->user_ip  = (new User())->user_autorization();
		if (!$this->user_ip) return $this->actionError();
		
		return $this->render('history', [
											'user_ip'=>$this->user_ip,
											'info'=>$this->info,
									]);
    }
	
	public function actionOut() // закрыть сессию
    {
        $this->user_ip  = (new User())->user_autorization();
		if (!$this->user_ip) return $this->actionError('Вы не авторизированны и выходить вам неоткуда.');
		Yii::$app->session->remove('autorization');
		return $this->render('out');
    }
	
	public function actionError($mess = '') // сообщение об ошибке
    {
		return $this->render('error', [
											'mess'=>$mess, 
											'info'=>$this->info,
									]);
    }
	
}
