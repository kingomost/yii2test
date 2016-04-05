<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OperationsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operations-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'start_time') ?>

    <?= $form->field($model, 'finish_time') ?>

    <?= $form->field($model, 'ip_first') ?>

    <?= $form->field($model, 'ip_second') ?>

    <?php // echo $form->field($model, 'valute') ?>

    <?php // echo $form->field($model, 'tip') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'secret') ?>

    <?php // echo $form->field($model, 'summa') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
