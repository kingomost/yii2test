<?php

namespace app\addwidgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\widgets\Menu;

class Panelusr  extends Widget {
	
	
	public function run ()
	{
		$buf = Menu::widget([
		
		    'items' => [
							['label' => 'Money', 'url' => ['site/start']],
							['label' => 'Operations', 'url' => ['site/operations']],
							['label' => 'Expect', 'url' => ['site/expect']],
							['label' => 'History', 'url' => ['site/history']],
							['label' => 'Out', 'url' => ['site/out']],
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