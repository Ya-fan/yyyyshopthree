<?php 
use \app\common\services\UrlService;

$tab_list = [
		'info'=>[
			'title'=>'订单列表',
			'url'=>UrlService::buildWebUrl('/finance/index'),
		],
		'account'=>[
			'title'=>'财务流水',
			'url'=>UrlService::buildWebUrl('/finance/account'),
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
