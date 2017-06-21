<?php 
namespace app\modules\m\controllers;

use app\common\services\ConstantMapService;
use app\models\Member;
use app\models\MemberFav;
use app\modules\m\controllers\common\BaseMController;

use app\models\Book;
use app\models\MemberCart;
use app\common\services\UtilService;
use app\common\services\UrlService;
use app\common\services\PayOrderService;
/**
 * Default controller for the `m` module
 */
class ProductController extends BaseMController
{
	public $layout = 'main';
	/**
	 * 商品列表
	 *	
	 * @return	
	 */
	public function actionIndex()
	{
		// 关键字搜索
		$kw = trim( $this->get( 'kw', '') );

		// 搜索字段
		$sort_field = trim( $this->get('sort_field','default') );

		$sort = trim( $this->get('sort','') );
		$sort = in_array( $sort, ['desc','asc'] ) ? $sort : 'desc'  ;

		$book_info = $this->getSerachData();

		$search_conditions = [
			'kw' => $kw,
			'sort_field' => $sort_field,
			'sort' => $sort
		];

		$data = [];
		if( $book_info ){
			foreach( $book_info as $_item ){
				$data[] = [
					'id' => $_item['id'],
					'name' => UtilService::encode( $_item['name'] ),
					'price' => UtilService::encode( $_item['price'] ),
					'main_image' => UrlService::buildImgUrl("book",$_item['main_image'] ),
					'month_count' => $_item['month_count']
				];
			}
		}
		
		if( $this->isRequestMethod( 'ajax' ) )
		{
			return $this->renderJson( ['data'=> $data, 'has_next' => ( count( $data ) >= 1 ) ? 1: 0 ] , '返回数据'  );
		}
		else
		{
				return	$this->render( 'index' ,[
				'book_info'=>$data,
				'search_conditions'=>$search_conditions,
			]);
		}
	}

	/**
	 * 图书 查询	
	 * @return	bool
	 */
	public function getSerachData( $page_size = 4 )
	{
		// 关键字搜索
		$kw = trim( $this->get( 'kw', '') );

		// 搜索字段
		$sort_field = trim( $this->get('sort_field','default') );

		$sort = trim( $this->get('sort','') );
		$sort = in_array( $sort, ['desc','asc'] ) ? $sort : 'desc' ;
		$p = $this->get( 'p', 1 );
		if( $p < 1 )
		{
			$p = 1;
		}

		$query = Book::find()->where( ['status'=> 1] );

		if( $kw )
		{
		   $where_name = [ 'LIKE','name','%'.strtr( $kw ,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
    	   $where_tag  = [ 'LIKE','tags','%'.strtr( $kw ,['%'=>'\%', '_'=>'\_', '\\'=>'\\\\']).'%', false ];
           
           $query->andWhere([ 'OR',$where_name,$where_tag ]);
		}

		switch ($sort_field) {
			case 'view_count':
			case 'month_count':
			case 'price':
			 $query->orderBy( [ $sort_field=>( $sort == 'desc' ) ? SORT_DESC: SORT_ASC, 'id'=>SORT_DESC ] );
				break;
			default:
			 $query->orderBy( [ 'id'=>SORT_DESC  ] );
				break;
		}

		// 偏移量
		$limit = ($p - 1 )*$page_size;

		$book_info = $query->offset( $limit )->limit( $page_size )->all();

		return $book_info;
	}	


	/**
	 *商品详情
	 * 
	 * @return	
	 */
	public function actionInfo()
	{
			
		if( $this->isRequestMethod( 'get' ) )
		{
			$id = intval( $this->get( 'id','' ) );
			
			if( !$id )
			{			
				return false;
			}
	
			$book_info = Book::find()->where( [ 'id'=>$id ,'status'=>1 ] )->one();

			if( !$book_info )
            {
                return $this->redirect( UrlService::buildMUrl('/product/index') );
            }

            $has_faved = false;
            if(  $this->current_user )
            {
                $has_faved = MemberFav::find()->where([ 'member_id' => $this->current_user['id'],'book_id' => $id ])->count();
            }

			$data = [];
			if( $book_info )
			{
					$data = [
						'id' => $book_info['id'],
						'name' => UtilService::encode( $book_info['name'] ),
						'price' => UtilService::encode( $book_info['price'] ),
						'main_image' => UrlService::buildImgUrl("book",$book_info['main_image'] ),
						'month_count' => $book_info['month_count'],
						'comment_count' => $book_info['comment_count'],
						'stock' => $book_info['stock'],
						'summary' => $book_info['summary'],
					];
				
			}

			
		return	$this->render( 'info' ,[ 'data'=>$data, 'has_faved' => $has_faved ]);
		}


	}

	// 加入收藏
	public  function actionFavs()
	{
	  if( $this->isRequestMethod( 'post' ) )	
	  {	
	  		$user_info = $this->getCookie( $this->auth_cookie_name );

	  		if( !$user_info )
	  		{
	  			return $this->renderJson( [],'未登录，系统将引导您重新登陆', -302 );
	  		}

		  	$id = intval( $this->post( 'id',0 ) );

		    $act = trim( $this->post('act'), '' );

		    if( !in_array( $act,['del','set'] ) )
	        {
	            return $this->renderJson( [], ConstantMapService::$default_error_msg, -1 );
	        }

	        if( $act == "del" )
	        {
				if( !$id ){
					return $this->renderJson( [],ConstantMapService::$default_syserror,-1 );
				}

				$fav_info = MemberFav::find()->where([ 'member_id' => $this->current_user['id'],'id' => $id ])->one();
				if( $fav_info )
				{
					$fav_info->delete();
				}

				return $this->renderJSON( [],"操作成功~~" );
			}

	        if( !$id )
	        {
	            return $this->renderJson([], ConstantMapService::$default_error_msg, -1 );
	        }

	        $has_faved = MemberFav::find()->where( [ 'member_id'=>$this->current_user['id'], 'book_id'=>$id ] )->count();

		    if( $has_faved )
	        {
	            return $this->renderJson([],'该商品收藏',-1);
	        }

	        $model_fav = new MemberFav();

	        $model_fav->member_id = $this->current_user['id'];
	        $model_fav->book_id = $id;
	        $model_fav->created_time = date( 'Y-m-d H:i:s' );

	        $model_fav->save( 0 );

	        return $this->renderJson([],'成功收藏商品');
	  }
	}

	/**
	 * 加入购物车
	 * @return	json
	 */
	public function actionCart()
	{
		if( $this->isRequestMethod( 'post' ) )
		{
			// 购物数量
			$quantity = intval( $this->post( 'quantity', 0 ) );
			
			// 图书
			$book_id = intval( $this->post( 'book_id',0 ) );

			//动作
			$act = trim( $this->post( 'act','' ) );

			$time = date('Y-m-d H:i:s');

			if( $quantity <= 0 )
			{
				return $this->renderJson( [], '请填写正确的商品数量', -1 );
			}	

			if( !in_array( $act, ['del','set'] )  )
			{
				return $this->renderJson( [], ConstantMapService::$default_error_msg, -1 );
			}

			if( $act == 'del' )
			{

			} 

			$book_info = Book::findOne( ['id'=>$book_id] );

			if( !$book_info )
			{
				return $this->renderJson( [], ConstantMapService::$default_error_msg, -1 );
			}

			$cart_info = MemberCart::find()->where( ['book_id'=>$book_id,'member_id'=> $this->current_user['id'] ] )->one();

			if( !$cart_info )
			{
				$cart_info = new MemberCart();

				$cart_info->member_id = $this->current_user['id'];
				$cart_info->book_id = $book_id;

				$cart_info->created_time = $time;
			}
			else
			{
				$cart_info->updated_time = $time;
			}

				$cart_info->quantity += $quantity;
				$cart_info->updated_time = $time;

				$cart_info->save( 0 );

				return $this->renderJson( [], '成功添加购物车',200 );
		}

	}	

	/**
	 * 图书操作
	 * @return	bool
	 */
	public function actionOps()
	{
		if( $this->isRequestMethod( 'post' ) )
		{
			$book_id = intval( $this->post( 'book_id' ) );
			$act 	 = trim( $this->post( 'act' ) ); 	

			if( !$book_id )
			{
				return $this->renderJson( [], ConstantMapService::$default_error_msg, -1 );
			}

			if( !in_array( $act, ['del','setViewCount'] ) )
			{
				return $this->renderJson( [], ConstantMapService::$default_error_msg, -1 );
			}

			$book_info = Book::find()->where([ 'id'=>$book_id, 'status'=>1 ] )->one();

			if( !$book_info )
			{
				return $this->renderJson( [], ConstantMapService::$default_error_msg, -1 );
			}		

			$book_info->view_count += 1;	

			$book_info->update( 0 );
			
			return $this->renderJson([]);
		}
	}


	/**
	 * 下订单
	 * @return	json
	 */
	public function actionOrder()
	{

		if( $this->isRequestMethod( 'get' ) )
		{
			$book_id = intval( $this->get('id', '') );
			$num = intval( $this->get('num', '') );

			if( !$book_id )
			{
				return $this->rendirect( UrlService::buildMUrl('/products/index') );
			}

			$book_info = Book::find()->where( ['id'=>$book_id, 'status'=> 1] )->one();

			if( empty($book_info) )
			{
				return $this->rendirect( UrlService::buildMUrl('/products/index') );
			}

			$product_list = [];
			$total_pay_money = 0;

			$product_list[] = [
				'id' => $book_info['id'],
				'name' => UtilService::encode( $book_info['name'] ),
				'image' => UrlService::buildImgUrl( 'book', $book_info['main_image'] ),
				'num' => $num,
				'price' => UtilService::encode( $book_info['price'] ),
			];

			// 总价格
			$total_pay_money += $book_info['price'] * $num;

			return	$this->render( 'order',
				[
					'total_pay_money'=>sprintf('%.2f', $total_pay_money),
					'product_list'=>$product_list,
				]
			 );
		}
		else
		{
			$data = $this->post( 'product_item', [] ) ;

			$address_id = intval( $this->post( 'address_id', 0 ) );

			// if( !$address_id )
			// {
			// 	return $this->renderJson([], '请输入收货地址', -1);
			// }
			
			if( !$data )
			{
				return $this->renderJson( [], '请先选择商品再提交', -1 );
			}

			$book_ids = [];
		
			foreach( $data as $val )
			{
				$tmp_item_info = explode('#', $val);
			
				$book_ids[] = $tmp_item_info[0];
			}

			$book_info = Book::find()->where( [ 'id'=>$book_ids, 'status'=>1 ] )->indexBy( 'id' )->asArray()->all(); 
			
			if( !$book_info )
			{
				return $this->renderJson( [], '请先选择商品再提交', -1 );
			}

			// 下订单服务
			// echo '<pre>';
			// print_r( $book_info );die;

			$item = [];

			$target_type = 1;

			foreach ($data as $_item) 
			{
				$tmp_item_info = explode( '#', $_item );

				$tmp_book_info = $book_info[$tmp_item_info[0]]; 

				$item[] = [
					'price'=> $tmp_book_info['price'] * $tmp_item_info[1], 
					
					'quantity'=>$tmp_item_info[1],
					
					'target_type'=>$target_type,
					
					'target_id'=> $tmp_item_info[0],
				];
			}

			$params = [
				'pay_type'=>  1,
				
				'pat_source'=> 2,
				
				'target_type'=> $target_type,

				'note'=>'购买书籍',

				'status'=> -8,

				'express_address_id'=>$address_id,
			];

			$ret = PayOrderService::createPayOrder( $this->current_user['id'], $item, $params );

			if( !$ret)
			{
				return $this->renderJson([], ' 提交失败，失败原因:'.PayOrderService::getLastErrorMsg() , -1  );
			}

			return $this->renderJson( [ 'url'=> UrlService::buildMUrl( '/pay/buy', ['pay_order_id'=> $ret['id'] ] ) ], '下单成功，请支付', 200 );
		}	
	}






}

 ?>