<?php
/**
 * Created by PhpStorm.
 * User: YANG
 * Date: 2017/6/25
 * Time: 21:37
 */

namespace app\modules\wx\controllers;

use app\common\components\BaseController;

use app\common\services\RequsetService;


class JssdkController extends BaseController
{
    public  function  actionIndex()
    {	
    	$ticket  = $this->getJsapiTicket();

    	$url = $this->get('url');

    	$time = time();

    	// 生成随机字符串
    	$noncestr = $this->createdNoncestr();

    	$string = "jsapi_ticket={$ticket}&noncestr={$noncestr}&timestamp={$time}&url={$url}";

    	// 签名值
    	$signatrue = sha1( $string );

    	$wxConfig = $config = \Yii::$app->params['wx'];

    	$data = [
    		'appId'=>$wxConfig['appid'],
    		'timestamp'=>$time,
    		'nonceStr'=>$noncestr,
    		'signature'=>$signatrue,
    	];

    	return $this->renderJson( $data, '返回签名', 200);
    }

	/**
	 *生成随机字符串方法
	 */
    public function createdNoncestr( $length = 16 )
    {	
    	$chars = 'qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM0123456789';
    	
    	$str = '';
    	
    	for ($i=0; $i <= $length ;  $i++) 
    	{ 
    		$str.=substr($chars, mt_rand(0, strlen($chars) - 1 ), 1 );
    	}

    	return $str;

    }

    public  function  getJsapiTicket()
    {
    	$cache_key = 'wx_jsticket';

    	$cache = \Yii::$app->cache;

    	$ticket =  $cache->get( $cache_key ) ;

	    if( !$ticket )
	    {

	    	$config = \Yii::$app->params['wx'];

	        RequsetService::setConfig( $config['token'], $config['appid'], $config['sk'] );

	        $assoc_token = RequsetService::getAccessToken();

	       $JS_ticket =  RequsetService::send("ticket/getticket?access_token={$assoc_token}&type=jsapi");
	       	
	       if( isset( $JS_ticket['errcode'] ) && $JS_ticket['errcode'] == 0 )
	       {
	       		$cache->set( $cache_key, $JS_ticket['ticket'], $JS_ticket['expires_in']-200 );

	       		$ticket = $JS_ticket['ticket'];
	       }
	    }	

	    return $ticket;
    }
}