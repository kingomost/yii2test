<?php
namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\Request;
class Admin extends Model
{
	
	private $name  = 'admin';
	private $keyy   = 'admin';
	public 	$admin_name;
	public 	$admin_key;
	
	public function autorization () 
	{
		if ($this->load(Yii::$app->request->post()) && $this->validate()) {
			if ($this->admin_name === $this->name && $this->admin_key === $this->keyy) 
			{
				Yii::$app->session->set('admin_key', $this->keyy);
				Yii::$app->session->set('admin_name', $this->name);
				return true;
			}
			return false;
		}
		if (Yii::$app->session->get('admin_key') === $this->keyy && Yii::$app->session->get('admin_name') === $this->name) 
		{
			return true;
		}
		return false;
	}
	
	public static function LogOut () 
	{
		Yii::$app->session->remove('admin_name');
		Yii::$app->session->remove('admin_key');
		return true;
	}
	
	public function rules()
    {
        return 	[
					[['admin_name'], 'required', 'message'=>'должно быть не пустое поле'],
					[['admin_key'], 'required', 'message'=>'должно быть не пустое поле'],
				];
    }
	
	
}
?>