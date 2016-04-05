<?php
namespace app\addwidgets;
use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\Menu;
class Paneladmin  extends Widget {
	
	
	public function run ()
	{
		$buf = Menu::widget([
		
		    'items' => [
							['label' => 'Users', 'url' 			=> ['auser/index']],
							['label' => 'Operations', 'url' 	=> ['admin/index']],
							['label' => 'Out', 'url' 			=> ['admin/out']],
						],
				'options' => [
								'id'=>'bs-example-navbar-collapse-1',
								'class' => 'nav navbar-nav',
								'style'=>'float: left; font-size: 16px; margin-left: 25px; ',
								'data'=>'menu',
							],
					'encodeLabels' =>'false',
					'activeCssClass'=>'active',
					'firstItemCssClass'=>'fist',
					'lastItemCssClass' =>'last',
			]);	
		
		
		return $buf;
	}
}
?>