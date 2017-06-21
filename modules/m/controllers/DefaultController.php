<?php
namespace app\modules\m\controllers;

use app\modules\m\controllers\common\BaseMController;

use app\models\BrandImages;
use app\models\BrandSetting;

use app\common\services\captcha\ValidateCode;
use app\common\services\UtilService;
use app\common\services\ConstantMapService;
use app\models\OauthMemberBind;
use app\models\SmsCaptcha;
use app\models\WxShareHistory;


/**
 * Default controller for the `m` module
 */
class DefaultController extends BaseMController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public $layout = 'main';

    private $captcha_cookiename = 'validate_code';

    public function actionIndex()
    {
 
    	$brand_info = BrandSetting::find()->one();

        $imgae_list = BrandImages::find()->orderBy( ['id'=>SORT_DESC] )->all();

        return $this->render('index',[
                'brand_info'=>$brand_info,
                'imgae_list'=>$imgae_list,
            ]);
    }

    // 获取验证码信息图片
    public function actionImg_captcha()
    {
        $font_path = \Yii::$app->getBasePath().'/web/fonts/captcha.ttf';
        $captcha_handle = new ValidateCode( $font_path );
        $captcha_handle->doimg();

        $this->setCookie( $this->captcha_cookiename,$captcha_handle->getCode() );
    }

    // 验证 验证码 内容信息
    public function actionGet_captcha()
    {
        $mobile = trim( $this->post('mobile','') );

        $img_captcha = trim( $this->post('img_captcha','') );

        if( !$mobile || !preg_match('/^1[0-9]{10}$/', $mobile) )
        {
            $this->removeCookie( $this->captcha_cookiename );
            return $this->renderJson([],'请输入正确的手机号',-1 );
        }

        // 获取cookie内容
        $cookie_captcha = $this->getCookie( $this->captcha_cookiename );

        if( strtolower( $cookie_captcha ) != $img_captcha )
        {
             $this->removeCookie( $this->captcha_cookiename );
            return $this->renderJson([],"请输入正确的验证码\r\n你输入的验证码是{$img_captcha}\r\n正确的是{$cookie_captcha}",-1 );
        }


        // 发送手机验证码
        $Sms = new SmsCaptcha();

        $Sms->geneCustomCaptcha( $mobile, UtilService::getIP() );
        
        $this->removeCookie( $this->captcha_cookiename );

        if( $Sms )
        {
            return $this->renderJson( [],"手机验证码是{$Sms->captcha}" ,200 );
        }

        return $this->renderJson( [],ConstantMapService::$default_error_msg,-1 );
    }

    //分享入库记录
    public function actionShared()
    {
       $url =  trim( $this->post( 'url' ,'' ) );
    

        if( !$url ){
            $url = isset( $_SERVER['HTTP_REFERER'] )?$_SERVER['HTTP_REFERER']:'';
        }

        $model_wx_shared = new WxShareHistory();
        $model_wx_shared->member_id = $this->current_user?$this->current_user['id']:0;
        $model_wx_shared->share_url = $url;
        $model_wx_shared->created_time = date("Y-m-d H:i:s");
        $model_wx_shared->save( 0 );
        return $this->renderJSON( [] );
    }
}
