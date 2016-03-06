<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CycloneAction */

$this->title = 'Create Cyclone Action';
$this->params['breadcrumbs'][] = ['label' => 'Cyclone Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cyclone-action-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
