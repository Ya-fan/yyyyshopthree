<?php 
namespace app\controllers;
use yii\web\Controller;
use app\models\Test;

use yii\data\Pagination;
use yii\db\Query;
use Recursion; // 别忘了导入这个类，或者在后面调用的时候使用"\Freedom"。

class HelloController extends controller
{	
	public $layout = 'main';
	public $enableCsrfValidation = false;

	public function actionIndex()
	{
        


		$request = \Yii::$app->request;
		// $id = $request->get('id','null');
		// if($request->isGet)
		// {
		// 	echo 'adasasdasdas';
		// }
		// else
		// {
		// 	echo 'no';
		// }
		// 	$data['hello'] = 'hello world; <script>alert(1)</script>';
		// 	// echo $request->userIp;

		// $data['data'] = array(
		// 	array('index'=>'1','indexs'=>'2','indexa'=>'3','index12'=>'4')
		// );
		// 	return $this->render('index',$data);
		// $sql = 'select * from test where id = 1';
		// $result = Test::find()->where(['like','name','三'])->asarray()->all();
		// print_r($result);die;

		if($request->isGet)
		{	
			return $this->render('index');
		}
		else
		{	
			$test = new Test;
			$test->name  =$data['username'];
			$test->age 	 =$data['age'];
			$test->email =$data['email'];

			$test->validate();
			if($test->hasErrors())
			{	
				foreach ($test->errors as $key => $val) 
				{
					echo $key.$val[0].'<br>';
				} 
			}
			else
			{
				if($test->save())
				{
					$this->redirect(['/hello/show']);
				}
				else
				{
					echo '添加失败';
				}
			}

		}
	}

	public function actionShow()
	{
		$query = new Query();
		$query->from("test");
		
		$pagination = new Pagination(['totalCount' => $query->count()]);
		$pagination->setPageSize(2);

		$data = $query->offset($pagination->offset)->limit($pagination->limit)->all();
		// $data['data'] = Test::find()->asarray()->all();
		return $this->render('about',['data'=>$data,'pagination'=>$pagination]);
	}

	public function actionDelete()
	{
		$request = \Yii::$app->request;
		$id = \Yii::$app->request->get('id');

		if($id)
		{
			var_dump(base64_decode($id)) ;
		}
		else
		{

		}
	}

	public function actionUpdata()
	{
		
	}
}










 ?>