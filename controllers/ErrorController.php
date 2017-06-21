<?php

namespace app\controllers;

use app\common\components\BaseController;

use yii\log\FileTarget;

use app\common\services\AppLogService;

class ErrorController extends BaseController
{
    public $layout = "weishop";
   	
    public function actionError()
  	{  

  		$err_msg = '';

  		$error = \Yii::$app->errorHandler->exception;
  		
  		if( $error )
  		{	
  			// 错误文件
  			$file = $error->getFile();

  			// 错误行号
  			$line = $error->getline();

  			// 错误编码
  			$code = $error->getCode();

  			// 错误信息
  			$message = $error->getMessage();

  			// 错误时间
  			$time = date("Y-m-d H:i:s",time());


  			$log = new FileTarget();

  			// 错误日志路径
  			$errorPath = \Yii::$app->getRuntimePath(). "/logs/error.log";
	 		
	 		  $log->logFile = $errorPath;

  			$url = $_SERVER['REQUEST_URI'];
  			
        // 错误日志信息
  			$err_msg = $message ."  【Url：{$url}】【File：{$file}】【Line：{$line}】【Code：{$code}】【POST_DATA：".http_build_query( $_POST )."】";
 			
  			$log->messages[] = [
  				$err_msg,
  				1,
  				"application",
  				microtime( true ),
  			];

  			$log->export();
  	
  			// todo写入数据库中
        AppLogService::addErrorLog( \Yii::$app->id, $err_msg ); 
  		}

  		return $this->render( "error" ,["err_msg"=>$err_msg]);
  	}
}
 ?>