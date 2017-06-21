<?php 
namespace app\modules\web\controllers;


use app\common\components\BaseController;
use yii\web\Controller;
use app\common\services\ConstantMapService;
use app\common\services\BookService;

use app\modules\web\controllers\common\BaseWebController;
use app\models\Book;
use app\models\BookCat;
use app\models\BookStockChangeLog;
use app\models\Images;  



class BookController extends BaseWebController
{
    public $layout = 'main';
    
	/**
     * 图书列表
     * @return string
     */
    public function actionIndex()
    {	


        if( $this->isRequestMethod( 'get' ) )
        {

            $status = intval( $this->get('status', ConstantMapService::$status_default) );
           
            $mix_kw = trim( $this->get('mix_kw', '' ) );
            
            $cat_id = intval( $this->get( 'cat_id', ConstantMapService::$status_default));

            $page   = intval( $this->get( 'page' ,1 ) );

            $query = Book::find();

            if( $status > ConstantMapService::$status_default )
            {
                $query->andWhere( [ 'status'=>$status ] );
            }

            if( $cat_id > ConstantMapService::$status_default )
            {
                $query->andWhere( [ 'cat_id'=>$cat_id ] );
            }

            if( $mix_kw )
            {
                $query->andWhere([ 'LIKE', 'name', $mix_kw.'%', false ]);
            }

            // 分页
            $page_num = 3;
            $total_count = $query->count();
            $total_page  = ceil( $total_count / $page_num );

            $book_info = $query->orderBy( [ 'id'=> SORT_DESC ] )
                          ->offset( ($page-1)*$page_num )   
                          ->limit( $page_num )->asArray()
                          ->all();

            // 分类
             $car_info = BookCat::find()->orderBy( ['weight'=>SORT_DESC ] )->all();
       
               return $this->render( "index", [ 'book_info'=>$book_info ,
                        'car_info'=>$car_info,
                        'status'=>$status,
                        'cat_id'=>$cat_id,
                        'mix_kw'=>$mix_kw,
                        'pages'=>[
                             'page'=>$page,
                             'total_count'=>$total_count,
                             'total_page' =>$total_page,
                             'page_num'   =>$page_num,
                           ]] );
        }
    }

    /**
     * 图书添加或修改
     * @return string
     */
    public function actionSet()
    {			
        if( $this-> isRequestMethod( 'get' ) )
        {
            $id = intval( $this->get('id','') );
            $book_info = null;

            if( $id )
            {
              $book_info =   Book::find()->where( ['id'=>$id,'status'=> 1 ] )->one();
            }

            $car_info = BookCat::find()->orderBy( ['weight'=>SORT_DESC ] )->all();


            return $this->render( "set" ,[
                'book_info' =>  $book_info,
                'car_info'  =>  $car_info,
                ]);
        }
        else
        {
            $name       = trim( $this->post('name','') );
            $cat_id     = intval( $this->post('cat_id','') );
            $price      = floatval( $this->post('price','') );
            $stock      = intval( $this->post('stock','') );
            $summary    = trim( $this->post('summary','') );
            $tags       = trim( $this->post('tags','') );
            $imagekey   = trim( $this->post('imagekey','') );
            $id         = trim( $this->post('id','') );
            $time       = date( 'Y-m-d H:i:s' );

            if( mb_strlen($name, 'utf-8' ) < 1 )
            {
                return $this->renderJosn( [], '请您填写正确的分类名',-1 );
            }

            if( mb_strlen($cat_id, 'utf-8' ) < 1 || !is_numeric($cat_id ) )
            {
                return $this->renderJosn( [], '请您选择正确的分类名',-1 );
            }

            if( mb_strlen($price, 'utf-8' ) < 1 )
            {
                return $this->renderJosn( [], '请您填写正确的图书单价',-1 );
            }

            if( mb_strlen( $imagekey,'utf-8' ) < 1 )
            {
                return $this->renderJson( [], '请上传图片', -1);
            }

            if( mb_strlen($summary, 'utf-8' ) < 10 )
            {
                return $this->renderJosn( [], '请输入图书描述，并不能少于10个字符~~',-1 );
            }

            if( mb_strlen($stock, 'utf-8' ) < 1  || !is_numeric( $stock ))
            {
                return $this->renderJosn( [], '请您填写正确的图书库存',-1 );
            }

            if( mb_strlen($tags, 'utf-8' ) < 1  )
            {
                return $this->renderJosn( [], '请您填写正确的图书标签',-1 );
            }


            if( $id )
            {
                $model_book = Book::findOne(['id' => $id]); 
            }
            else
            {
                $model_book = new Book();
                $model_book->status = 1;
                $model_book->created_time = $time;
            }

            $before_stock = $model_book->stock;

            $model_book->cat_id     = $cat_id;
            $model_book->name       = $name;
            $model_book->price      = $price;
            $model_book->main_image = $imagekey;
            $model_book->summary    = $summary;
            $model_book->stock      = $stock;
            $model_book->tags       = $tags;
            $model_book->updated_time = $time;

            if( $model_book->save( 0 ) )
            {
                BookService::setStockChangeLog( $model_book->id,( $model_book->stock - $before_stock ) );
            }

            return $this->renderJSON([],"操作成功~~");
        }

        
    }

    /**
     * 图片资源
     * @return string
     */
    public function actionImages()
    {			
        $Images_info = Images::find()->all();


        return $this->render( "images" ,['Images_info'=>$Images_info] );
    }

    /**
     * 图书详情
     * @return string
     */
    public function actionInfo()
    {
         if( $this->isRequestMethod( 'get' ) )
         {
            $id = trim( $this->get('id','') );
            
            // 图书信息        
            $book_info = Book::find()->where( ['id'=>$id] )->one();

            // 库存变更信息  
            $StockChangeInfo = BookStockChangeLog::find()->where( ['book_id'=>$id] )->all(); 
                      
            return $this->render('info',[ 'book_info'=>$book_info,'StockChangeInfo'=>$StockChangeInfo ]);

         }

    }

   	/**
     * 图书分类
     * @return string
     */
    public function actionCat()
    {	
         if( $this->isRequestMethod( 'get' ) )
         {
            
            $status = trim( $this->get('status',-1) );

            $page   = intval( $this->get( 'page' ,1 ) );

            $query  = BookCat::find();

             if( $status > ConstantMapService::$status_default )
            {
                $query->andWhere( [ 'status'=>$status ] );
            }

            // 分页
            $page_num = 3;
            $total_count = $query->count();
            $total_page  = ceil( $total_count / $page_num );

            $car_info = $query->orderBy( [ 'weight'=> SORT_DESC ] )
                          ->offset( ($page-1)*$page_num )   
                          ->limit( $page_num )
                          ->all();

        return $this->render( "cat" ,[
            'car_info'=>$car_info,
            'status'=>$status,
            'pages'=>[
                     'page'=>$page,
                     'total_count'=>$total_count,
                     'total_page' =>$total_page,
                     'page_num'   =>$page_num,
                   ]] );
         }  
    }

    /**
     * 分类修改/添加
     * @return string
     */
    public function actionCatSet()
    {			
        if( $this->isRequestMethod('get') )
        {   
            $id = trim( $this->get( 'id','' ) );

            $car_info = null;
            if( $id  )
            {
              $car_info =  BookCat::find()->where( [ 'id'=>$id,'status'=>1 ] )->one();
            }

            return $this->render( "cat_set" ,['car_info'=>$car_info]);
        }
        else
        {
            $name = trim( $this->post('name','') );
            
            $weight = trim( $this->post('weight','') );
            
            $id = trim( $this->post('id','') );
            
            $time = date( 'Y-m-d H:i:s' );
            if( mb_strlen($name, 'utf-8' ) < 1 )
            {
                return $this->renderJosn( [], '请您填写正确的分类名',-1 );
            }

            if( mb_strlen($name, 'utf-8' ) < 1 || !is_numeric( $weight ) )
            {
                return $this->renderJosn( [], '请您填写正确的权重',-1 );
            }

            if( $id ) 
            {
               $car_info = BookCat::find()->where( [ 'id'=>$id,'status'=>1 ] )->one();  
            }
            else
            {
                $count =  BookCat::find()->where( [ 'name'=>$name] )->andWhere(  '!=','id',$id  )->count();
                
                if( $count > 1 )
                {
                    return $this->renderJson( [], '该分类名已存在' ,-1 );
                }
                $car_info = new BookCat();
                $car_info->created_time =$time;
            }

            $car_info->name = $name;
            $car_info->weight = $weight;
            $car_info->updated_time = $time;
            
            $car_info->save( 0 ) ;
        
            return $this->renderJson( [], '保存成功');
        }

    }


    // 分类操作
    public function actionCatOps()
    {
        if( !$this->isRequestMethod( 'post' ) )
        {
           return $this->renderJson( [], '对不起，服务器繁忙', -1 );
        }

        $act = trim( $this->post( 'act', '' ) );

        $id = intval( $this->post( 'id','' ) ) ;

        if( !$id )
        {
            return $this->renderJson( [],'操作有误，请重试',-1 );
        }

        if( empty( $act ) )
        {
            return $this->renderJson( [],'操作有误，请重试2',-1 );
        }

        $car_info = BookCat::find()->where( [ 'id'=>$id ] )->one();

        if( !$car_info )
        {
            return $this->renderJson( [],'您的账号不存在',-1 );
        }

        switch ($act) {
            case 'remove':
                $car_info->status = 0;
              
                break;
            
            default:
                $car_info->status = 1;
                break;
        }

          $car_info->updated_time = date( 'Y-m-d H:i:s' );
          $car_info->update( 0 );

      return  $this->renderJson( [],'您的操作成功' , 200 );
    }

    /**
     * 图书操作
     * @return    bool
     */
    public function actionOps()
    {
        if( !$this->isRequestMethod( 'post' ) )
        {
           return $this->renderJson( [], '对不起，服务器繁忙', -1 );
        }

        $act = trim( $this->post( 'act', '' ) );

        $uid = intval( $this->post( 'uid','' ) ) ;

        if( !$uid )
        {
            return $this->renderJson( [],'操作有误，请重试',-1 );
        }

        if( empty( $act ) )
        {
            return $this->renderJson( [],'操作有误，请重试2',-1 );
        }

        $Book_info = Book::find()->where( [ 'id'=>$uid ] )->one();

        if( !$Book_info )
        {
            return $this->renderJson( [],'该图书不存在',-1 );
        }

        switch ($act) {
            case 'remove':
                $Book_info->status = 0;
              
                break;
            
            default:
                $Book_info->status = 1;
                break;
        }

          $Book_info->updated_time = date( 'Y-m-d H:i:s' );
          $Book_info->update( 0 );

      return  $this->renderJson( [],'您的操作成功' , 200 );
    }


}	
 ?>