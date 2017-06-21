<?php 

namespace app\common\services;

use app\common\services\BaseService;
use app\models\BookStockChangeLog;
use app\models\Book;
 
// 图书库存变更服务
class BookService  extends BaseService
{

	public static  function setStockChangeLog( $book_id = 0, $unit = 0, $note='' )
	{
		if( !$book_id || !$unit )
		{
			return false;
		}

		$book_info = Book::find()->where( [ 'id' =>$book_id ] )->one();	

		if( !$book_info )
		{
			return false;
		}

		$BookStockChangeLog = new BookStockChangeLog();

		$BookStockChangeLog->book_id 		= $book_id;
		$BookStockChangeLog->unit 			= $unit;
		$BookStockChangeLog->total_stock 	= $book_info['stock'];
		$BookStockChangeLog->note 			= $note;
		$BookStockChangeLog->created_time 	= date('Y-m-d H:i:s');

		return	$BookStockChangeLog->save( 0 );
	}
}


 ?>