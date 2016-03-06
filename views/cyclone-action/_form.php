<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\CycloneAction */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cyclone-action-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'action_data_path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'movie_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'play_count')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'genre_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'create_date')->textInput() ?>

    <?= $form->field($model, 'update_date')->textInput() ?>

    <?= $form->field($model, 'shown')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
