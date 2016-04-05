<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\addwidgets\Paneladmin;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Operations */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Operations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Paneladmin::widget()?>
<div style="clear: both;"></div><hr>
<div class="operations-view">


    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'id',
            'start_time:datetime',
            'finish_time:datetime',
            'ip_first',
            'ip_second',
            'valute',
            'tip',
            'status',
            'secret',
            'summa',
        ],
    ]) ?>

</div>
