<?php 
use \app\common\services\UrlService;

$tab_list = [
		'info'=>[
			'title'=>'品牌信息',
			'url'=>UrlService::buildWebUrl('/brand/info'),
		],
		'images'=>[
			'title'=>'品牌相册',
			'url'=>UrlService::buildWebUrl('/brand/images'),
		],
		
];	

?>
<div class="row  border-bottom">
    <div class="col-lg-12">
        <div class="tab_title">
            <ul class="nav nav-pills">
            	<?php foreach( $tab_list as $key => $val ) {?>
                <li class="<?php if( $key== $current ){echo 'current';} ?>">
                    <a href="<?= $val['url'] ?>"><?= $val['title'] ?></a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>
