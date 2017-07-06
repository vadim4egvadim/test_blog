<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Authors */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authors-view">

    <h1>
        <?= Html::img($model->file, ['alt' => $model->name, 'width' => '50px']); ?>
        <?= Html::encode($this->title) ?>
        
    </h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Уверены, что хотите удалить?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [                                              
                'label' => 'Идентификатор',
                'value' => $model->id,            
            ],
            [                                              
                'label' => 'Имя',
                'value' => $model->name,            
            ],
            [                                              
                'label' => 'Статус',
                'value' => $model->status_name,            
            ],
        ],
    ]) ?>
    <div class="photos">
        <?=  $model->displayPhotos();?>
    </div>
</div>
