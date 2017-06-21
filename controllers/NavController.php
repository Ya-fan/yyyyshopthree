<?php 
namespace app\controllers;

use Yii;
use yii\web\Controller;
use  app\models\Nav;
class NavController extends Controller
{
 	public	$enableCsrfValidation = false;
	
	public function actionAdd()
	{	

		$request = Yii::$app->request;
		if ($request->isPost) 
		{ 
			$add_Data = $request->post();

	$tag = [];
			foreach ($add_Data['nav_name'] as $key => $val) 
			{
					$tag[$key]['nav_name'] =$val ;
					$tag[$key]['nav_url'] =$add_Data['nav_url'][$key];		
					$tag[$key]['is_new'] =$add_Data['is_new'][$key];		
			}
// echo'<pre>';
// print_r(serialize($tag));die;
			$nav = new Nav;
			$nav->nav_name 	= serialize($tag);

			$nav->position 	= $add_Data['position'];
			$nav->font_bold = empty($add_Data['font_bold']) ?0 : $add_Data['font_bold'];
			$nav->font_size = $add_Data['font_size'];
			$nav->font_color= $add_Data['font_color'];
			$nav->nav_color = $add_Data['nav_color'];
		
			$row = $nav->save();
			$this->redirect(['show']);
		}
		else
		{
			return $this->render('add');
		}
		
	}

	public function actionShow()
	{
		$data = Nav::find()->asArray()->all();

		
		return $this->render('show',['data'=>$data]);
	
	}









}
 ?>