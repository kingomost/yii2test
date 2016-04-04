<?php 
use app\addwidgets\Panelusr;
use yii\helpers\Html;
use yii\base\Model;
use yii\widgets\ActiveForm;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
?>
<br>
<br>
	<div class="container">
		<div class="row" style="text-align: center;">
		<h4>Для регистрации (или авторизации если зарегистрирован).</h4><br/>
		<h4>Поля должны быть IP и совпасть.</h4><br/><br/>
		<h4>127.1.1.1 127.2.2.2 127.3.3.3 127.4.4.4 127.5.5.5</h4>
		<?php $form = ActiveForm::begin([
										'id' => 'autorization',
										'options' => ['class' => 'hhki'],
									]) ?>
			<div style = "width: 200px; margin: 0 auto; height: 100px;">
				<?= $form->field($model, 'user_ip')->label('IP:') ?>
			</div>
			<div style = "width: 200px; margin: 0 auto; height: 100px;">
				<?= $form->field($model, 'pass')->label('Password:') ?>
			</div>
			<div style = "width: 200px; margin: 0 auto;">
				<?= Html::submitButton('LogIn',  ['class' => 'btn btn-default']) ?>
			</div>
		<?php ActiveForm::end() ?>
		</div>
	</div>
<br>
