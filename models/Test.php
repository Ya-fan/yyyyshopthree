<?php 
namespace app\models;
use yii\db\ActiveRecord;
class Test extends ActiveRecord
{
	
	public function rules()
	{
	    return [
	        // name，email，subject 和 body 特性是 `require`（必填）的
	        [['name', 'email', 'age'], 'required'],
	        ['name','string','length'=>[0,3]],
	        ['age','integer'],	
	        // email 特性必须是一个有效的 email 地址
	        ['email', 'email'],
	    ];
	}
}

 ?>