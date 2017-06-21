<?php 
use \app\common\services\UrlService;

$tab_list = [
		'index'=>[
			'title'=>'财务统计',
			'url'=>UrlService::buildWebUrl('/stat/index'),
		],
		'product'=>[
			'title'=>'商品售卖',
			'url'=>UrlService::buildWebUrl('/stat/product'),
		],
		'member'=>[
			'title'=>'会员消费统计',
			'url'=>UrlService::buildWebUrl('/stat/member'),
		],
		'share'=>[
			'title'=>'分享统计',
			'url'=>UrlService::buildWebUrl('/stat/share'),
		],
];	
?>
<div class="row  border-bottom">
    <div class="col-lg-12">
        <div class="tab_title">
            <ul class="nav nav-pills">
            	<?php foreach($tab_list as $key => $val ) {?>
                <li class="<?php if( $key == $current) {echo 'current';}?>">
                    <a href="<?= $val['url'] ?>"><?= $val['title'] ?></a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

