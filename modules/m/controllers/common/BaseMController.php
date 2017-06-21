<?php 
namespace app\modules\m\controllers\common;

use app\common\components\BaseController;

use \app\common\services\UrlService;
use \app\common\services\UtilService;

use app\models\Member;
class BaseMController  extends BaseController
{

	protected $auth_cookie_current_open_id 	= 'shop_m_open_id';
	protected $auth_cookie_name 			= 'yyy_shop_member';
	protected $salt 						= 'zxcvbnmlkjhgfdsaqwertyuiop';
	protected $current_user 				= null;

	//白名单
	protected $allowAllAction = [
		'm/oauth/login',
		'm/oauth/callback',
		'm/oauth/logout',
		'm/user/bind',
		'm/default/img_captcha',
		'm/default/get_captcha',
		'm/product/index',
		'm/product/ops',
	];

	//特殊url
	protected $specialAction = [
		'm/default/index',
		'm/product/info',
	];

	/**
	 * 	继承 父类构造 并统一加载 布局文件
	 */
	public function __construct( $id, $module, array $config=[] )
	{
		parent::__construct( $id, $module, $config );
		
		// 统一继承模板布局
		$this->layout = 'main';

		$imageUrl = \Yii::$app->params['domain']['www'].\Yii::$app->params['title']['image'];
		$share_info = [
			'title'=>\Yii::$app->params['title']['name'],
			'desc'=>\Yii::$app->params['title']['name'],
			'img_url'=>$imageUrl,
		];

		\Yii::$app->view->params['share_info'] = json_encode( $share_info ) ;
	}

	/**
	 * 登录统一验证	(每次动作先执行本方法)
	 */
	public function beforeAction( $action )
	{
		$is_login = $this->checkLoginStatus();

		// 验证白名单
		if( in_array($action->getUniqueId(),$this->allowAllAction) )
		{
			return true;
		}

        if( !$is_login )
        {
            if( $this->isRequestMethod( 'ajax' ) )
            {	
				 echo   $this->renderJson( [], '未登录，系统将引导您重新登陆', -302 );
				return false;
			}
			else
			{	
				$redirect_uri = UrlService::buildMUrl('/user/bind');

				// 微信访问不用登陆 但必须有openid
				if( UtilService::isWechat() )
				{	
					$openid = $this->getCookie( $this->auth_cookie_current_open_id );

					if( $openid )
					{
						if( in_array( $action->getUniqueId(),$this->specialAction ) )
						{
							return true;
						}
					}
					else
					{
						$redirect_uri =  UrlService::buildMUrl( '/oauth/login') ;
					}
				}
				else
				{
					if( in_array( $action->getUniqueId(),$this->specialAction ) )
					{
						return true;
					}
				}

				return $this->redirect( $redirect_uri );
			}

			return false;
		}

		return true;
	}

	protected function checkLoginStatus()
	{

		$auth_cookie = $this->getCookie( $this->auth_cookie_name );

		if( !$auth_cookie )
		{
			return false;
		}

		list($auth_token,$member_id) = explode("#",$auth_cookie);

		if( !$auth_token || !$member_id )
		{
			return false;
		}

		if( $member_id && preg_match("/^\d+$/",$member_id) )
		{
			$member_info = Member::findOne([ 'id' => $member_id,'status' => 1 ]);
			
			if( !$member_info )
			{
				$this->removeAuthToken();
				return false;
			}
			
			if( $auth_token != $this->geneAuthToken( $member_info ) )
			{
				$this->removeAuthToken();
				return false;
			}

			$this->current_user = $member_info;
			\Yii::$app->view->params['current_user'] = $member_info;
			return true;
		}
		return false;
	}

	// 设置登录态
	public function setLoginStatus( $user_info )
	{
		$authtoken = $this->geneAuthToken( $user_info );
		
		$this->setCookie( $this->auth_cookie_name, $authtoken."#".$user_info['id'] );
	}

	// 删除登录态
	protected  function removeLoginStatus()
	{
		$this->removeCookie($this->auth_cookie_name);
	}

	// 设置秘值
	public function geneAuthToken( $member_info )
	{
	 	return	md5( $this->salt."-{$member_info['id']}-{$member_info['mobile']}-{$member_info['salt']}" );
	}

	public function goHome()
	{
		return $this->redirect( \Yii::$app->params['domain']['m'].'/default/index' );
	}

}



 ?>