<?php

namespace app\controllers;

use Yii;
use app\controllers\CLogger;
use yii\db\Query;
use app\models\CycloneAction;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CycloneActionController implements the CRUD actions for CycloneAction model.
 */
class CycloneActionController extends Controller
{
    public $enableCsrfValidation = false;

    const ORDER_UPLOAD_DATE = 0;
    const ORDER_NUMBER_OF_PLAYS = 1;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [/*'create', 'update',*/ 'delete'],
                'rules' => [
                    [
                        'actions' => [/*'create', 'update',*/ 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
/*
            'corsFilter' => [
              'class' => \yii\filters\Cors::className(),
              'cors' => [
                // restrict access to
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['POST', 'PUT', 'HEAD', 'OPTIONS'],
                // Allow only POST and PUT methods
                'Access-Control-Request-Headers' => ['Origin', 'X-Requested-With', 'Content-Type', 'Accept'],
                // Allow only headers 'X-Wsse'
                'Access-Control-Allow-Credentials' => true,
                // Allow OPTIONS caching
                //'Access-Control-Max-Age' => 3600,
                // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                //'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
              ],
            ],
            */
        ];
    }

    /**
     * Lists all CycloneAction models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => CycloneAction::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CycloneAction model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CycloneAction model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CycloneAction();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cyclone_action_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CycloneAction model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cyclone_action_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CycloneAction model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionApicount()
    {
        $params = $_POST;
        $filter = array();

        $query = new Query;
 
        if(isset($params['dateFilter']))
        {
          $dateFilter=(array)json_decode($params['dateFilter']);
        }

        if(isset($dateFilter['from']))
        {
          $query->andWhere("create_date >= '".$dateFilter['from']."' ");
        }
           
        if(isset($dateFilter['to']))
        {
          $query->andWhere("create_date <= '".$dateFilter['to']."'");
        }

        if(isset($params['ids']))
        {
          $query->andWhere("cyclone_action_id IN (".$params['ids'].")");
        } else {
          $query->andFilterWhere(['like', 'shown', 1]);
        }

        $query
          ->from('dtb_cyclone_action')
        //->andFilterWhere(['like', 'cyclone_action_id', $filter['cyclone_action_id']])
        //->andFilterWhere(['like', 'name', $filter['name']])
          //->andFilterWhere(['like', 'shown', 1])
          ->select("cyclone_action_id, name, action_data_path, movie_url, create_date, update_date");
           

        $totalItems = $query->count();
        Yii::trace($totalItems);
        
        $this->setHeader(200);
 
        echo json_encode(array("count"=>$totalItems), JSON_PRETTY_PRINT);
 
    }

    public function actionApilist()
    {
        $params = $_POST;
        $filter = array();
        $sort = "cyclone_action_id desc";
        $page=0;
        $limit=10;

        if(isset($params['page']))
          $page=$params['page'];
 
        if(isset($params['limit']))
          $limit=$params['limit'];
 
        $offset=$limit * $page;

        /* Filter elements */
        if(isset($params['filter']))
        {
          $filter=(array)json_decode($params['filter']);
        }

        $query = new Query;
 
        if(isset($params['dateFilter']))
        {
          $dateFilter=(array)json_decode($params['dateFilter']);
        }

        if(isset($dateFilter['from']))
        {
          $query->andWhere("create_date >= '".$dateFilter['from']."' ");
        }
           
        if(isset($dateFilter['to']))
        {
          $query->andWhere("create_date <= '".$dateFilter['to']."'");
        }

        if(isset($params['ids']))
        {
          $query->andWhere("cyclone_action_id IN (".$params['ids'].")");
        } else {
          $query->andFilterWhere(['like', 'shown', 1]);
        }
 
        if(isset($params['order']))
        {
          if ($params['order'] == self::ORDER_UPLOAD_DATE) {
            $sort = "update_date desc";
          } else if ($params['order'] == self::ORDER_NUMBER_OF_PLAYS) {
            $sort = "play_count desc";
          }
        }
        
        $query->offset($offset)
          ->limit($limit)
          ->from('dtb_cyclone_action')
        //->andFilterWhere(['like', 'cyclone_action_id', $filter['cyclone_action_id']])
        //->andFilterWhere(['like', 'name', $filter['name']])
          //->andFilterWhere(['like', 'shown', 1])
          ->orderBy($sort)
          ->select("cyclone_action_id, name, genre_id, device_id, author, play_count, action_data_path, movie_url, create_date, update_date");
 
        $command = $query->createCommand();
        $models = $command->queryAll();

        $totalItems=$query->count();
        $this->setHeader(200);
 //Yii::trace($models);
        
        echo json_encode($models,JSON_PRETTY_PRINT);
    }

    public function actionApigetaction()
    {
        $params = $_POST;
        
        //Yii::info($_POST);

        $query = new Query;
        $query->from('dtb_cyclone_action')
        ->andFilterWhere(['like', 'cyclone_action_id', $params['cyclone_action_id']])
        ->select("cyclone_action_id, name, action_data_path");
           
        $command = $query->createCommand();
        $model = $command->queryOne();

        // actions
        $fp = fopen($model["action_data_path"],  'r');
        $moves = array();
        while ($data = fgetcsv($fp)) {
          // csvファイルの列数だけ実行
          $move = array();
          $move["seconds"] = $data[0];
          $move["direction"] = $data[1];
          $move["torque"] = $data[2];
          $moves[] = $move;
        }

        // play_count+1
        $action = $this->findModel($model['cyclone_action_id']);
        $action->play_count = $action->play_count + 1; 
        $action->save();

        $this->setHeader(200);
 
        echo json_encode($moves, JSON_PRETTY_PRINT);
    }


    public function actionApiviewid($id)
    {
        $model=$this->findApiModel($id);
 
        $this->setHeader(200);
        echo json_encode(array('status'=>1,'data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);
    }

    public function actionApicreate()
    {
        $params = $_REQUEST;
 
        $model = new CycloneAction();
        $model->attributes = $params;

        $nowDate = date("Y-m-d H:i:s");
        $model->action_data_path =  Yii::$app->params['csvDir'] . date("Ymd_His") . '.csv';

        if (empty($params["author"]) && isset($params["device_id"])) {
          $customer = Customer::find()->where(['device_id' => $params["device_id"]])->one();
          $model->author = $customer->name;
        }

        $fp = fopen($model->action_data_path, 'w');

        foreach (json_decode($params['actions'], true) as $data) {
          fwrite( $fp, $data['seconds'] . "," . $data['direction']  . "," . $data['torque'] . "\n");
        }
        fclose($fp);

        $model->create_date = $nowDate;
        $model->update_date = $nowDate;

        if ($model->save()) {
            $this->setHeader(200);
            echo json_encode(array('status'=>1,'data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);
        } else {
            $this->setHeader(400);
            echo json_encode(array('status'=>0,'error_code'=>400,'errors'=>$model->errors),JSON_PRETTY_PRINT);
        }
    }

    public function actionApiupdate()
    {
        $params = $_POST;
 
        $model = $this->findApiModel($id);
        $model->attributes = $params;

        if ($model->save()) {
            $this->setHeader(200);
            echo json_encode(array('status'=>1,'data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);
        } else {
            $this->setHeader(400);
            echo json_encode(array('status'=>0,'error_code'=>400,'errors'=>$model->errors),JSON_PRETTY_PRINT);
        }
    }

  /* function to find the requested record/model */
  protected function findApiModel($id)
  {
      if (($model = User::findOne($id)) !== null) {
      return $model;
      } else {
 
    $this->setHeader(400);
    echo json_encode(array('status'=>0,'error_code'=>400,'message'=>'Bad request'),JSON_PRETTY_PRINT);
    exit;
      }
  }

          /* Functions to set header with status code. eg: 200 OK ,400 Bad Request etc..*/      
    private function setHeader($status)
    {
 
      $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
      $content_type="application/json; charset=utf-8";
 
      header($status_header);
      header('Content-type: ' . $content_type);
      header('X-Powered-By: ' . "Nintriva <nintriva.com>");
    }
    private function _getStatusCodeMessage($status)
    {
      $codes = Array(
      200 => 'OK',
      400 => 'Bad Request',
      401 => 'Unauthorized',
      402 => 'Payment Required',
      403 => 'Forbidden',
      404 => 'Not Found',
      500 => 'Internal Server Error',
      501 => 'Not Implemented',
      );
      return (isset($codes[$status])) ? $codes[$status] : '';
    }

    /**
     * Finds the CycloneAction model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CycloneAction the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CycloneAction::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
