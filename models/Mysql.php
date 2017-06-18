<?php 



class Mysql
{


	private $conn; // 连接资源
	private $error; // 错误

	// 连接数据库
 	public	function __construct($dsn='127.0.0.1',$dbname='',$dbuser='root',$dbpwd = '')
	{
		$db_DSN 	= 'mysql:host='.$dsn;
		$db_name	= 'dbname='.$dbname;
		$db_user	= $dbuser;
		$db_pwd 	= $dbpwd;
		
	

		$db = new PDO($db_DSN.';'.$db_name,$db_user,$db_pwd);
		
		$db = $db->query('set names utf8');
		
		$this->conn = $db;
	}


	public function select($sql = '')
	{
		if($sql == '')
		{
			$this->error = 'select参数为空';
			return $this->error;
		}
		else
		{	
			$sql  = mysql_real_escape_string( $sql );
			
			$data = $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);		
			
			if(is_array( $data ))
			{	
				return $data;
			}
			else
			{
				return $this->error = 'null';
			}
		}
	}

	public function get_One( $id = 0 )
	{
		if( $id == 0  )
		{
			return $this->error = 'get_One参数为空';
		}
		else
		{

		  $sql = 'SELECT * FROM XXX WHERE `id` = :id ';

		  $One_db = $this->conn->prepare( $sql );

		  $One_db->execute(':id='.$id );
		  
		  $data =  $One_db->fetch(PDO::FETCH_ASSOC);
		 
		  if( is_array( $data ) )
		  {
		  	return $data;	
		  }
		  else
		  {
		  	return $this->error = 'null';
		  }

		}
	}

}

 ?>