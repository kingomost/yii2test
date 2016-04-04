<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

?>
<div class="site-error">
    <div class="alert alert-danger">
		<h1>ERROR</h1>
    </div>
</div>
<br><br><br>
<?php if (isset($info) && $info!=='') {?>
<div class="col-lg-4 col-md-5 col-sm-5 col-xs-6"><h3><b>Info: <?=$info?></b></h3></div>
<?php } ?>
<br><br><br>
<div class="sgsr"  style="text-align: center; padding: 50px 35%; font-size: 30pt;">
<a href="<?=Yii::$app->urlManager->createUrl(['site',])?>">HOME</a>
</div>