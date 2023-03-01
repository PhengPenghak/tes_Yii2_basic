<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Customer;
use app\models\CustomerSearch;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

            Customer::update(['status' => '0']);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionIndex()
    {

        // Customer::updateAll(['status' => '1'], ['city_id'=>1], );
        //Customer::deleteAll(['status' => '1'],);



        //print_r(Customer::find()->orderBy(['id' => SORT_DESC])->asArray()->all());
        // $model = new Customer();
        // $model->first_name = 'Pheng';
        // $model->last_name = 'Penghak';
        // $model->city_id = 1;
        // $model->register_date = date("Y-m-d H:i:s");
        // $model->status = 0;
        // if ($model->save()) {
        //     echo "<pre>";
        //     print_r(Customer::find()->orderBy(['id' => SORT_DESC])->asArray()->all());
        // } else {
        //     echo "<pre>";
        //     print_r($model->getErrors());
        // }
        // exit;

        // $array = [
        //     [
        //         'first_name' => 'Pheng',
        //         'last_name' => 'Penghak',
        //         'city_id' => 1,
        //         'register_date' => '2022-11-28',
        //         'status' => 1
        //     ],
        //     [
        //         'first_name' => 'Chhun',
        //         'last_name' => 'Rachhen',
        //         'city_id' => 2,
        //         'register_date' => '2022-11-27',
        //         'status' => 1
        //     ],
        //     [
        //         'first_name' => 'Nguyen',
        //         'last_name' => 'Laem',
        //         'city_id' => 3,
        //         'register_date' => '2022-11-24',
        //         'status' => 1
        //     ],
        // ];
        // if (!empty($array)) {
        //     $tmpArr = [];
        //     foreach ($array as $key => $value) {
        //         $model = new Customer();
        //         $model->first_name = $value['first_name'];
        //         $model->last_name = $value['last_name'];
        //         $model->city_id = $value['city_id'];
        //         $model->register_date = $value['register_date'];
        //         $model->status = $value['status'];
        //         $model->save();
        //         $tmpArr[] = [
        //             $value['first_name'],
        //             $value['last_name'],
        //             $value['city_id'],
        //             $value['register_date'],
        //             $value['status']
        //         ];
        //     }
        //     Yii::$app->db->createCommand()->batchInsert('customer', ['first_name', 'last_name', 'city_id', 'register_date', 'status'], $tmpArr)->execute();
        //     echo "<pre>";
        //     print_r($tmpArr);
        //     print_r(Customer::find()->orderBy(['id' => SORT_DESC])->asArray()->all());
        // }
        // $customer = Yii::$app->db->createCommand(
        //     " SELECT country.id,country.`name` 
        //     FROM `customer`
        //     INNER JOIN country
        //     ON customer.city_id=country.id
        //     GROUP BY `id`;
        // "
        // )->queryall();
        // $customer = Yii::$app->db->createCommand(
        //     "   SELECT country.`name`,country.id 
        //         FROM `customer`
        //         LEFT JOIN country
        //         ON customer.city_id = country.id
        // 	    ORDER BY country.`name`;
        // "
        // )->queryAll();
        // echo "<pre>";
        // print_r($customer);

        // $query = Customer::find();
        // $provider = new ActiveDataProvider([
        //     'query' => $query,

        // ]);
        // returns an array of users objects
        // $customer = $provider->getModels();

        // $dataprovider = new ActiveDataProvider();
        // $data = Customer::find()->asArray()->all();
        // $provider = new ArrayDataProvider();
        // $users = $provider->getModels();
        //var_dump($customer);
        //exit;

        // $dataprovider = new ActiveDataProvider();
        // print_r($dataprovider);
        // exit;
        // $searchModel = new Customer();
        // $dataProvider = $SearchCustomer->Search(Yii::$app->request->queryParams);
        // $searchModel = new CustomerSearch();

        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider = new ActiveDataProvider([
            'query' => Customer::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
