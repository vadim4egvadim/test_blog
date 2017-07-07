<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * PostsController implements the CRUD actions for Post model.
 */
class PostsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {   
        if(Yii::$app->user->isGuest){
             $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->where(['status' => 1])->andWhere("`publishedon`<='".date('Y-m-d')."'"),
            ]);
        } else {
            $dataProvider = new ActiveDataProvider([
            'query' => Post::find(),
            ]);
        }
       

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function uploadFiles($model){
        $path = 'images/posts/'.$model->id.'/';
        $model->createDirectory($path);
        $model->file=UploadedFile::getInstances($model,'file');
        if(is_null($model->file)) return false;
        //echo var_dump($model->file);
        foreach ($model->file as $file) {
            $file->saveAs($path.$file->baseName . '.' . $file->extension);
        }
       
        
    }
    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $model->created_at = time();
        $model->updated_at = time();
        
        if ($model->load(Yii::$app->request->post())) {
            
            $model->save();
            $this->uploadFiles($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $model->publishedon = time();
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = time();        
        if ($model->load(Yii::$app->request->post())) {
            $model->save();
            $this->uploadFiles($model);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDelimage($id,$name)
    {
        $path = 'images/posts/'.$id.'/'.$name;
        unlink($path);
        return $this->redirect(['view', 'id' => $id]);
    } 
    
    public function actionSetava($id,$name)
    {
        $path = '/images/posts/'.$id.'/'.$name;
        $model = $this->findModel($id);
        $model->file = $path;
        $model->update();
        return $this->redirect(['view', 'id' => $id]);
    } 
    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
