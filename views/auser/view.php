<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\addwidgets\Paneladmin;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Users */

$this->title = $model->user_ip;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Paneladmin::widget()?>
<div style="clear: both;"></div><hr>
<div class="users-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->user_ip], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->user_ip], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'user_ip',
            'user_pass',
            'operation_table',
            'dollar',
            'rubl',
            'frank',
        ],
    ]) ?>

</div>
