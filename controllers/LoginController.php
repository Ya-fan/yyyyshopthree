<?php 
namespace app\controllers;
use yii\web\Controller;
use app\models\Test;

use yii\data\Pagination;
use yii\db\Query;
class LoginController extends controller
{	

		public function actionIndex()
	{
		return $this->renderPartial('login');
	}	
}






 ?>