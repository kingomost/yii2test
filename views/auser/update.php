<?php

use yii\helpers\Html;
use app\addwidgets\Paneladmin;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = 'Update Users: ' . $model->user_ip;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_ip, 'url' => ['view', 'id' => $model->user_ip]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?=Paneladmin::widget()?>
<div style="clear: both;"></div><hr>
<div class="users-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
