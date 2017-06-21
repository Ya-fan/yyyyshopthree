<?php 
use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use \app\common\services\StaticService;


?>
<?=  \Yii::$app->view->renderFile('@app/modules/web/views/common/tab_book.php', ['current'=>'info']);?>

<style type="text/css">
    .wrap_info img {
        width: 70%;
    }
</style>
<div class="row m-t wrap_info">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <div class="m-b-md">
                    <a class="btn btn-outline btn-primary pull-right" href="<?= UrlService::buildWebUrl('/book/set',['id'=>$book_info['id']]) ?>">
                        <i class="fa fa-pencil"></i>编辑
                    </a>
                    <h2>图书信息</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <p class="m-t">图书名称： <?=$book_info['name'] ?> </p>
                <p>图书售价： <?= $book_info['price'] ?></p>
                <p>库存总量： <?= $book_info['stock'] ?></p>
                <p>图书标签： <?= $book_info['tags'] ?></p>
                <p>封面图：<img src="<?= UrlService::buildImgUrl('book', $book_info['main_image']) ?>"
                            style="width: 50px;height: 50px;"/></p>
                <p>图书描述：
                <?= $book_info['summary'] ?>
                </p>
            </div>
        </div>
        <div class="row m-t">
            <div class="col-lg-12">
                <div class="panel blank-panel">
                    <div class="panel-heading">
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab-1" data-toggle="tab" aria-expanded="false">销售历史</a>
                                </li>
                                <li>
                                    <a href="#tab-2" data-toggle="tab" aria-expanded="true">库存变更</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-1">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>会员名称</th>
                                        <th>购买数量</th>
                                        <th>购买价格</th>
                                        <th>订单状态</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            郭威
                                        </td>
                                        <td>4</td>
                                        <td>355.52</td>
                                        <td>2017-03-16 16:24:37</td>
                                    </tr>
                                   
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab-2">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>变更</th>
                                        <th>备注</th>
                                        <th>时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach( $StockChangeInfo as $val ) {?>
                                    <tr>
                                        <td><?= $val['unit'] ?></td>
                                        <td><?= $val['note'] ?></td>
                                        <td><?= $val['created_time'] ?></td>
                                    </tr>
                                    <?php } ?>
                                   
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
