<?php 

namespace app\modules\web\controllers;

use Yii;
use yii\web\Controller;
use app\models\Article;
class ArticleController extends Controller
{

	public $enableCsrfValidation  = false;
	public $layout=false;
	public  function actionAdd()
	{
		return $this->render('add');
	}

}





 ?>