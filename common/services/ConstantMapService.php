<?php 
namespace app\common\services;



class ConstantMapService
{	
	public static $status_default = -1;

	public static $client_type_wechat = 1;
	
	public static $status_maping =[
	
			1=>'正常',
			0=>'删除',
	] ;

	public static $status_avatar = '';

	public static $default_pwd 	 = '******';

	public static $default_error_msg 	 = '系统繁忙，请稍后再试~~';

	public static $default_time_stamps = '0000-00-00 00:00:00';

}



 ?>