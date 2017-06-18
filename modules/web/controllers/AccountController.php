<?php 

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseWebController;

use app\models\User;
use app\models\AppAccessLog;

use app\common\services\ConstantMapService;
use app\common\services\UrlService;



/**
 * User controller for the `web` module
 */
class AccountController extends BaseWebController
{
	/**
     * 用户列表
     * @return string
     */
    public function actionIndex()
    {			
        if( $this->isRequestMethod( 'get' ) )
        {
            $status = intval( $this->get('status', ConstantMapService::$status_default) );
            $mix_kw = trim( $this->get('mix_kw', '' ) );
            $page   = intval( $this->get( 'page' ,1 ) );

            $query = User::find();

            if( $status > ConstantMapService::$status_default )
            {
                $query->andWhere( [ 'status'=>$status ] );
            }

            if( $mix_kw )
            {
                $where_nickname = [ 'LIKE', 'nickname', $mix_kw.'%', false ]; 
                $where_mobile = [ 'LIKE', 'mobile', '%'.$mix_kw.'%', false ]; 
                
                $query->andWhere([ 'OR', $where_mobile, $where_nickname ]);
            }

            // 分页
            $page_num = 3;
            $total_count = $query->count();
            $total_page  = ceil( $total_count / $page_num );

            $list = $query->orderBy( [ 'uid'=> SORT_DESC ] )
                          ->offset( ($page-1)*$page_num )   
                          ->limit( $page_num )
                          ->all();

            return $this->render( "index", [ 'list'=>$list ,
                'status_mapping'=> ConstantMapService::$status_maping,
                'status'=>$status,
                'mix_kw'=>$mix_kw,
                'pages'=>[
                     'page'=>$page,
                     'total_count'=>$total_count,
                     'total_page' =>$total_page,
                     'page_num'   =>$page_num,
                   ]

                 ] );
        }
    }

    /**
     * 用户添加或者编辑
     * @return string
     */
    public function actionSet()
    { 
      if( $this->isRequestMethod( 'post' ) )
      {
          $nickname   = trim( $this->post( 'nickname','' ) );
          $mobile     = trim( $this->post( 'mobile','' ) );
          $login_name = trim( $this->post( 'login_name','' ) );
          $email      = trim( $this->post( 'email','' ) );
          $login_pwd  = trim( $this->post( 'login_pwd','' ) );
          $date = date('Y-m-d H:i:s');

          $id  = intval( $this->post( 'id','' ) );

          if( mb_strlen( $nickname, 'utf-8' ) < 1 )
          {
            return $this->renderJson( [], '请您填写正确的姓名', -1 );
          }

           if( mb_strlen( $mobile, 'utf-8' ) < 11 )
          {
            return $this->renderJson( [], '请您填写正确的手机号', -1 );
          }

           if( mb_strlen( $email, 'utf-8' ) < 1 )
          {
            return $this->renderJson( [], '请您填写正确的邮箱地址', -1 );
          }

           if( mb_strlen( $login_name, 'utf-8' ) < 1 )
          {
            return $this->renderJson( [], '请您填写正确的登录', -1 );
          }

           if( mb_strlen( $login_pwd, 'utf-8' ) < 1 )
          {
            return $this->renderJson( [], '请您填写正确的登录密码', -1 );
          }

          if( $id )
          {
            $module_user = User::find()->where( ['uid'=>$id] )->one();
          }
          else
          {
            //查找用户名
            $count = User::find()->where( [ 'login_name' => $login_name ] )->count();
              if( $count )
              {
                return $this->renderJson( [], '该用户名已经存在', -1 ); 
              }

              $module_user = new User();
          }

          $module_user->nickname = $nickname;
          $module_user->mobile   = $mobile;
          $module_user->email    = $email;
          $module_user->avatar   = ConstantMapService::$status_avatar; 
          $module_user->login_name = $login_name;

          if( $login_pwd != ConstantMapService::$default_pwd )
          {
              // 设置加密salt
              $module_user->setSalt();

              // 加密密码
              $module_user->setPassword( $login_pwd );
              $module_user->created_time = $date;
          }
      
         
          $module_user->updated_time = $date;

          $module_user->save();

          return $this->renderJson( [], '保存成功', 200 );

      }
      else
      {
          $id = intval( $this->get( 'id' ,'') ) ;

          $user_info = null;

          if( $id )
          {
             $user_info = User::find()->where( [ 'uid'=>$id ] )->one();
          }

        	return $this->render( "set", [
                    'user_info'=>$user_info,
            ] );
      }


    }

     /**
     * 账户详情
     * @return string
     */
    public function actionInfo()
    { 
        if( $this->isRequestMethod( 'get' ) )
        {
            $id = intval( $this->get('id',0) );  

            if( !$id )
            {
              $this->redirect( UrlService::buildWebUrl('/account/index') );
            }

            $user_info = User::find()->where( [ 'uid'=>$id ] )->one();
              
            $log_info = AppAccessLog::find('created_time,target_url')->where( [ 'uid'=>$id ] )->orderBy( ['id'=>SORT_DESC] )->limit(10)->all();

            return $this->render( "info" ,[
                          'user_info'=>$user_info,
                          'log_info'=>$log_info,
              ]);
        }


    }

    /**
     *  账号操作   (删除)
     * @return  
     */
    public function actionOps()
    {
        if( $this->isRequestMethod( 'post' ) )
        {
            $this->renderJson( [], '对不起，服务器繁忙', -1 );
        }

        $act = trim( $this->post( 'act', '' ) );

        $uid = intval( $this->post( 'uid','' ) ) ;

        if( !$uid )
        {
            return $this->renderJson( [],'操作有误，请重试',-1 );
        }

        if( empty( $act ) )
        {
            return $this->renderJson( [],'操作有误，请重试2',-1 );
        }

        $user_info = User::find()->where( [ 'uid'=>$uid ] )->one();

        if( !$user_info )
        {
            return $this->renderJson( [],'您的账号不存在',-1 );
        }

        switch ($act) {
            case 'remove':
                $user_info->status = 0;
              
                break;
            
            default:
                $user_info->status = 1;
                break;
        }

          $user_info->updated_time = date( 'Y-m-d H:i:s' );
          $user_info->update( 0 );

      return  $this->renderJson( [],'您的操作成功' , 200 );
    }






}



 ?>