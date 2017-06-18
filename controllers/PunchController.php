<?php 
namespace app\controllers;
use yii\web\Controller;

use Yii;
use yii\data\Pagination;
use yii\db\Query;

use app\models\Staff;
use app\models\Punch;

use Recursion;
use Mysql;

class PunchController extends controller
{

	public function actionIndex()
	{
		echo strtotime( date('Y-m-d') );
		echo '<br>';

		// 每天九点三十
		$ninetime = date('Y-m-d').' 09:00:00';
		echo strtotime( $ninetime );
		echo '<br>';
		
		// 每天十点
		$tentime  = date('Y-m-d').' 10:00:00';
		
		echo  strtotime($tentime);die;
	
	}


	public function actionAdd()
	{
		$request = Yii::$app->request;

		if( $request->isGet )
		{
			return $this->render('add');
		}
		else
		{
			$data = $request->post();
			
			header('content-type:text/html;charset=utf8');
			
			$db = new Staff();

			$db->name = $data['name'];
			
			$row =  $db->save();
			
			if($row)
			{
				return $this->redirect(['punch/search']);
			}
			else
			{
				echo 2;
			}
		}

	}

	public function actionSearch()
	{
		$request = Yii::$app->request;


		if($request->isGet)
		{
			$db_Staff = new Staff();

			$staff_Data = $db_Staff::find()->asArray()->all();

			return $this->render('search',['staff_Data'=>$staff_Data]);
		}
		else if($request->isPost)
		{	
			$db_Punch = new Punch;
			
			$id = $request->post('staff_id');
			
			// 当日时间戳
			$same = strtotime( date('Y-m-d') );

			// 每日九点三十的时间戳
			$ninetime = date('Y-m-d').' 09:00:00';
			$ninetime = strtotime( $ninetime );

			// 每日十点的时间戳
			$tentime  = date('Y-m-d').' 10:00:00';
			$tentime  = strtotime( $tentime );

			// 每日六点的时间戳
			$sixtime = date('Y-m-d').' 18:00:00';
			$sixtime = strtotime( $tentime );

			// 每日六点三十的时间戳
			$sixhalf = date('Y-m-d').' 18:30:00';
			$sixhalf = strtotime( $sixhalf );

			// 十二点的时间戳
			$twelvetime = date('Y-m-d').' 12:00:00';
			$twelvetime = strtotime( $twelvetime );

			// 当前时间戳	
			$time = time();
			
			$user_info = $this->ispunch( $id ,$same);

			if( is_array($user_info) )
			{
					// 正常上班
					if( $time <= $ninetime)
					{
						echo 1;
					}
					else if( $time <= $tentime && $time >$ninetime ) 	// 早退
					{
						echo 12;
					}
					else if( $time > $tentime && $time <= $twelvetime  ) // 旷工半天
					{
						echo 13;

					}
					else if( $time <$sixtime && $time >$twelvetime ) 	// 矿工下半天 	
					{
						echo 14;

					}
					else if( $time >= $sixtime && $time < $sixhalf )	// 早退
					{
						echo 15;

					}
					else if( $time >= $sixhalf ) // 正常下班
					{
						echo 16;

					}
			}
			else 
			{	
				if( $user_info == 2 )
				{
					// 全天旷工
					$db_Punch->user_id = $id;
					$db_Punch->user_forenoon = '';
					$db_Punch->user_afternoon = '';
					$db_Punch->punchdate = $same-24*60*60;
					$db_Punch->for_status = 3;
					$db_Punch->after_status = 3;

					$db_Punch->save();
				}

				// 大于12点 下半天 小于12点上半天
				if( $time >= $twelvetime )
				{
					$db_Punch->user_id = $id;
					$db_Punch->user_forenoon = '';
					$db_Punch->punchdate = $same;
				}
				else
				{	
					$db_Punch->user_id = $id;
					$db_Punch->user_forenoon = $time;
					$db_Punch->punchdate = $same;

					if( $time <= $ninetime )
					{	
						// 正常上班
						$db_Punch->for_status = 1;
					}
					else if(  $time <= $tentime && $time >$ninetime )
					{	
						// 迟到
						$db_Punch->for_status = 2;
					}
					else
					{
						$db_Punch->for_status = 3;
					}

				}
			}
			

			
			

		}

			
	}


	// 判断当前用户当天是否打卡
	public function ispunch($id,$same)
	{	
		
		$mysql = new Mysql('127.0.0.1','drill_one','root','root');

		$data = $mysql->select('select * from staff');
		
		echo '<pre>';
		var_dump($data);
		die;


		$db_Punch = new Punch;

		$user_info = $db_Punch::find()->where(['punchdate'=>$same,'user_id'=>$id])->one();
	
		if($user_info == null)
		{
			
			$user_yesterday_info = $db_Punch::find()->where(['punchdate'=>($same-60*60*24),'user_id'=>$id])->one();
			
			if( $user_yesterday_info == null )
			{
				return 2;
				                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 
			}
			else
			{
				return 1;
			}
		}
		else
		{
			return $user_info;
		}

	}



}

 ?>