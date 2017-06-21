<?php 
namespace app\common\services;

use app\common\services\UtilService;

use app\models\AppLog;
use app\models\AppAccessLog;


// 错误日志类
class AppLogService
{

	/**
	 * 记录错误日志
	 * @param string $appname
	 * @param strinf $content
	 */	
	public static function addErrorLog( $appname, $content )
	{
		$error = \yii::$app->errorHandler->exception;

		$modle_app_log = new AppLog();
		
		$modle_app_log->app_name = $appname;

		$modle_app_log->content = $content;

		$modle_app_log->ip = UtilService::getIP();

		if( !empty( $_SERVER['HTTP_USER_AGENT'] ) )
		{
			$modle_app_log->ua = $_SERVER['HTTP_USER_AGENT'];
		}

		// 错误码 以及 状态码,错误名称
		if( $error )
		{
			$modle_app_log->err_code = $error->getCode();

			if( isset( $error->statusCode ) )
			{
				$modle_app_log->http_code = $error->statusCode;
			}
			
			if( method_exists( $error, 'getName' ) )
			{
				$modle_app_log->err_name = $error->getName();
			}
		}

		$modle_app_log->created_time = date('Y-m-d H:i:s');

		$modle_app_log->save( 0 );
	}

	// 用户访问日志写入
	public static function addAppAccessLog( $uid = 0 )
	{
		$get_params = \Yii::$app->request->get( );
	
		$post_params = \Yii::$app->request->post( );
		
		$target_url = isset( $_SERVER['REQUEST_URI'] ) ? $_SERVER['REQUEST_URI'] : ''; 
		$referer 	= isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : ''; 
		$ua 		= isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : ''; 

 		$access_log = new AppAccessLog();

 		$access_log->uid 			= $uid ;
 		$access_log->referer_url 	= $referer ;
 		$access_log->ua 			= $ua ;
 		$access_log->target_url 	= $target_url ;
 		$access_log->query_params 	= json_encode( array_merge($post_params,$get_params) ) ;
		$access_log->ip 			= UtilService::getIP();
		$access_log->created_time   = date( 'Y-m-d H:i:s' );

		return $access_log->save( 0 );

	}






















}


 ?>