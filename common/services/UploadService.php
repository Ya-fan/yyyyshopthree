<?php 

namespace app\common\services;

use app\common\services\BaseService;
use app\models\Images;  


// 上传图片服务
class UploadService  extends BaseService
{

	// 根据文件路径上传 
	public static function uploadByFile( $filename, $filepath, $bucket = ''  )
	{
		if( !$filename )
		{
			return self::_err( '文件名字是必须的' );
		}

		if( !$filepath || !file_exists( $filepath ) )
		{
			return self::_err( '正确的文件参数' );
		}

		$upload_config = \Yii::$app->params['upload'];

		if( !isset( $upload_config[ $bucket ] ) )
		{
			return self::_err( '请写入正确的篮子' );
		}

		// 后缀
		$tmp_extend = explode('.',$filename);
		$extend = strtolower( end( $tmp_extend ) ) ;

		$hash_key = md5( file_get_contents( $filepath ) );

		$upload_dir_path = UtilService::getRootPath().'/web'.$upload_config[ $bucket ].'/';

		$folder_name = date('Ymd');
		
		$upload_path = $upload_dir_path.$folder_name;

		if( !file_exists( $upload_path ) )
		{
			$bool = mkdir( $upload_path ,0777,true);

			chmod( $upload_path, 0777);
		}

		$upload_fule_name = $folder_name.'/'.$hash_key.".{$extend}";

		if( is_uploaded_file( $filepath ) )
		{
			move_uploaded_file($filepath,$upload_dir_path.$upload_fule_name );
		}
		else
		{
			file_put_contents($upload_dir_path.$upload_fule_name, file_get_contents( $filepath ));
		}

		$images = new Images();
		$images->bucket 	= $bucket;
		$images->file_key 	= $upload_fule_name;
		$images->created_time = date('Y-m-d H:i:s');
		$images->save( 0 );

		return [
				'code'=>200,
				'path'=>$upload_fule_name,
				'rootname'=>$upload_config[$bucket],
		];
	}

	public static function getlastErrorMsg( )
	{
		return self::$_error_msg ;
	}

	public static function getlastErrorCode( )
	{
		return self::$_error_code ;
	}

}















 ?>