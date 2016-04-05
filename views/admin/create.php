<?php

use yii\helpers\Html;
use app\addwidgets\Paneladmin;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Operations */

$this->title = 'Create Operations';
$this->params['breadcrumbs'][] = ['label' => 'Operations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Paneladmin::widget()?>
<div style="clear: both;"></div><hr>
<div class="operations-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
