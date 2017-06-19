<?php

namespace app\modules\wx\controllers;

use yii\web\Controller;

use app\common\components\BaseController;


/**
 * Msg controller for the `wx` module
 */
class MsgController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return 'jjjjj';
    }

    public function checkSignate()
    {
    	$signature = trim( $this->get('signature' ,'') );
    	$timestamp = trim( $this->get('timestamp' ,'') );
    	$nonce = trim( $this->get('nonce' ,'') );
    	$echostr = trim( $this->get('echostr' ,'') );
    }


}
