<?php 
use \app\common\services\UrlService;

$tab_list = [

		'title'=>'账户列表',
		'url'=>UrlService::buildWebUrl('/account/index'),
];	
?>
<div class="row  border-bottom">
    <div class="col-lg-12">
        <div class="tab_title">
            <ul class="nav nav-pills">
                <li class="current">
                    <a href="<?= $tab_list['url'] ?>"><?= $tab_list['title'] ?></a>
                </li>
            </ul>
        </div>
    </div>
</div>