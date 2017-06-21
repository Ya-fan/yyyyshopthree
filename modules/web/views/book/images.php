<?php 
use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use \app\common\services\StaticService;
?>
<?=  \Yii::$app->view->renderFile('@app/modules/web/views/common/tab_book.php',['current'=>'images']);?>

<div class="row">
    <div class="col-lg-12">
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>图片</th>
                <th>图片地址</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach( $Images_info as $val ) {?>
            <tr>
                <td>
                    <img src="<?= UrlService::buildImgUrl($val['bucket'],$val['file_key'] ) ?>"
                         style="width: 100px;height: 100px;"/>
                </td>
                <td>
                    <a href="<?= UrlService::buildImgUrl($val['bucket'],$val['file_key'] ) ?>" target="_blank">查看大图</a>
                </td>
            </tr>
            <?php } ?>
               
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-12">
                <span class="pagination_count" style="line-height: 40px;">共17条记录 | 每页50条</span>
                <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
                    <li class="active"><a href="javascript:void(0);">1</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

