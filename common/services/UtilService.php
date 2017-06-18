<?php 
namespace app\common\services;

class UtilService
{
	public static function getIP()
	{
		// 反向代理
		if( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
		{
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} 

		return $_SERVER['REMOTE_ADDR'];
	}

}

 ?>