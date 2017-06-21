<?php 
use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use \app\common\services\StaticService;

StaticService::includeAppJsStatic( '/js/web/book/cat.js', app\assets\WebAsset::className() )
?>
<?=  \Yii::$app->view->renderFile('@app/modules/web/views/common/tab_book.php',['current'=>'cat']);?>

<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search">
            <div class="row  m-t p-w-m">
                <div class="form-group">
                    <select name="status" class="form-control inline search">
                        <option value="-1">请选择状态</option>
                        <?php  foreach( ConstantMapService::$status_maping as $key =>$val  ){?>
                        <option value="<?= $key ?>" <?php if( $status==$key ){echo 'selected';} ?> ><?= $val ?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="<?= UrlService::buildWebUrl('/book/cat-set') ?>">
                        <i class="fa fa-plus"></i>分类
                    </a>
                </div>
            </div>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>序号</th>
                <th>分类名称</th>
                <th>状态</th>
                <th>权重</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if($car_info) {?>
                <?php foreach($car_info as $key =>$val) {?>
            <tr>
                <td><?= $val['id'] ?></td>
                <td><?= $val['name'] ?></td>
                <td><?= $val['status'] ==1 ? '正常':'已删除' ;?></td>
                <td><?= $val['weight'] ?></td>
                <td>
                    <a class="m-l" href="<?= UrlService::buildWebUrl('/book/cat-set',['id'=>$val['id']]) ?>">
                        <i class="fa fa-edit fa-lg"></i>
                    </a>
                    <?php if( $val['status'] == 1 ) {?>
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
                    'url'=>"/book/cat",
        ]);?>
    </div>
</div>

