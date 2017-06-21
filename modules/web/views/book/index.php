<?php 
use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use \app\common\services\StaticService;

StaticService::includeAppJsStatic( '/js/web/book/index.js', app\assets\WebAsset::className() );


?>
<?=  \Yii::$app->view->renderFile('@app/modules/web/views/common/tab_book.php',['current'=>'index']);?>

<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search">
            <div class="row  m-t p-w-m">
                <div class="form-group">
                    <select name="status" class="form-control inline">
                        <option value="-1">请选择状态</option>
                        <?php  foreach( ConstantMapService::$status_maping as $key =>$val  ){?>
                        <option value="<?= $key ?>" <?php if( $status == $key ){echo 'selected';} ?>><?= $val ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <select name="cat_id" class="form-control inline">
                        <option value="0">请选择分类</option>
                        <?php foreach( $car_info as $key=>$val ) {?>
                       
                        <option value="<?= $val['id'] ?>" <?php if( $val['id'] == $cat_id ){echo 'selected';} ?>><?= $val['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="mix_kw" placeholder="请输入关键字" class="form-control" value="">
                        <span class="input-group-btn">
                            <button type="button" class="btn  btn-primary search">
                                <i class="fa fa-search"></i>搜索
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="/web/book/set">
                        <i class="fa fa-plus"></i>图书    
                    </a>
                </div>
            </div>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>图书名</th>
                <th>分类</th>
                <th>价格</th>
                <th>库存</th>
                <th>标签</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if( $book_info) {
                    foreach( $book_info as $key => $val){
                ?>
            <tr>
                <td><?= $val['name'] ?></td>
                <td><?= $val['cat_id'] ?></td>
                <td><?= $val['price'] ?></td>
                <td><?= $val['stock'] ?></td>
                <td><?= $val['tags'] ?></td>
                <td>
                    <a href="<?= UrlService::buildWebUrl('/book/info',['id'=>$val['id']]) ?>">
                        <i class="fa fa-eye fa-lg"></i>
                    </a>
                    <a class="m-l" href="<?= UrlService::buildWebUrl('/book/set',['id'=>$val['id']]) ?>">
                        <i class="fa fa-edit fa-lg"></i>
                    </a>
                    <?php if($val['status'] == 1) {?>
                    <a class="m-l remove" href="javascript:void(0);" data="<?= $val['id'] ?>">
                        <i class="fa fa-trash fa-lg"></i>
                    </a>
                    <?php }else{?>
                    <a class="m-l recover" href="javascript:void(0);" data="<?= $val['id'] ?>">
                        <i class="fa fa-rotate-left fa-lg"></i>
                    </a>
                    <?php } ?>
                </td>
            </tr>
            <?php }} ?>
            
            </tbody>
        </table>
 
        <?=  \Yii::$app->view->renderFile('@app/modules/web/views/common/pagination.php',[
                    'pages'=>$pages,
                    'url'=>"/book/index",
        ]);?>
    </div>
</div>

