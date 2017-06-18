<?php
namespace app\common\services;

use yii\helpers\Url;

// 构造链接类
class UrlService
{
	// 构建web端所有连接
	public static function buildWebUrl( $path, $params=[] )
	{
		$domain_config = \yii::$app->params['domain'];

		$path = Url::toRoute( array_merge( [$path], $params ) );
		
		return $domain_config['web'].$path;
	}

	// 构建M端所有链接
	public static function buildMUrl( $path, $params=[] )
	{
		$domain_config = \yii::$app->params['domain'];

		$path = Url::toRoute( array_merge( [$path], $params ) );
		
		return $domain_config['m'].$path;
	}

	// 构建官网的链接
	public static function buildWwwUrl( $path, $params=[] )
	{
		$domain_config = \yii::$app->params['domain'];
		
		$path = Url::toRoute( array_merge( [$path], $params ) );

		return $domain_config['www'].$path;
	}

	// 空连接
	public static function buildNullUrl()
	{
		return "javascript:void(0)";
	}
}
