<?php 
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
	 public $img;

	 public function rules()
    {
        return [
            [['img'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

     public function upload()
    {
        if ($this->validate()) 
        {
            $this->img->saveAs('upload/' . $this->img->baseName . '.' . $this->img->extension);
            $name = 'upload/' . $this->img->baseName . '.' . $this->img->extension;
            return $name;
        }
        else 
        {
            return false;
        }
    }
}












 ?>