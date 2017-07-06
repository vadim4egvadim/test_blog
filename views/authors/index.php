<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="authors-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать автора', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [   
                'label' => 'Картинка',
                'format' => 'raw',
                'value' => function($data){
                return Html::img($data->file, ['alt' => $data->name, 'width' => '50px']);
            }
            ],
            [   
                'label' => 'Имя',
                'format' => 'raw',
                'value' => function($data){
                return $data->name.' ('.$data->id.')';
            }
            ],
            [   
                'label' => 'Статус',
                'format' => 'raw',
                'value' => function($data){
                return $data->status_name;
            }
            ],
                
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
