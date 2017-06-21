<?php 

namespace app\modules\web\controllers;

use yii\web\Controller;

use app\modules\web\controllers\common\BaseWebController;

/**
 * User controller for the `web` module
 */
class DashboardController extends BaseWebController
{

    public $layout = 'main';
	
	public function actionIndex()
	{
		return	$this->render( "index" );
	}
}


 ?>