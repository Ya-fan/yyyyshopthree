<?php 
namespace app\controllers;
use yii\web\Controller;
use app\models\Trip;

require_once(dirname(__FILE__)."/../querylist/vendor/autoload.php"); 

use QL\QueryList;

class ExamtwoController extends controller
{

	public function actionIndex()
	{
		header('content-type:text/html;charset=utf8');

	
$html = <<<STR
<div id="str">
<div id="one">
    <div class="two">
        <a href="http://querylist.cc">QueryList官网</a>
        <img src="http://querylist.com/1.jpg" alt="这是图片">
        <img src="http://querylist.com/2.jpg" alt="这是图片2">
    </div>
    <span>其它的<b>一些</b>文本</span>
</div>  
</div>   
<div id="two">
    <div class="two">
        <a href="http://querylist.cc">QueryList官网</a>
        <img src="http://querylist.com/1.jpg" alt="这是图片">
        <img src="http://querylist.com/2.jpg" alt="这是图片2">
    </div>
    <span>其它的<b>一些</b>文本</span>
</div>
STR;

$rules = array(
    //采集id为one这个元素里面的纯文本内容
    'text' => array('#one','text'),
    //采集class为two下面的超链接的链接
    'link' => array('.two>a','href'),
    //采集class为two下面的第二张图片的链接
    'img' => array('.two>img:eq(1)','src'),
    //采集span标签中的HTML内容
    'other' => array('span','html')
);

    $data = QueryList::Query($html,$rules,'#str')->data;
    echo '<pre>';
		var_dump($data);die;

		$data = Trip::find()->orderBy('id')->asArray()->all();

		return	$this->render('index',['data'=>$data]);
	}

	public function actionDelete()
	{
		$request = \Yii::$app->request;

		$id = $request->get('id');

		$del=Trip::deleteAll(['id'=>$id]);
 
		return	$this->redirect(['examtwo/index']);
	}


	public function actionUpdata()
	{
		$request = \Yii::$app->request;
		$model = new Trip();
		if($request->isGet)
		{	
			$id = $request->get('id');

		
			$data = Trip::find()->where(['id'=>$id])->asArray()->one();

			return	$this->render('updata',['data'=>$data,'model'=>$model]);

		}
		else
		{
			$post = $request->post();

			$row = Trip::updateAll(['title'=>$post['title'],'desc'=>$post['desc'],'img'=>$post['img'],'is_stick'=>$post['is_stick']],['id'=>$post['id']]);
			
			return	$this->redirect(['examtwo/index']);
		}
	}

	public function actionAdd()
	{
		$request = \Yii::$app->request;
        $model = new Trip();


		if($request->isGet)
		{
			return	$this->render('add',['model'=>$model]);
		}
		else
		{
			$data = $request->post();

			if($model->load($data) && $model->save())
			{
				return	$this->redirect(['examtwo/index']);
			}
			else
			{
				return	$this->redirect(['examtwo/add']);
			}
		}
	}
}