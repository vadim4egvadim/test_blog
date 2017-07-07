<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'category_id')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList($model->getStatus(),['options' =>[ $model->status_id => ['Selected' => true]]])->label('Выберите статус'); ?>


    <?= $form->field($model, 'author')->dropDownList($model->getAuthors(),['options' =>[ $model->author => ['Selected' => true]]])->label('Выберите автора'); ?>
    
    <?= $form->field($model, 'file[]')->fileInput(['multiple' => true]) ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
