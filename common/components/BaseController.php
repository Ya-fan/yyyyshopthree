<?php 

namespace app\common\components;

use yii\web\Controller;
/*
*  集成公用方法 提供所有的Controller使用
*  get,post,setCookie,getCookie,removeCookie,rendeJosn
*/
class BaseController extends Controller
{	
	/**
	 *关闭Csrf	
	 * @return	bool
	 */ 
	public $enableCsrfValidation  = false;

	/*
	 *get方法	
	 *
	 */ 
	public function get( $name, $default_val='' )
	{
		$request_Get = \Yii::$app->request->get($name, $default_val);
		
		return $request_Get;
	}

	/*
	 *post方法	
	 *
	 */ 
	public function post( $name, $default_val='' )
	{
		$request_Post = \Yii::$app->request->post($name, $default_val);
		
		return $request_Post; 
	}

	/*
	 *设置cookie	
	 *
	 */ 
	public function setCookie( $name, $default_val , $expire = 0 )
	{
		$response_Cookie = \Yii::$app->response->cookies;		

		$response_Cookie->add( new \yii\web\Cookie( [
			   'name'=>$name,

			   'value'=>$default_val,

			   'expire'=>$expire,

			] ) );
	}

	/*
	 *获取Cookie	
	 *
	 */ 
	public function getCookie( $name, $default_val='' )
	{
		$request_Cookie = \Yii::$app->request->cookies;	
		$value = $request_Cookie->getValue( $name,$default_val );

		return $value;
	}

	/*
	 *删除Cookie	
	 *
	 */ 
	public function removeCookie( $name )
	{
	    $response_Cookie = \yii::$app->response->cookies;
	    $response_Cookie->remove( $name );
	}

	/*
	 *api统一返回json格式	
	 *
	 */
	public function renderJson( $data=[], $msg='OK' ,$code=200)
	{
		header('content-type:application/json');

		return json_encode([
				'code'=>$code,

				'msg'=>$msg,
				
				'data'=>$data,
				
				'req_id'=>uniqid(),
			]);
	}

	/**
	 * 统一js提醒方法	
	 * @return	bool
	 */
	public function  renderJs( $msg, $url )
	{
		return $this->renderPartial( "@app/views/common/js" ,[ 'msg' => $msg, 'url' => $url ] );
	}


	// 判断请求方式
	public function isRequestMethod( $method )
	{
		switch ( $method ) {
			case 'get':
				if( \Yii::$app->request->isGet )
				{
					return true;
				}
				else
				{
					return false;
				}
				break;

			case 'post':
				if( \Yii::$app->request->isPost )
				{
					return true;
				}
				else
				{
					return false;
				}
				break;

			case 'ajax':
				if( \Yii::$app->request->isAjax )
				{
					return true;
				}
				else
				{
					return false;
				}
				break;	

			default:
				return false;
				break;
		}
	}




}

