<?php 
use app\addwidgets\Panelusr;
use yii\helpers\Html;
use yii\base\Model;
use yii\widgets\ActiveForm;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
?>
<?=Panelusr::widget()?>
<div style="clear: both;"></div>
<div class="container">
	<div class="row">
		<div class="col-lg-4 col-md-5 col-sm-5 col-xs-6"><h3><b>Name: <?=$user_ip?></b></h3></div>
		<?php if (isset($info) && $info!=='') {?>
		<div class="col-lg-4 col-md-5 col-sm-5 col-xs-6"><h3><b>Info: <?=$info?></b></h3></div>
		<?php } ?>
	</div>
</div>
<br/>
<h3>Баланс:</h3>
<br/>
<?php 
foreach ($user_balanc as $valute=>$summa) {
?>
		<div class="row">
			<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
				<b><?=strtoupper($summa)?></b>
			</div>	
			<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
				<b><?=strtoupper($valute)?></b>
			</div>	
		</div>	
		<br/>
<?php 
};
?>