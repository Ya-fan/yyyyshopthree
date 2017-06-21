<?php 

namespace app\controllers;

use Yii;
use app\models\News;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use app\models\Cate;

use yii\filters\VerbFilter;

use app\models\Img;
use yii\db\Query;
use app\models\UploadForm;
use yii\web\UploadedFile;

use yii\data\Pagination;
require_once(dirname(__FILE__)."/../querylist/vendor/autoload.php"); 

use QL\QueryList;

/**
 * MesController implements the CRUD actions for Message model.
 */
class NewsController extends Controller
{

	// 添加
	public function actionAdd()
	{
		$uploadModel  = new UploadForm;

		$request = Yii::$app->request;
		if ($request->isGet)
		{
			$cate = new Cate;
			$cate_data = $cate::find()->asArray()->all();
			
			return $this->render('add',['cate_data'=>$cate_data,'uploadModel'=>$uploadModel]);
		}
		else
		{
			$data = Yii::$app->request->post();
		
			$img  = new Img;
			$newModel = new News;
			 $uploadModel->img = UploadedFile::getInstance($uploadModel, 'img');
            if ($filename = $uploadModel->upload()) 
            {

              	$img->i_img = $filename;

              	if($row = $img->save())
              	{
             		$id = $img->attributes['i_id'];
              	}
              	else
              	{	
              		echo '上传失败';
              	}
            }

      		$newModel->n_title = $data['title'];
      		$newModel->c_id = $data['c_id'];
      		$newModel->n_desc = $data['n_desc'];
      		$newModel->n_img = $id;

      		if($newModel->save())
      		{
				return  $this->redirect(['news/show']);	
      		}
      		else
      		{
 				echo'添加失败';
      		}
		}
	}

	// 展示
	public function actionShow()
	{
		// $newModel = new News;

		// 创建一个 DB 查询来获得所有 status 为 1 的文章
		$query = News::find();

		// 得到文章的总数（但是还没有从数据库取数据）
		$count = $query->count();

		// 使用总数来创建一个分页对象
		$pagination = new Pagination(['totalCount' => $count]);

		$pagination->setPageSize(5);

		$data = Yii::$app->db->createCommand('SELECT * from `news` inner join cate on `news`.c_id =`cate`.c_id  inner join img on `news`.n_img =`img`.i_id limit '.$pagination->offset.','.$pagination->limit.'')
             ->queryAll();

       return $this->render('show',['data'=>$data,'pagination'=>$pagination]);
	}

	// 修改
	public function actionUpd()
	{
		$request = Yii::$app->request;
		$uploadModel  = new UploadForm;

		if ($request->isGet)
		{
			$new_id = $request->get('id');

			//分类数据
			$cate = new Cate;
			$cate_data = $cate::find()->asArray()->all();

			// 单条新闻数据
			$query = News::find()->where(['n_id'=>$new_id]);
			$new_data = $query->asArray()->One();

			// 新闻下图片数据
			$img  = new Img;
			$img_data = $img->find()->where(['i_id'=>$new_data['n_img']])->asArray()->One();

			$new_data['img'] = $img_data['i_img'];

			return $this->render('update',['cate_data'=>$cate_data,'uploadModel'=>$uploadModel,'new_data'=>$new_data]);
		}
		else
		{
			$data = Yii::$app->request->post();
			$new_id = $request->get('id');

			$img = Img::findOne($data['img_hidden']);

			$newModel = News::findOne($new_id);
			
			 $uploadModel->img = UploadedFile::getInstance($uploadModel, 'img');
    
            if ($filename = $uploadModel->upload()) 
            {

              	$img->i_img = $filename;

              	if($row = $img->save())
              	{
             		$id = $img->attributes['i_id'];
              	}
              	else
              	{	
              		echo '上传失败';
              	}
            }

      		$newModel->n_title = $data['title'];
      		$newModel->c_id = $data['c_id'];
      		$newModel->n_desc = $data['n_desc'];

      		$newModel->n_img = $id;

      		if($newModel->save())
      		{
				return  $this->redirect(['news/show']);	
      		}
      		else
      		{
 				echo'添加失败';
      		}
		}
	}

	// 删除
	public function actionDel()
	{
		$id = Yii::$app->request->get('id');
		$img_id = Yii::$app->db->createCommand('SELECT n_img from `news` where n_id = '.$id.'')->queryOne();

		$row = Yii::$app->db->createCommand()->delete('news', 'n_id='.$id)->execute();
		$i_id = $img_id['n_img'];
		$row = Yii::$app->db->createCommand()->delete('img', 'i_id='.$i_id)->execute();

		return $this->redirect(['news/show']);
	}


	// 采集
	public function actionCollect()
	{
		header('content-type:text/html;charset=utf8');

		// $url = 'http://roll.news.sina.com.cn/news/shxw/qwys/index.shtml';

		// $html = file_get_contents($url);
		// $bool = file_put_contents('./collect/test.html', $html);	
		// $html = file_get_contents('http://n.sinaimg.cn/translate/20170204/iETh-fyafcyw0139760.jpg');
		// $size = filesize('http://n.sinaimg.cn/translate/20170204/iETh-fyafcyw0139760.jpg');
		
		$html = file_get_contents('./collect/test.html');

	set_time_limit(0);
 // $html="http://roll.news.sina.com.cn/news/shxw/qwys/index.shtml";
           $rules = array(
               'text' => array('.list_009>li>a','text'),
               'link' => array('.list_009>li>a','href'),
           );
           $data = QueryList::Query($html,$rules,'','UTF-8','GB2312')->data;

   //         $rules =['img' => array('.img_wrapper>img','src'),];
   //         $i = 1;

   //        foreach ($data as $key => &$val) 
   //        {	
   //        	 if($i == 6){die;}
          	
   //        	 $url = $val['link'];
   //      	 $img = QueryList::Query($url,$rules,'#artibody','UTF-8','GB2312')->getData(function($item){
   //         		return $item['img'];
			// 	});
			//  $img[0] = empty($img[0]) ? '1233' :$img[0]; 
			// $imarray[] = $img[0];
			// print_r($imarray);
   //       	$i++;
   //       	// $html = file_get_contents($url);
   //        	// 	$reg = '#<div class="article .*" id="artibody">.*<p>.*</p>.*<p>(.*)</p>.*</div>#isU';
   //        	// 	preg_match_all($reg, $html, $desc);
   //        	// 	$val['desc'] = $desc[1][0];
   //        }
//           echo'<pre>';						
           // echo'<pre>';						 
           // print_r($data);die;
           foreach ($data as $k => $val) 
           {
           		$link[] = $val['link'];
           }
           $text = $this->duocai($link);

      		$img_reg = '#<div class="img_wrapper"><img.*src="(.*)" .*><span class="img_descr">.*</span></div>#isU';

           foreach ($text as $key => $val) 
           {
           	 preg_match_all($img_reg,$val,$res['img'][$key]);
           	 echo '<pre>';
           	 print_r($res['img'][$key]);
           	 // $res['img'][$key][0] ?  
           die;
           }


// // 多线程
      
//            QueryList::run('Multi',[
//     //待采集链接集合
//     'list' => $link,
//     'curl' => [
//         'opt' => array(
//                     //这里根据自身需求设置curl参数
//                     CURLOPT_SSL_VERIFYPEER => false,
//                     CURLOPT_SSL_VERIFYHOST => false,
//                     CURLOPT_FOLLOWLOCATION => true,
//                     CURLOPT_AUTOREFERER => true,
//                     //........
//                 ),
//         //设置线程数
//         'maxThread' => 100,
//         //设置最大尝试数
//         'maxTry' => 3 
//     ],
//     'success' => function($a){
//         //采集规则
//         $reg = array(
//             // 'img' => array('#artibody .img_wrapper>img:eq(0)','src'),
//             'desc'=>['#artibody>p:eq(3)','text'],
//             );
   
//         $ql = QueryList::Query($a['content'],$reg);
//         $data = $ql->getData();
//         //打印结果，实际操作中这里应该做入数据库操作
//         print_r($data);
 
 
//     }
// ]);
die;
// die;
          foreach ($img as $key => &$val)
          {

	          	if(!empty($val))
	          	{

	          		$file = file_get_contents($val[0]);
					if(ceil(strlen($file) / 1000) <350)
					{
						$info = pathinfo($val[0]);
						$suffix =$info['extension'];
						$newname = time().rand(100,9999).'.'.$suffix;
						file_put_contents('./collect/'.$newname,$file);
						$val[0] = $newname;
					}
					else
					{
						$val[0] = './collect/timg.jpg';
					}
	          	}
	          	else
	          	{
	          		$val[0] = './collect/timg.jpg';
	          	}
          }
          echo '<pre>';
          print_r($img);die;

	}

	//多线程
	public function duocai($urls)
	{
		 if (!is_array($urls) or count($urls) == 0) {  
		        return false;  
		    }   
		    $num=count($urls);  
		    $curl = $curl2 = $text = array();  
		    $handle = curl_multi_init();  
		    function createCh($url) {  
		        $ch = curl_init();  
		        curl_setopt ($ch, CURLOPT_URL, $url);  
		        curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Trident/7.0; rv:11.0) like Gecko');//设置头部  
		        curl_setopt ($ch, CURLOPT_REFERER, $url); //设置来源  
		        curl_setopt ($ch, CURLOPT_ENCODING, "gzip"); // 编码压缩  
		        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);  
		        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);//是否采集301、302之后的页面  
		        curl_setopt ($ch, CURLOPT_MAXREDIRS, 5);//查找次数，防止查找太深  
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查  
		        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在         
		        curl_setopt ($ch, CURLOPT_TIMEOUT, 20);  
		        curl_setopt ($ch, CURLOPT_HEADER, 0);//输出头部  
		        return $ch;  
		    }  
		    foreach($urls as $k=>$v){  
		        $url=$urls[$k];  
		        $curl[$k] = createCh($url);  
		        curl_multi_add_handle ($handle,$curl[$k]);  
		    }  
		    $active = null;  
		    do {  
		        $mrc = curl_multi_exec($handle, $active);  
		    } while ($mrc == CURLM_CALL_MULTI_PERFORM);  
		  
		    while ($active && $mrc == CURLM_OK) {  
		        if (curl_multi_select($handle) != -1) {  
		            usleep(100);  
		        }  
		        do {  
		            $mrc = curl_multi_exec($handle, $active);  
		        } while ($mrc == CURLM_CALL_MULTI_PERFORM);  
		    }   

		    foreach ($curl as $k => $v) {  
		        if (curl_error($curl[$k]) == "") {  
		            $text[$k] = (string) curl_multi_getcontent($curl[$k]);   
		        }  
		        curl_multi_remove_handle($handle, $curl[$k]);  
		        curl_close($curl[$k]);  
		    }   
		    curl_multi_close($handle);  
		    return $text;  
	}



function getCurl($url)
{	 

	// 初始化 curl 对象
	$curl = curl_init();

	// 设置要抓取 页面的 路径
	curl_setopt($curl,CURLOPT_URL,$url);

	//设置heeader
	curl_setopt($curl,CURLOPT_HEADER,0); 

	// 设置curl参数，要求结果（1保存到字符串中，0输出到屏幕上）
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);

	//运行curl请求页面 
	$html = curl_exec($curl);

	// 关闭curl请求
	curl_close($curl);

	return $html;
}			

	// // 最新新闻
	// public function actionCollect()
	// {
	// 	set_time_limit(0);
	// 	// $html = file_get_contents('http://roll.news.sina.com.cn/news/shxw/qwys/index.shtml');
	// 	//  file_put_contents('./collect/test.html',$html);	

	// 	$html =  file_get_contents('./collect/test.html');
	// 	 // 链接
	// 	 $reg = '#<li><a href="(.*)" target="_blank">.*</a><span>.*</span></li>#isU';
	// 	preg_match_all($reg,$html,$href);
		
	// 	$i = 1;
	// 	foreach ($href[1] as $key => $val) 
	// 	{	
	// 		if($i == 10)
	// 		{
	// 			exit;
	// 		}
			
	// 		// $info = get_headers('http://n.sinaimg.cn/translate/20170502/NdPW-fyeuirh0365983.jpg',true);
			
	// 		$file = file_get_contents('http://n.sinaimg.cn/translate/20170502/NdPW-fyeuirh0365983.jpg');
	// 		$size = ceil(strlen($file) / 1024);
	// 		echo'<pre>';
	// 		print_r($size);die;

	// 		$r = $val;
			
	// 		$html = file_get_contents($r);
			
	// 		// // 标题
	// 		$reg = '#<h1 id="artibodyTitle" cid=".*" docid=".*">(.*)</h1>#isU';

	// 		preg_match_all($reg,$html,$title);
			

	// 		// // 内容
	// 		$reg = '#<div class="article article_16" id="artibody">.*<p>.*</p>.*<p>(.*)</p>.*<p>.*</p>.*<p>.*</p>.*</div>#isU';
	// 		preg_match_all($reg,$html,$desc);

	// 		// 图片
	// 		$reg = '#<div class="img_wrapper"><img.*src="(.*)" .*><span class="img_descr">.*</span></div>#isU';

	// 		preg_match_all($reg,$html,$img);
			
		
	// 			$title =    $title[0] ? $title[1][0] : '';
	// 			$img   = 	$img[0]   ? $img[1][0]   : '';
	// 			$desc  =    $desc[0]  ? $desc[1][0]  : '';
	// 		// 图片处理
	// 		if(!empty($img))
	// 		{	
	// 			$file = file_get_contents($img);
	// 			if((ceil(strlen($file)) / 1000) <350)
	// 			{
	// 				$info = pathinfo($img);
	// 				$suffix = $info['extension'];
	// 				$filename ='./collect/caiji2/'.time().rand(100,9999).'.'.$suffix;
	// 				file_put_contents($filename,$file);
	// 			} 
	// 			else
	// 			{
	// 				$filename = './collect/timg.jpg';
	// 			}
	// 		}
	// 		else
	// 		{
	// 			$filename = './collect/wu.jpg';
	// 		}

	// 		Yii::$app->db->createCommand('INSERT INTO img (i_id,i_img) values(null,"'.$filename.'")')->execute();
	// 		$img_id = Yii::$app->db->getLastInsertID();
			
	// 		Yii::$app->db->createCommand('INSERT INTO news (n_id,n_title,n_desc,c_id,n_img) values(null,"'.$title.'","'.$desc.'",3,"'.$img_id.'")')->execute();
	// 		$n_id = Yii::$app->db->getLastInsertID();

	// 		$i++;
	// 	}
	// 	echo "<script>alert('入库成功！！！');location.href='index.php?r=news/show'</script>";
	// }

	

























	// 采集
// 		public function actionCollect()
// 		{
// 		header('content-type:text/html;charset=utf8');
	
// 		set_time_limit(0);
// // ./collect/test.html
// 			$html = file_get_contents('./collect/new.html');
// 			// file_put_contents('./collect/new.html',$html);
// 			// die;
	
// 			// $html = $this->getCurl('http://roll.news.sina.com.cn/news/shxw/qwys/index.shtml');
			
// 			// 采集链接
// 			$reg = '#<li><a href="(.*)" target="_blank">.*</a><span>.*</span></li>#isU';
			
// 			preg_match_all($reg,$html,$href);

// 			foreach ($href[1] as $key => $val) 
// 			{
// 				$r = $val;

// 				$html = file_get_contents($r);
// 				// $html = $this->getCurl($r);
// 				// 标题
// 				$reg = '#<h1 id="artibodyTitle" cid=".*" docid=".*">(.*)</h1>#isU';
// 				preg_match_all($reg,$html,$title);
				
// 				//图片	
// 				$reg = '#<div class="img_wrapper"><img.*src="(.*)" .*><span class="img_descr">.*</span></div>#isU';
// 				preg_match_all($reg,$html,$img);
				
// 				//内容
// 				$reg = '#<div class="article .*" id="artibody">.*<p>.*</p>.*<p>(.*)</p>.*</div>#isU';
// 				preg_match_all($reg,$html,$desc);
				
// 				$title =    $title[0] ? $title[1][0] : '';
// 				$img   = 	$img[0]   ? $img[1][0]   : '';
// 				$desc  =    $desc[0]  ? $desc[1][0]  : '';
// 				$filename = '';

// 				// 图片处理
// 				if(!empty($img))
// 				{
// 					$file = file_get_contents($img);
// 					if(ceil(strlen($file) / 1000) <350)
// 					{
// 						$info = pathinfo($img);
// 						$suffix =$info['extension'];
// 						$newname = time().rand(100,9999).'.'.$suffix;
// 						file_put_contents('./collect/caiji/'.$newname,$file);
// 						$filename = './collect/caiji/'.$newname;
// 					}
// 					else
// 					{
// 						$filename = './collect/timg.jpg';
// 					}
// 				}	
// 				else
// 				{
// 					$filename = './collect/wu.jpg';
// 				}
				
// 				Yii::$app->db->createCommand("INSERT INTO img values(null,'$filename')")->execute();
// 				$img_id = Yii::$app->db->getLastInsertId();//获取最后一条ID
// 				$sqll = "insert into news(n_title,n_desc,c_id,n_img) VALUES('$title','$desc','2','$img_id')";
//    			yii::$app->db->createCommand($sqll)->execute();
// 			}	
						
// 	echo "<script>alert('入库成功！！！');location.href='?r=news/show'</script>";

// 		}	
		
// 		public function actionMem()
// 		{
// 			$mem = Yii::$app->cache;
// 			$mem->set('test','hello','60');
// 			$data = $mem->get('test');
// 			echo'<pre>';
// 			print_r($data);die;
// 		}
}


 ?> 
