<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cyclone Actions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cyclone-action-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Cyclone Action', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cyclone_action_id',
            'name',
            'action_data_path',
            'movie_url:url',
            'create_date',
            'update_date',
            'shown',
            'del_flg',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
