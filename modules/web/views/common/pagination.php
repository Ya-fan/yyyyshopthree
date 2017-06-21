<?php 
use app\common\services\UrlService;

 ?>
<div class="row">
            <div class="col-lg-12">
                <span class="pagination_count" style="line-height: 40px;">共 <?= $pages['total_count']  ?>条记录 | 每页<?= $pages['page_num'] ?>条</span>
                <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
                    <?php for( $i = 1; $i<= $pages['total_page']; $i++ ) {?> 

                        <?php if( $pages['page'] == $i ) {?>
                    <li class="active"><a href="<?= UrlService::buildWebUrl($url, [ 'page'=>$i ]); ?>"><?= $i; ?></a></li>
                        <?php }else{?>
                    <li><a href="<?= UrlService::buildWebUrl($url, ['page'=> $i]);?>"><?= $i; ?></a></li>
                    <?php 
                    } }
                     ?>
                </ul>
            </div>
        </div>