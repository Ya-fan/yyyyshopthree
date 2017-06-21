<?php 
namespace app\modules\web\controllers;

use yii\web\Controller;
use app\modules\web\controllers\common\BaseWebController;

use app\models\Member;

use app\common\services\ConstantMapService;

class MemberController extends BaseWebController
{
	/**
     * 会员列表
     * @return string
     */
	public function actionIndex()
	{			

        $status = intval( $this->get('status', ConstantMapService::$status_default) );
        $mix_kw = trim( $this->get('mix_kw', '' ) );
        $page   = intval( $this->get( 'page' ,1 ) );

        $query = Member::find();

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

        $member_info = $query->orderBy( [ 'id'=> SORT_DESC ] )
                          ->offset( ($page-1)*$page_num )   
                          ->limit( $page_num )
                          ->all();

        return $this->render('index',[
        			'member_info'=>$member_info,
                    'status_maping'=>ConstantMapService::$status_maping,
                    'status'=>$status,
                    'mix_kw'=>$mix_kw,
                    'pages'=>[
                         'page'=>$page,
                         'total_count'=>$total_count,
                         'total_page' =>$total_page,
                         'page_num'   =>$page_num,
                       ]
        	]);
	}

	/**
     * 会员详情
     * @return string
     */
	public function actionInfo()
	{  

        $id = trim( $this->get('id','') );

        $member_info = Member::find()->where( ['id'=>$id ] )->one();

        return $this->render('info', [
                'member_info'=>$member_info,
            ]);
	}

	/**
     * 会员添加或者编辑
     * @return string
     */
	public function actionSet()
	{  
        if( $this->isRequestMethod( 'get' ) )
        {
            $id = $this->get('id','');

            $member_info = null;
            
            if( $id )
            {
               $member_info = Member::find()->where( ['id'=>$id] )->one();
            }

            return $this->render('set',[
                'member_info'=>$member_info 
                ]);
        }
        else
        {
            $mobile     = trim( $this->post('mobile','') );
            $nickname   = trim( $this->post('nickname','') );
            $id         = trim( $this->post('id','') );
            $time       = date( 'Y-m-d H:i:s' );
            if( mb_strlen( $mobile, 'utf-8' ) < 1)
            {
                return $this->renderJson( [],'填写正确的会员手机号',-1 );
            }

            if( mb_strlen( $mobile, 'utf-8' ) < 1)
            {
                return $this->renderJson( [],'填写正确的会员手机号',-1 );
            }

            if( $id )
            {
                $member_info = Member::find()->where( ['id'=>$id] )->one();
            }
            else
            {   
               $count =  Member::find()->where([ 'mobile'=>$mobile ])->count();

               if( $count > 1 )
               {
                    return $this->renderJson( [], '该用户名已经存在', -1 ); 
               }

                $member_info = new Member();
                $member_info->created_time = $time;
            }


            $member_info->mobile        = $mobile;
            $member_info->nickname      = $nickname;
            $member_info->updated_time  = $time;

            $member_info->save( 0 ); 

            return $this->renderJson([], '操作成功' ,200 );
        }
        
	}

    public function actionOps()
    {
        if( !$this->isRequestMethod( 'post' ) )
        { 
            return   $this->renderJson( [], '对不起，服务器繁忙', -1 );
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

        $user_info = Member::find()->where( [ 'id'=>$uid ] )->one();

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




	/**
     * 会员评论
     * @return string
     */
	public function actionComment()
	{
        return $this->render('comment');
	}
}


 ?>

