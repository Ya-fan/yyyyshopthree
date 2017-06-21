<?php 

namespace app\common\services;

class StaticService
{
	// 引入js文件
	public static function includeAppJsStatic( $path, $depend )
	{
			self::includeAppStatic( 'js', $path, $depend );
	} 

	//引入Css文件
	public static function includeAppCssStatic( $path, $depend)
	{
			self::includeAppStatic( "css", $path, $depend );		
	}

	// 引入自定义文件
	public static function includeAppStatic( $type, $path, $depend )
	{
        $RELEASE_VERSION = defined('RELEASE_VERSION') ? RELEASE_VERSION : '20170401';
        $path = $path.'?ver='.$RELEASE_VERSION;
			switch ($type) {
				case 'js':
					\Yii::$app->getView()->registerJsFile( $path, [ 'depends'=>$depend ] );
					break;

				case 'css':
					\Yii::$app->getView()->registerCssFile( $path, [ 'depends'=>$depend ] );
					break;
				default:
				
					break;
			}
	}



}


 ?>