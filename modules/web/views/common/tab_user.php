<?php 
use \app\common\services\UrlService;
$tab_list = [
		'edit'=>[
			'title'	=>	'信息编辑',
			'url'	=>	UrlService::buildWebUrl('/user/edit'),
		],

		'reset_pwd'=>[
			'title'	=>	'修改密码',
			'url'	=>	UrlService::buildWebUrl('/user/reset-pwd'),
		],
];
 ?>
 <div class="row  border-bottom">
    <div class="col-lg-12">
        <div class="tab_title">
            <ul class="nav nav-pills">
            <?php foreach($tab_list as $currentKey => $val) {?>
                <li class="<?php if( $currentKey == $current ) echo 'current' ?>">
                    <a href="<?= $val['url'] ?>"><?= $val['title'] ?></a>
                </li>
               <?php } ?>
            </ul>
        </div>
    </div>
</div>