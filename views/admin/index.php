<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\addwidgets\Paneladmin;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OperationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Operations';
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Paneladmin::widget()?>
<div style="clear: both;"></div><hr>
<div class="operations-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Operations', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'start_time:datetime',
            //'finish_time:datetime',
            'ip_first',
            'ip_second',
			'tip',
			'summa',
            'valute',
            // 'status',
            // 'secret',
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
