<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class RusersController extends Controller
{
	
	
	
	
	
    public function actionIndex() // вход или регистрация
    {
        return $this->render('index');
    }
	
	public function actionStart() // стартовая страница, на которой отображается баланс
    {
        return $this->render('index');
    }
	
	public function actionOperations() //различные операции
    {
        return $this->render('index');
    }
	
	public function actionExpect() // в процессе выполнений
    {
        return $this->render('index');
    }
	
	public function actionHistory() // история выполненных
    {
        return $this->render('index');
    }
	
	public function actionOut() // закрыть сессию
    {
        return $this->render('index');
    }
	
	public function actionError() // сообщение об ошибке
    {
        return $this->render('index');
    }
	
}
