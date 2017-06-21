<?php 

namespace app\common\services;

use app\common\services\BaseService;
use app\common\services\ConstantMapService;
use app\common\services\BookService;

use app\models\PayOrder;
use app\models\PayOrderItem;
use app\models\Book;

 
// 图书库存变更服务
class PayOrderService  extends BaseService
{

	/**
	 * 下单方法
	 * 
	 * $items = [
	 * 		['target_id','target_type','price','quantity']
	 * ]
	 *
	 *$params = [
	 *		[]
	 *]
	 * 
	 * @return	bool
	 */
	public static function createPayOrder( $member_id, $items = [], $params = [] )
	{
		$total_price = 0;

		$continue_cnt = 0;

		foreach( $items as $_item )
		{
			if( $_item['price'] < 0 )
			{
				continue;
			}

			$total_price += $_item['price'];
		}

		if( $continue_cnt >= count( $items ) )
		{	
			return self::__err( '商品items为空' );
		}

		// 优惠金额
		$discount = isset( $params['discount'] ) ? $params['discount'] : 0 ;

		$total_price = sprintf( '%0.2f', $total_price );
		$discount 	 = sprintf( '%0.2f', $discount );

		// 支付金额
		$pay_price   = $total_price - $discount;
		$pay_price 	 = sprintf( '%0.2f', $pay_price );
 		
 		$time        = date( 'Y-m-d H:i:s');

 		$connection  = PayOrder::getDb(); 

 		$transation  = $connection->beginTransaction();

 		try{

 			// 并发控制
 			$tmp_book_table_name = Book::tableName();

 			$tmp_book_ids = array_column( $items, 'target_id' );

 			$tmp_sql = "SELECT `id`,`stock` FROM book where id in( ".implode(',', $tmp_book_ids)." ) FOR UPDATE ";

 			$tmp_book_list = $connection->createCommand( $tmp_sql )->queryAll();

 			$tmp_book_unit_mapping = array_column( $tmp_book_list, 'stock','id' );

 			$PayOrder = new PayOrder();

 			$PayOrder->order_sn = self::generate_goods_sn();

 			$PayOrder->member_id = $member_id;

 			$PayOrder->pay_type = isset( $params['pay_type'] ) ? $params['pay_type'] : 0 ;

 			$PayOrder->pay_source = isset( $params['pay_source'] ) ? $params['pay_source'] : 0 ;

 			$PayOrder->target_type = isset( $params['target_type'] ) ? $params['target_type'] : 0 ;

 			$PayOrder->total_price = $total_price ;
 			
 			$PayOrder->discount = $discount ;
 			
 			$PayOrder->pay_price = $pay_price ;
 
 			$PayOrder->note = isset( $params['note'] ) ? $params['note'] : '' ;
 			
 			$PayOrder->status = isset( $params['status'] ) ? $params['status'] : -8 ;
 		
 			$PayOrder->express_status = isset( $params['express_status'] ) ? $params['express_status'] : -8 ;

 			$PayOrder->express_address_id = isset( $params['express_address_id'] ) ? $params['express_address_id'] : 0 ;

 			$PayOrder->pay_time = ConstantMapService::$default_time_stamps;

 			$PayOrder->updated_time = $time;
 			$PayOrder->created_time = $time;

 			if( !$PayOrder->save( 0 ) )
 			{
 				throw new \Exception("创建订单失败");
 			}

 			foreach ($items as  $_item) 
 			{
 					
 				$tmp_left_stock = $tmp_book_unit_mapping[$_item['target_id']];

 				if( $tmp_left_stock < $_item['quantity'] )
 				{
 					throw new \Exception("购买书籍库存不够，目前库存剩余:{$tmp_left_stock}，你购买{$_item['quanticy']}");
 				}

 				$row = Book::updateAll( ['stock'=>$tmp_left_stock - $_item['quantity'] ],['id'=>$_item['target_id']] );

 				if( !$row )
 				{
					throw new \Exception("下单失败，请重新下单");
 				}

 				$PayOrderItem = new PayOrderItem();		

 				$PayOrderItem->pay_order_id = $PayOrder->id;
 				$PayOrderItem->member_id = $member_id;
 				$PayOrderItem->quantity = $_item['quantity'];
 				$PayOrderItem->price = $_item['price'];
 
 				$PayOrderItem->target_type = $_item['target_type'];
 				$PayOrderItem->target_id = $_item['target_id'];
 				$PayOrderItem->status = isset( $_item['status'] ) ? $_item['status'] : 1 ;
 				$PayOrderItem->note = isset( $_item['note'] ) ? $_item['note'] : '' ;
 				$PayOrderItem->updated_time = $time;
 				$PayOrderItem->created_time = $time;

 				if( !$PayOrderItem->save( 0 ) )
 				{
 					throw new \Exception("下订单失败");
 				}

 				BookService::setStockChangeLog( $_item['target_id'], -$_item['quantity'], '在线购买' );
 			}

 			$transation->commit();

 			return[
 				'id'=>$PayOrder->id,

 				'order_sn'=>$PayOrder->order_sn,
 				
 				'pay_money'=>$PayOrder->pay_price,
 				
 			];

 		}catch( \Exception  $e ){

 			$transation->rollback();

 			return self::_err( $e->getMessage() );
 		}


 	}	

 	public static function generate_goods_sn()
 	{
		$yCode = array('A','B','C','D','E','F','G');

        $orderNo =$yCode[intval(date('Y'))-2017].strtoupper(dechex(date('m')))
            .date('d').substr(time(),-5).substr(microtime(),2,5).
            sprintf('%02d',rand(1,99));
        return $orderNo;
 	}


	public static function getDb()
	{

	}



}



 ?>