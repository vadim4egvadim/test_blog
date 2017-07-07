<?php

namespace app\models;

use Yii;
use app\models\Authors;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * This is the model class for table "{{%post}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $category_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $author
 */
class Post extends \yii\db\ActiveRecord
{    
    public $status_id;
    public $status_name;
    public $date;
    public $author_name;
    public function afterFind(){
        if(!$this->file) $this->file = '/images/posts/blank.png';
        
        $author = Authors::findOne($this->author);
        $this->author_name = $author->name;
        $this->status_id = $this->status;
        switch($this->status){
            case "0":
                $this->status_name = "Неопубликовано";
                
                break;
            case "1":
                $this->status_name = "Опубликовано";
                break;  
            default:
                $this->status_name = "Статус не определён";
                break;
        }
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'category_id', 'status', 'created_at', 'updated_at', 'author'], 'required'],
            [['content'], 'string'],
            [['category_id', 'status', 'created_at', 'updated_at', 'author'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['file'],  'file', 'extensions' => 'png, jpg', 'maxFiles'=> 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'category_id' => 'Category ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'author' => 'Author',
        ];
    }
    public function getAuthors() {
        $authors = Authors::find()->all();
        $authors= ArrayHelper::map($authors,'id','name');
        return $authors;
    }
    public function createDirectory($path) {   
    //$filename = "/folder/{$dirname}/";  
    if (file_exists($path)) {  
        //echo "The directory {$path} exists";  
    } else {  
        mkdir($path, 0775, true);  
        //echo "The directory {$path} was successfully created.";  
    }
    }
    public function displayPhotos() {
        $path = 'images/posts/'.$this->id.'/';
        $this->createDirectory($path);
        $files = scandir($path);
        for ($i = 0; $i < count($files); $i++) { 
            if (($files[$i] != ".") && ($files[$i] != "..")) { 
                $img = $path.$files[$i]; 
                echo Html::beginTag('div',['class' =>'photo col-md-2']);
                echo Html::a('Удалить', ['delimage', 'name' => $files[$i], 'id' => $this->id], [
                    'class' => 'btn btn-danger',
                    'style' => 'width: 100px;',
                    'data' => [
                    'confirm' => 'Уверены, что хотите удалить изображение?',
                    'method' => 'post',
                ],
                ]); 
                echo Html::img('/'.$img, ['alt' => $files[$i], 'width' => '100px']);
                echo Html::a('На аву', ['setava', 'name' => $files[$i], 'id' => $this->id], [
                    'class' => 'btn btn-primary',
                    'style' => 'width: 100px;',
                    'data' => [
                    'method' => 'post',
                    ],
                ]);
                echo Html::endTag('div'); 
            }
        }
    }
    public function getStatus() {
      return [1=>'Опубликовано',0=>'Неопубликовано'];
    }
}
