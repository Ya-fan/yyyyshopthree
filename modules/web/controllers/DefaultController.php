<?php

namespace app\modules\web\controllers;

use yii\web\Controller;
use app\modules\web\controllers\common\BaseWebController;


/**
 * Default controller for the `web` module
 */
class DefaultController extends BaseWebController
{
    public $layout = 'main';
	
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
