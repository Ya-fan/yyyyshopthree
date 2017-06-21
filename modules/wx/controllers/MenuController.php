<?php

namespace app\modules\wx\controllers;

use yii\web\Controller;
use app\common\services\BaseService;

use app\common\components\BaseController;
use app\common\services\UrlService;
use app\common\services\RequsetService;
/**
 * Msg controller for the `wx` module
 */
class MenuController extends BaseController
{

	public function actionSet()
	{
		$menu = [
			"button"=>[
 				[
 					"name"	=>"图书商城",
 					"type"	=>"view",
 					"url"	=>"http://yangfan.tunnel.echomod.cn/m/default/index",
 				],
 				[
 					"name"	=>"我的",
 					"type"	=>"view",
 					"url"	=>UrlService::buildMUrl('/oauth/login'),
 				],	
			],
		];
		$config = \Yii::$app->params['wx'];

		// 设置 微信配置
		RequsetService::setConfig( $config['token'], $config['appid'], $config['sk'] );

		// 获取 access_token
		$access_token =  RequsetService::getAccessToken( );

		if( $access_token )
		{
			$url = "menu/create?access_token={$access_token}";
		 	$data = json_encode($menu,JSON_UNESCAPED_UNICODE );
			
			$res = 	RequsetService::send( $url, $data ,'post' );

			if( !$res)
			{
				echo BaseService::getLastErrorMsg();
			}
			else
			{
				var_dump($res);
			}
		}


	}






}
?>