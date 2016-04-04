<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

use app\models\User;
use app\models\Users;
use app\models\OperationsForm;
use app\models\OperationsTipRun;

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
	
	public function actionExpect() // в процессе выполнений
    {
        $this->user_ip  = (new User())->user_autorization();
		if (!$this->user_ip) return $this->actionError();
		
		
		return $this->render('expect', [
											'user_ip'=>$this->user_ip,
											'info'=>$this->info,
									]);
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
