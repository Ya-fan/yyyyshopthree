<?php 
namespace app\modules\m\controllers\common;

use app\common\components\BaseController;

use \app\common\services\UrlService;

class BaseMController  extends BaseController
{
	/**
	 * 	继承 父类构造 并统一加载 布局文件
	 */
	public function __construct( $id, $module, array $config=[] )
	{
		parent::__construct( $id, $module, $config );
		
		// 统一继承模板布局
		$this->layout = 'main';
	}


	/**
	 * 登录统一验证	(每次动作先执行本方法)
	 */
	public function beforeAction( $action  )
	{
		return true;
	}


}



 ?>