<?php 
use \app\common\services\UrlService;

$tab_list = [
		'index'=>[
			'title'=>'会员列表',
			'url'=>UrlService::buildWebUrl('/member/index'),
		],
		'comment'=>[
			'title'=>'会员评论',
			'url'=>UrlService::buildWebUrl('/member/comment'),
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