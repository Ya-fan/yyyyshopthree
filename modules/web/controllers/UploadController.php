<?php 

namespace app\modules\web\controllers;

use app\modules\web\controllers\common\BaseWebController;

use app\models\BrandImages;

use app\models\AppAccessLog;

use app\common\services\ConstantMapService;
use app\common\services\UrlService;
use app\common\services\UploadService;



/**
 * User controller for the `web` module
 */
class UploadController extends BaseWebController
{
	private $allow_type = ['jpg','gif','jpeg',];

	/**
	 * 上传接口
	 * bucket: avatar/brand/book	
	 * @return	bool
	 */
	public function actionPic()
	{
		$bucket = trim( $this->post('bucket', '') );
				
		$callback = "window.parent.upload"; //errors/success

		if( !$_FILES || !isset( $_FILES['pic'] ))
		{
			return "<script>{$callback}.error('请选择文件')</script>";
		}	

		// 文件名
		$filename = $_FILES['pic']['name'];

		$tmp_extend = explode('.',$filename);
	
	
		if( !in_array( strtolower( end( $tmp_extend ) ) , $this->allow_type ))
		{
			return "<script>{$callback}.error('图片格式不正确')</script>";
		}

		// 上传图片逻辑


		$res = UploadService::uploadByFile( $filename, $_FILES['pic']['tmp_name'], $bucket );

			// return "<script>{$callback}.success('上传图片成功')</script>";

		if( !$res )
		{
			return "<script>{$callback}.error('".UploadService::getlastErrorMsg()."')</script>";
		}
		else
		{
			return "<script>{$callback}.success('".$res['path']."')</script>";
		}






	}  
}


 ?>