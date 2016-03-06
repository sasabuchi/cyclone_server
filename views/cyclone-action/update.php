<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CycloneAction */

$this->title = 'Update Cyclone Action: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cyclone Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->cyclone_action_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cyclone-action-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
