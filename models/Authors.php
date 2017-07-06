<?php

namespace app\models;
use yii\db\ActiveRecord;    
use yii\web\UploadedFile;
use yii\helpers\Html;

class Authors extends ActiveRecord{
    public $status_id;
    public $status_name;
    public $ava;
    public function rules()
    {
        return [
            [['name'],'required', 'message'=>'Имя обязательно для заполнения'],
            [['status'],'required'],
            [['file'], 'file', 'extensions' => 'png, jpg', 'maxFiles'=> 10],
        ];
    }
    public function getStatus() {
      return [1=>'Активный',2=>'Заблокированный'];
    }
    public function afterFind()
    {
        $this->status_id = $this->status;
        switch($this->status){
            case "1":
                $this->status_name = "Активный";
                
                break;
            case "2":
                $this->status_name = "Заблокирован";
                break;  
            default:
                $this->status_name = "Статус не определён";
                break;
        }
        if(!$this->file) $this->file = '/images/authors/author.png';
        
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
        $path = 'images/authors/'.$this->id.'/';
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
}
?>