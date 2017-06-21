<?php 
namespace app\common\services;

use app\common\components\HttpClient;
use app\common\services\BaseService;
use app\models\OauthAccessToken;

use app\common\services\UrlService;

class RequsetService extends BaseService
{

	private static $token  = '';
	private static $appid  = '';
	private static $app_secret  = '';
	
	private static $url  = 'https://api.weixin.qq.com/cgi-bin/';



	public static function getAccessToken()
	{
		// date_default_timezone_set('PRC') ;

		$date_now = date('Y-m-d H:i:s');

		$access_token_info = OauthAccessToken::find()->where( ['>','expired_time',$date_now] )->limit(1)->one();
	
		if( $access_token_info )
		{
			return $access_token_info['access_token'];
		}
		else
		{
			// 调取接口	
			$path = 'token?grant_type=client_credential&appid='.self::getAppid().'&secret='.self::getApp_secret();

			$res  = self::send($path );
			if( !$res )
			{
				return self::_err( self::getLastErrorMsg() );
			}

			$model_access_token = new OauthAccessToken();
			
			$model_access_token->access_token = $res['access_token'];	
			$model_access_token->expired_time = date('Y-m-d H:i:s',$res['expires_in']+time() -200 );	
			$model_access_token->created_time = $date_now;	

			$model_access_token->save( 0 );

			return $res['access_token'];
		}
		
	}

	// 发送接口
	public static function send( $path, $data=[], $method ='get' )
	{
		$requsetUrl = self::$url.$path;

		if( $method =='get' )
		{
			$res = HttpClient::get( $requsetUrl, $data );
		}
		else
		{
			$res = HttpClient::post( $requsetUrl, $data );
		} 

		$ret = @json_decode( $res ,true );

		if( !$ret || ( isset( $ret['errcode'] ) && $ret['errcode'] ) )
		{
			return self::_err( $ret['errmsg'] );
		}

		return $ret;
	}

	public static function setConfig( $token, $appid, $app_secret )
	{
		self::$token = $token;
		self::$appid = $appid;
		self::$app_secret = $app_secret;
	}

	public static function getAppid()
	{
		return self::$appid;
	}

	public static function getToken()
	{
		return self::$token;
	}

	public static function getApp_secret()
	{
		return self::$app_secret;
	}

}


 ?>