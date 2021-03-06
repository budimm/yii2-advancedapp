<?php

namespace common\controllers;

use Yii;
use dektrium\user\controllers\SecurityController as BaseSecurityController;

class SecurityController extends BaseSecurityController
{
    public function actionCreate()
    {
        // do your magic
    }
    
    /**
     * Displays the login page.
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        $model = $this->module->manager->createLoginForm();

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            Yii::$app->view->params['user'] = [
                                                'loggedIn'=>true,
                                                Yii::$app->wtsecure->sessionUserInfoTag => [
                                                    'id'=>Yii::$app->user->identity->id,
                                                    'username'=>Yii::$app->user->identity->username,
                                                ],
                                                 
                                            ];
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }
    
    /**
     * Logs the user out and then redirects to the homepage.
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        \Yii::$app->getUser()->logout();

        return $this->goHome();
    }
}
