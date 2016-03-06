<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CycloneAction */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Cyclone Actions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cyclone-action-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cyclone_action_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cyclone_action_id], [
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
            'cyclone_action_id',
            'name',
            'action_data_path',
            'movie_url:url',
            'play_count',
            'genre_id',
            'create_date',
            'update_date',
            'shown'
        ],
    ]) ?>

</div>
