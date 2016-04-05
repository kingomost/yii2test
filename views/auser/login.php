<?php 
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
		<h4>Name: admin</h4><br/>
		<h4>Password: admin</h4><br/><br/>
		<?php $form = ActiveForm::begin([
										'id' => 'autorization',
										'options' => ['class' => 'hhki'],
									]) ?>
			<div style = "width: 200px; margin: 0 auto; height: 100px;">
				<?= $form->field($model, 'admin_name')->label('Name:') ?>
			</div>
			<div style = "width: 200px; margin: 0 auto; height: 100px;">
				<?= $form->field($model, 'admin_key')->label('Password:') ?>
			</div>
			<div style = "width: 200px; margin: 0 auto;">
				<?= Html::submitButton('LogIn',  ['class' => 'btn btn-default']) ?>
			</div>
		<?php ActiveForm::end() ?>
		</div>
	</div>
<br>
