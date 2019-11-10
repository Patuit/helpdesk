<?php

namespace backend\controllers;

use backend\models\SignupForm;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Request;
use common\models\RequestUser;
use yii\web\HttpException;

/**
 * Site controller
 */
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
                'rules' => [
                    [
                        'actions' => ['signup', 'login', 'error', 'unload'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'view', 'update'],
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Request();
        $data = Request::find()->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $data,
            'sort' => ['attributes' => ['id', 'title', 'type', 'priority', 'status', 'mark']]
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /*
     * Просмотр заявки
     */
    public function actionView($id = NULL)
    {
        if ($id === NULL || empty($id))
            throw new HttpException(404, 'id заявки пуст');

        $model = Request::find()->where(['id' => $id])->one();
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /*
    * Редактирование заявки
    */
    public function actionUpdate($id = NULL)
    {
        if ($id === NULL || empty($id))
            throw new HttpException(404, 'id заявки пуст');

        $model = Request::find()->where(['id' => $id])->one();
        if ($model === NULL)
            throw new HttpException(404, 'Заявка не найдена');

        if ($model->time_complete === NULL) {
            $model->time_complete = date("H:i:s", mktime(0, 0, 0));
        }

        if ($model->time_working === NULL) {
            $model->time_working = date("H:i:s", mktime(0, 0, 0));
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->mark = 0;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Заявка успешно отредактирована.');
                return $this->redirect('index.php');
            } else {
                Yii::$app->session->setFlash('error', 'Произошла ошибка при редактировании Заявки!');
            }
        } else {
            // Если уже кто-то редактирует заявку, то предоставляем ему только просмотр
            if ($model->mark === 1) {
                return $this->redirect('index.php?r=site%2Fview&id=' . $id);
            } else {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $model->mark = 1;
                    $model->save();

                    RequestUser::deleteAll(['request_id' => $model->id]);

                    $requestUser = new RequestUser();
                    $requestUser->user_id = Yii::$app->user->identity->id;
                    $requestUser->request_id = $model->id;
                    $requestUser->save();

                    $transaction->commit();

                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Произошла ошибка при попытке редактирования заявки!');
                }

            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /*
     * Сброс метки "Редактирование" после закрытия страницы
     */
    public function actionUnload()
    {
        $id = $_POST['id'];
        $model = Request::find()->where(['id' => $id])->one();
        $model->mark = 0;
        return $model->save();
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
