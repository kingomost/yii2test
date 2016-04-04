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
<h3>Завершенные операции:</h3>
<br/>
<?php 
if (count($list)<1) {
	echo '<h3>нет завершенных операций.</h3>';
} else {
	foreach ($list as $value) {
	?>
	<div class="fnhgfhf" style="text-align: left; padding: 5px 0; border-bottom: 1px #eee solid; border-top: 1px #eee solid;">
	<?php 
	echo date('d.m.Y H:i:s ', $value ['start_time']);

	if ($value ['qtip'] === 'send') 			echo '<b>Перевод: </b>'.$value ['summa'].' '.$value ['valute'].'. ';
	elseif ($value ['qtip'] === 'ask') 			echo '<b>Просьба: </b>'.$value ['summa'].' '.$value ['valute'].'. ';
	elseif ($value ['qtip'] === 'pin') 			echo '<b>Перевод с pin: </b>'.$value ['summa'].' '.$value ['valute'].'. ';

	if ($value ['ip_first'] === $user_ip) 		echo ' От вас пользователю '.$value ['ip_second'].'. ';
	elseif ($value ['ip_second'] === $user_ip) 	echo ' От пользователя '.$value ['ip_first'].' к вам. ';

	if ($value ['status']) 						echo '<b>Результат - выполнено.</b> '.date('d.m.Y H:i:s ', $value ['finish_time']).' ';
	else 										echo '<b>Результат - отклонено.</b> '.date('d.m.Y H:i:s ', $value ['finish_time']).' ';
	?>
	</div>
	<?php 
	}
}
?>
<br/>