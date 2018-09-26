<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\IndexForm;
use app\models\KvartiraSearch;
use app\models\WapkaSaita;
use app\models\Okompanii;
use app\models\Zametki;
use app\models\Zametki2;
use app\models\Yspehi;
use app\models\Inform;
use app\models\Yslygi;
use app\models\Client;
use app\models\Akcii;
use app\models\Zapis;




use app\models\Kvartira;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use yii\db\Query;


class SiteController extends Controller
{
    
	
	
	
	
	
	
	
	/**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
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
                'class' => VerbFilter::className(),
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
    public function actionIndex()
    {
		$this->dannueMain();
		
		$searchModel = new KvartiraSearch();
		$searchModel->load(Yii::$app->request->post());
		$query = $searchModel->search(Yii::$app->request->queryParams);
		
		
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		
		$dataProvider->sort->attributes['cena'] = [
			'asc' => ['cena' => SORT_ASC],
			'desc' => ['cena' => SORT_DESC],
		];
		
		
		
		$posts = $dataProvider->getModels();	
		$okompanii = $this->findOkompanii("1");
		$zametki = $this->findZametki("1");
		$zametki2 = $this->findZametki2("1");
		$yspehi = $this->findYspehi("1");
		$inform = $this->findInform("1");
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'okompanii' => $okompanii,
			'zametki' => $zametki,
			'zametki2' => $zametki2,
			'yspehi' => $yspehi,
			'inform' => $inform,
        ]);
    }
	
	
	
	
	public function actionZametka($id_statya)
    {
		$this->dannueMain();
		
		Yii::$app->params["id_statya"] = $id_statya;
		
		if(Yii::$app->params["id_statya"] >= 1 && Yii::$app->params["id_statya"] <= 6){
			$zametki = $this->findZametki("1");
		}
		else if(Yii::$app->params["id_statya"] > 6 && Yii::$app->params["id_statya"] <= 9){
			$zametki = $this->findInform("1");
		}
		else if(Yii::$app->params["id_statya"] > 9 && Yii::$app->params["id_statya"] <= 15){
			$zametki = $this->findYslygi("1");
		}
		else if(Yii::$app->params["id_statya"] > 15 && Yii::$app->params["id_statya"] <= 17){
			$zametki = $this->findAkcii("1");
		}
		
		return $this->render('statya', [
			'statya' => $zametki,
		]);
		
        
    }
	
	
	
	
	
	public function actionZapis()
    {
		$this->dannueMain();
		
		$model = new Zapis();
		
		
		if ($model->load(Yii::$app->request->post())) {		
			if($model->save()){
				return $this->render('zapis_good', [
					'model' => $model,
				]);
			}
		}
		
		return $this->render('zapis', [
			'model' => $model,
		]);
    }
	
	
	
	
	
	
	
	
	protected function findModelWapka($id)
    {
        if (($model = WapkaSaita::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function dannueMain()
    {
        $wapkaSaita = $this->findModelWapka("1");
		foreach ($wapkaSaita as $name => $value) {
			Yii::$app->params[$name] = $value;
		}
    }
	
	
	
	
	
	
	protected function findOkompanii($id)
    {
        if (($model = Okompanii::findOne($id)) !== null) {
            return $model;
        }
		
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findZametki($id)
    {
        if (($model = Zametki::findOne($id)) !== null) {
            return $model;
        }
		
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findZametki2($id)
    {
        if (($model = Zametki2::findOne($id)) !== null) {
            return $model;
        }
		
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findYspehi($id)
    {
        if (($model = Yspehi::findOne($id)) !== null) {
            return $model;
        }
		
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findInform($id)
    {
        if (($model = Inform::findOne($id)) !== null) {
            return $model;
        }
		
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findYslygi($id)
    {
        if (($model = Yslygi::findOne($id)) !== null) {
            return $model;
        }
		
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findClient($id)
    {
        if (($model = Client::findOne($id)) !== null) {
            return $model;
        }
		
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findAkcii($id)
    {
        if (($model = Akcii::findOne($id)) !== null) {
            return $model;
        }
		
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->dannueMain();
		
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
	 
	 
    public function actionUslugi()
    {
        $this->dannueMain();
		
		$yslygi = $this->findYslygi("1");
		
        return $this->render('uslugi', [
			'yslygi' => $yslygi,
        ]);
		
		
    }
	
	
	
	public function actionClient()
    {
        $this->dannueMain();
		
		$client = $this->findClient("1");
		
        return $this->render('client', [
			'client' => $client,
        ]);
    }
	
	
	
	public function actionAkcii()
    {
        $this->dannueMain();
		
		$akcii = $this->findAkcii("1");
		
        return $this->render('akcii', [
            'akcii' => $akcii,
        ]);
    }
	
	
	
}

















