<?php 
namespace app\modules\m\controllers;

use app\modules\m\controllers\common\BaseMController;

use yii\web\Controller;
use app\common\services\UrlService;
use app\common\services\ConstantMapService;

use app\common\components\HttpClient;

use app\models\OauthAccessToken;
use app\models\OauthMemberBind;
use app\models\Member;


/**
 * Oauth controller for the `m` module
 */
class OauthController extends BaseMController
{
	
	public function actionLogin()
	{

		$scope = $this->get('scope','snsapi_userinfo');

		$appid = \Yii::$app->params['wx']['appid'];

		$redirect_uri = UrlService::buildMUrl('/oauth/callback');

		$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state=STATE#wechat_redirect";

		return $this->redirect( $url );
	}

	public function actionCallback()
	{
		$code = $this->get( 'code','' );

		if( !$code )
		{
			return $this->goHome();
		}

		$appid 	= \Yii::$app->params['wx']['appid'];
		$sk 	= \Yii::$app->params['wx']['sk'];

		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$appid}&secret={$sk}&code={$code}&grant_type=authorization_code";
		$ret = HttpClient::get( $url );

		$ret = @json_decode($ret,true);

		$access_token = isset( $ret['access_token'] ) ? $ret['access_token'] : '';

		$openid = isset( $ret['openid'] ) ? $ret['openid'] : '';
		$scope = isset( $ret['scope'] ) ? $ret['scope'] : '';

		if( !$access_token )
		{
			return $this->goHome();
		}

		if( !$openid )
		{
			return $this->goHome();
		}
		
		$this->setCookie( $this->auth_cookie_current_open_id ,$openid );

		$MemberBind =  OauthMemberBind::find()->where( ['openid'=>$openid ,'type'=>ConstantMapService::$client_type_wechat] )->one();

		if( $MemberBind )
		{	
			$MemberInfo = Member::find()->where( [ 'id'=>$MemberBind['member_id'] ,'status'=>1 ] )->one(); 

			if( !$MemberInfo )
			{	
				$MemberBind->delete();
				$this->goHome();
			}

			if( $scope == 'snsapi_userinfo' )
			{
				$url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
				
				$userinfo = HttpClient::get( $url );
				$userinfo = @json_decode($userinfo,true);
				
				if( $MemberInfo['nickname'] == $MemberInfo['mobile'] )
				{
					$MemberInfo->nickname = isset( $userinfo['nickname'] ) ?$userinfo['nickname']:$MemberInfo->nickname;
					$MemberInfo->update( 0 );
				}
			}

			// 设置登录态
			$this->setLoginStatus( $MemberInfo );
		}

		return $this->redirect( \Yii::$app->params['domain']['m'].'/default/index' );
	}

	public function actionLogout()
	{
		$this->removeLoginStatus();
		$this->removeCookie( $this->auth_cookie_current_open_id )  ;

		$this->goHome();	
	}



}