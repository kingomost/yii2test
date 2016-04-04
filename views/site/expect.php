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
<h3>В процессе выполнения:</h3>
<br/>

<?php
if (isset($wait) && count($wait)>0) {
	foreach ($wait as $arr) {
?>	
	<div class="row">
		<div class="col-xs-12 col-sm-11 col-md-10 col-lg-9">
			<b><?=date('d.m.Y H:i:s ', $arr['start_time'])?></b>
				<?php
				if ($arr['qtip'] == 'pin' && $arr['ip_second'] == $user_ip) {
					?>
						<a href="<?=Yii::$app->urlManager->createUrl(['site/expect', 'id'=>$arr['id']])?>">
							Пользователь <?=$arr['ip_first']?> перевел вам <?=$arr['summa']?> <?=$arr['valute']?> с кодом подтверждения.
						</a>
					<?php
				} elseif ($arr['qtip'] == 'pin' && $arr['ip_second'] !== $user_ip) {
					?>
						Вы перевели пользователю <?=$arr['ip_second']?> <?=$arr['summa']?> <?=$arr['valute']?> с кодом подтверждения.
					<?php
				} elseif ($arr['qtip'] == 'ask' && $arr['ip_second'] == $user_ip) {
					?>
						<a href="<?=Yii::$app->urlManager->createUrl(['site/expect', 'id'=>$arr['id']])?>">
							Пользователь <?=$arr['ip_first']?> запросил у вас <?=$arr['summa']?> <?=$arr['valute']?> .
						</a>
					<?php
				} elseif ($arr['qtip'] == 'ask' && $arr['ip_second'] !== $user_ip) {
					?>
						Вы запросили у пользователя <?=$arr['ip_second']?> <?=$arr['summa']?> <?=$arr['valute']?>.
					<?php
				}
				?>
		</div>
	</div>
	<br/>
<?php		
	}
} elseif (isset($wait) && count($wait)==0) {
	echo '<h3>нет активных операций в процессе выполнения.</h3>';
}

if (isset($data) && isset($model_yes) && isset($model_no)) {
?>	
	<div class="container">	
		<div class="row">
			<div class="col-xs-12 col-sm-11 col-md-10 col-lg-9">
				<b><?=date('d.m.Y H:i:s ', $data['start_time'])?></b> <?=$data['ip_first']?> -> <?=$data['ip_second']?> <b><?=strtoupper($data['qtip'])?></b>  <?=$data['summa']?> <?=$data['valute']?>
				<br><br>
			</div>
		</div>
		<?php $form = ActiveForm::begin(['id' => 'operation', 'options' => ['class' => 'fbffdf'],]);?>
		<?php if ($data['qtip'] === 'pin') { ?>
		
		<div class="row" style="height: 100px;">
			<div class="col-xs-10 col-sm-8 col-md-6 col-lg-5">
				<?= $form->field($model_yes, 'secret')->label('Pin-code:') ?>
			</div>
		</div>
		<?php } ?>
		
		
		<div style="clear: both;"></div>
		
		<div class="row">
			<div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">
				<div style="height: 0;">
					<?= $form->field($model_yes, 'id')->hiddenInput(['hidden'=>$model_yes->id])->label('') ?>
					<?= $form->field($model_yes, 'tip')->hiddenInput(['hidden'=>$model_yes->tip])->label('') ?>
					<?= $form->field($model_yes, 'hidden_reshenie')->hiddenInput(['hidden'=>$model_yes->hidden_reshenie])->label('') ?>
				</div>
				<?php if ($data['qtip'] === 'pin') { ?>
					<?= Html::submitButton('Отправить pin', ['class' => 'btn btn-primary']) ?>
				<?php } else { ?>
					<?= Html::submitButton('Подтвердить запрос', ['class' => 'btn btn-primary']) ?>
				<?php } ?>
			</div>
			<?php ActiveForm::end(); ?>
			<?php $form = ActiveForm::begin(['id' => 'operation', 'options' => ['class' => 'fbffdf'],]);?>
			<div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">
				<div style="height: 0;">
					<?= $form->field($model_no, 'id')->hiddenInput(['hidden'=>$model_no->id])->label('') ?>
					<?= $form->field($model_no, 'tip')->hiddenInput(['hidden'=>$model_no->tip])->label('') ?>
					<?= $form->field($model_no, 'hidden_reshenie')->hiddenInput(['hidden'=>$model_no->hidden_reshenie])->label('') ?>
				</div>
				<?= Html::submitButton('Отменить', ['class' => 'btn btn-primary']) ?>
			</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>
<?php	
}
?>

