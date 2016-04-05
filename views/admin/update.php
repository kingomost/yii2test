<?php

use yii\helpers\Html;
use app\addwidgets\Paneladmin;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Operations */

$this->title = 'Update Operations: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Operations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?=Paneladmin::widget()?>
<div style="clear: both;"></div><hr>
<div class="operations-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
