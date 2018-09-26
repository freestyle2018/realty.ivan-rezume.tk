<?php

namespace app\controllers;

class PjaxController extends \yii\web\Controller
{
    public function actionPjaxExample()
    {
        return $this->render('pjax-example');
    }

}
