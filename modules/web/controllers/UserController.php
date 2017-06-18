<?php 

namespace app\modules\web\controllers;

use yii\web\Controller;

use app\modules\web\controllers\common\BaseWebController;

use \app\common\services\UrlService;

use app\models\User;

/**
 * User controller for the `web` module
 */
class UserController extends BaseWebController
{   
    /**
     * 用户登录
     * @return string
     */
    public function actionLogin()
    {			
        $this->layout = false;

        if( $this->isRequestMethod( 'get' ) )
        {
            return $this->renderPartial( "login" );
        }
        else
        {   
            $login_name = trim( $this->post( 'login_name' ) );
            $login_pwd  = trim( $this->post( 'login_pwd' ) );
            
            // 账户密码不为空 
            if( !$login_name || !$login_pwd )
            {   
                return $this->renderJs( '请输入正确的用户名或者密码',UrlService::buildWebUrl('/user/login') ); 
            }
            
            // 判断账号信息       
            $user_info = User::find()->where( ['login_name'=>$login_name ] )->one();

            // 账户是否存在
            if( !$user_info )
            {
                return $this->renderJs( '请输入正确的用户名或者密码-1',UrlService::buildWebUrl('/user/login') );  
            }

            // 验证密码
            if( !$user_info->verifyPassword( $login_pwd ) )
            {
                return $this->renderJs( '请输入正确的用户名或者密码-2',UrlService::buildWebUrl('/user/login') );
            }

            // 保存用户的 登录状态   
            $this->setLoginStatus( $user_info );
            
            return $this->redirect( UrlService::buildWebUrl('/dashboard/index') );

        }
    }

    /**
     * 用户编辑
     * @return string
     */
    public function actionEdit()
    {   
        if( $this->isRequestMethod( 'get' ) )
        {
    	   return $this->render( "edit", [ 'user_info' => $this->current_user ] ); 
        }
        else
        {
            $nickname = trim( $this->post( 'nickname','' ) );
            $email    = trim( $this->post( 'email','' ) );
            
            if( mb_strlen( $nickname, 'UTF-8') < 1 )
            {
                $this->renderJson( [], '请输入合法的姓名', -1 );
            }

            if( mb_strlen( $email, 'UTF-8') < 1 )
            {
                $this->renderJson( [], '请输入合法的邮箱', -1 );
            }

            $user_info = $this->current_user;

            $user_info->nickname = $nickname;
            $user_info->email    = $email;
            $user_info->updated_time = date('Y-m-d H:i:s');

            $user_info->update( 0 );

            return $this->renderJson( [], "保存成功", 200); 
        }
    }

    /**
     * 用户重置登录密码
     * @return string
     */
    public function actionResetPwd()
    {
        if( $this->isRequestMethod( 'get' ) )
        {
    	   return $this->render( "reset_pwd", [ 'user_info'=>$this->current_user ] );
        }
        else
        {
            $old_password = trim( $this->post( 'old_password', '' ) );
            $new_password = trim( $this->post( 'new_password', '' ) );
       
            if( mb_strlen( $old_password, 'UTF-8' ) < 1 )
            {
                return $this->renderJson( [], '请填写正确的原密码', -1);
            }

            if( mb_strlen( $new_password, 'UTF-8' ) < 1 )
            {
                return $this->renderJson( [], '请填写正确的新密码', -1 );
            }

            if( $old_password == $new_password )
            {
                return $this->renderJson( [], '新密码不能与原密码相同', -1 );
            }
            
            // 判断原密码是否正确
            $user_info  = $this->current_user;

            if( !$user_info->verifyPassword( $old_password ) )
            {
                return $this->renderJson( [], '原密码不正确', -1 );
            }

            // 设置新密码
            $user_info->setPassword( $new_password );

            $user_info->updated_time = date( 'Y-m-d H:i:s' );

            $user_info->update( 0 );

            // 设置登录态
            $this->setLoginStatus( $user_info );

            return  $this->renderJson( [], '重置密码成功', 200 );

          }
        
    }

    /**
     * 用户退出
     * @return string
     */
    public function actionLogout()
    {   
        $this->removeLoginStatus();
         return $this->redirect( UrlService::buildWebUrl('/user/login') );
    }

}





 ?>