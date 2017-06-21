<?php 
use \app\common\services\UrlService;

$tab_list = [
		'index'=>[
			'title'=>'图书列表',
			'url'=>UrlService::buildWebUrl('/book/index'),
		],
		'cat'=>[
			'title'=>'分类列表',
			'url'=>UrlService::buildWebUrl('/book/cat'),
		],
		'images'=>[
			'title'=>'图片资源',
			'url'=>UrlService::buildWebUrl('/book/images'),
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