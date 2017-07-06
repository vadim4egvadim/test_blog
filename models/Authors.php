<?php

namespace app\models;
use yii\db\ActiveRecord;    
class Authors extends ActiveRecord{
    public $status_id;
    public $file;
    public $del_img;
    public function rules()
    {
        return [
            [['name'],'required', 'message'=>'Имя обязательно для заполнения'],
            [['status'],'required'],
            [['file'], 'file', 'extensions' => 'png, jpg'],
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
                $this->status = "Активный";
                
                break;
            case "2":
                $this->status = "Заблокирован";
                break;  
            default:
                $this->status = "Статус не определён";
                break;
        }
        
    }
}
?>