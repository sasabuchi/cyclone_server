<?php

namespace app\controllers;

use Yii;
use app\controllers\CLogger;
use yii\db\Query;
use app\models\Customer;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CycloneActionController implements the CRUD actions for CycloneAction model.
 */
class CustomerController extends Controller
{
    public $enableCsrfValidation = false;

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
        ];
    }

    public function actionApiauth()
    {
        $params = $_POST;
        $model = Customer::find()->where(['device_id' => $params["device_id"]])->one();

        if (empty($model)) {
            $model = new Customer();
            $model->name = "名無し";
        }

        $model->attributes = $params;
        $model->save();

        $this->setHeader(400);
        echo json_encode($model->attributes, JSON_PRETTY_PRINT);
    }

    public function actionApiget()
    {
        $params = $_POST;
        if ($params["customer_id"]) {
            $model = Customer::find()->where(['customer_id' => $params["customer_id"]])->one();
        } else if ($params["device_id"]) {
            $model = Customer::find()->where(['device_id' => $params["device_id"]])->one();
        } else {
            $this->setHeader(400);
            echo json_encode(array('status'=>0,'error_code'=>400), JSON_PRETTY_PRINT);
        }

        $this->setHeader(400);
        echo json_encode($model->attributes, JSON_PRETTY_PRINT);
    }

    private function setHeader($status)
    {
 
      $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
      $content_type="application/json; charset=utf-8";
 
      header($status_header);
      header('Content-type: ' . $content_type);
      header('X-Powered-By: ' . "Nintriva <nintriva.com>");
    }
}
