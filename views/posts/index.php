<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [   
                'label' => 'Картинка',
                'format' => 'raw',
                'value' => function($data){
                return Html::img($data->file, ['alt' => $data->title, 'width' => '50px']);
            }
            ],
            [   
                'label' => 'Заголовок',
                'format' => 'raw',
                'value' => function($data){
                    return $data->title;
                }
            ],
            [   
                'label' => 'Дата',
                'format' => 'raw',
                'value' => function($data){
                    return date('d.m.Y H:i:s',$data->updated_at);
                }
            ],
            [   
                'label' => 'Автор',
                'format' => 'raw',
                'value' => function($data){
                    return $data->author_name;
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
