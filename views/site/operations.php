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
<?php 
if (isset($arr_operation) && isset($arr_valute)) {
?>	
<h3>Совершить операции:</h3>
<br/>
	<?php 
	foreach ($arr_operation as $tip=>$opisanie) {
	?>	
				<div class="row">
					<div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">
						<b><?=$opisanie?></b>
					</div>	
		<?php
			foreach ($arr_valute as $valute=>$nazvanie) {
		?>	
					<div class="col-xs-2 col-sm-1 col-md-1 col-lg-1">
						<a class="btn btn-default" href="<?=Yii::$app->urlManager->createUrl(['site/operations', 'operation'=>$tip, 'valute'=>$valute])?>" role="button"><?=$nazvanie?></a>
					</div>
		<?php	
			}
		?>	
				</div>	
				<br/>
	<?php	
	}
	?>
<?php	
}
?>

<?php	
if (isset($model) && isset($valute) && isset($valute_nazvanie) && isset($operation) && isset($operation_nazvanie)) {
?>
<h3><? =$operation_nazvanie ?> <? =$valute_nazvanie ?></h3>
<br/>
			<div class="container">	
				<div class="row" style="height: 120px;">
					<?php $form = ActiveForm::begin(['id' => 'operation', 'options' => ['class' => 'fbffdf'],]);?>
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
						<?= $form->field($model, 'ip_second_user')->label('IP:') ?>
					</div>	
					
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
						<?= $form->field($model, 'summa')->label('Summa:') ?>
					</div>	
						<?php	
						if ($operation === 'pin') {
						?>
							<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
								<?= $form->field($model, 'secret')->label('Pin-code:') ?>
							</div>	
						<?php	
						}
						?>
				</div>
				<div style="clear: both;"></div>
				<div class="row">
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-2">
						<?= Html::submitButton('ENTER', ['class' => 'btn btn-primary']) ?>
					</div>	
				</div>
					<?= $form->field($model, 'operation')->hiddenInput(['hidden'=>$operation])->label('') ?>
					<?= $form->field($model, 'valute')->hiddenInput(['hidden'=>$valute])->label('') ?>
					<?php ActiveForm::end(); ?>
				</div>	
			</div>
			<br/>
<?php	
}
?>







