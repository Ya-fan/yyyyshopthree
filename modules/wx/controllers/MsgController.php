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
        if(!$this->checkSignate())
        {
            return 'error signature~~~';
        }

        if( array_key_exists("echostr", $_GET) && $_GET['echostr'] )
        {
            return $_GET['echostr'];
        }
    }

    public function checkSignate()
    {
    	$signature = trim( $this->get('signature' ,'') );
    	$timestamp = trim( $this->get('timestamp' ,'') );
    	$nonce     = trim( $this->get('nonce' ,'') );
    	// $echostr   = trim( $this->get('echostr' ,'') );
    
        $tmpArr = array( \Yii::$app->params['wx']['token'] ,$timestamp,$nonce);

        sort($tmpArr);

        $tmpArr = implode($tmpArr);

        $tmpStr = sha1( $tmpArr );
        if( $tmpStr == $signature )
        {
            return true;
        }
        else
        {
            return false;
        }
    }


}
