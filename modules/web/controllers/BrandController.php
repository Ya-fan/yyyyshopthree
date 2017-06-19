<?php 
namespace app\modules\web\controllers;

use app\common\components\BaseController;
use yii\web\Controller;

use app\modules\web\controllers\common\BaseWebController;

use app\models\BrandImages;
use app\models\BrandSetting;

use app\common\services\ConstantMapService;
use app\common\services\UrlService;


class BrandController extends BaseWebController
{
    public $layout = 'main';
    
	/**
     * 品牌详情
     * @return string
     */
    public function actionInfo()
    {			
        $brand_info = BrandSetting::find()->one();
        return $this->render( "info" ,[ 'info'=>$brand_info ]);
    }

    /**
     * 品牌添加或者删除
     * @return string
     */
    public function actionSet()
    {			
        if( $this->isRequestMethod( 'get' ) )
        {
             $brand_info = BrandSetting::find()->one();

            return $this->render( "set", ['info'=>$brand_info]);
        }
        else
        {
            $name = trim( $this->post( 'name', '' ) );
            $mobile =  trim( $this->post( 'mobile', '' ) )  ;
            $description = trim(  $this->post( 'description', '' ) ) ;
            $address = trim(  $this->post( 'address', '' ) )  ;
            $imagekey = trim(  $this->post( 'imagekey', '' ) )  ;
            $date = date('Y-m-d H:i:s');

            if( mb_strlen( $name, 'utf-8' ) < 1 )
            {
               return $this->renderJson( [], '请您填写正确的品牌名', -1 );
            }

            if( mb_strlen( $imagekey, 'utf-8' ) < 1 )
            {
               return $this->renderJson( [], '请您选择图片', -1 );
            }

            if( mb_strlen( $mobile, 'utf-8' ) < 1 )
            {
               return $this->renderJson( [], '请您填写正确的品牌手机号', -1 );
            }

            if( mb_strlen( $description, 'utf-8' ) < 1 )
            {
               return $this->renderJson( [], '请您填写正确的品牌简介', -1 );
            }

            if( mb_strlen( $address, 'utf-8' ) < 1 )
            {
               return $this->renderJson( [], '请您填写正确的品牌地址', -1 );
            }

            $brand_info = BrandSetting::find()->one();

            if( $brand_info )
            {
                $model_brand = $brand_info;
            }
            else
            {
                $model_brand = new BrandSetting();
                $model_brand->created_time = $date;
            }

            $model_brand->name = $name;
            $model_brand->address = $address;
            $model_brand->description = $description;
            $model_brand->mobile = $mobile;
            $model_brand->logo = $imagekey;
            $model_brand->updated_time = $date;

            $model_brand->save( 0 );

            return $this->renderJson( [], '操作成功', 200 );

        }
    }

    /**
     * 品牌图片添加
     * @return string
     */
    public function actionImages()
    {			
        $image_info = BrandImages::find()->orderBy(['id'=>SORT_DESC])->all();

        return $this->render( "images" ,['image_info'=>$image_info]);
    }


    public function actionSetImage()
    {
        $imagekey = trim( $this->post('imagekey','') );
        

        if( !$imagekey )
        {
            $this->renderJson( [],'请上传图片',-1 );
        }


        $total_count = BrandImages::find()->count();
        
        if( $total_count > 5 )
        {
            return $this->renderJson( [], '最多上传5张图片', -1 );
        }
        
        $model = new BrandImages();
        $model->image_key = $imagekey;

        $model->created_time = date( 'Y-m-d H:i:s');

        $model->save( 0 );

        return $this->renderJson( [], '操作成功' );
    }   


    public function actionImageOps()
    {
        if( $this->isRequestMethod( 'post' ) )
        {
            $id = $this->post('id','' );
        
            $info = BrandImages::find()->where([ 'id'=>$id ])->one();
            
            if( !$info )
            {
                return $this->renderJson([], '图片不存在',-1);
            }   
            $info->delete();
            return $this->renderJson( [], '操作成功' ) ;
        }

    }




}
 ?>