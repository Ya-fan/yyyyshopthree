<?php 
use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use \app\common\services\StaticService;
use \app\common\services\UtilService;

StaticService::includeAppJsStatic('/js/m/default/index.js', app\assets\MAsset::className() );

 ?>

    <div class="shop_header">
        <i class="shop_icon"></i>
        <strong>敲程序的代码楊的店！</strong>
    </div>

 <?php if( $imgae_list) {?>
    <div id="slideBox" class="slideBox">
        <div class="bd">
            <ul>    
               
                <?php  foreach($imgae_list as $val ) {?>
                <li><img style="max-height: 250px;" src="<?= UrlService::buildImgUrl('brand',$val['image_key']) ?>"/>
                </li>
                <?php }?>

                
            </ul>
        </div>
        <div class="hd">
            <ul></ul>
        </div>
    </div>
    <?php }else{echo '店铺装修中';} ?>
    <div class="fastway_list_box">
        <ul class="fastway_list">
            <li><a href="javascript:void(0);" style="padding-left: 0.1rem;"><span>品牌名称： <?= UtilService::encode( $brand_info['name'] ) ?></span></a></li>
            <li><a href="javascript:void(0);" style="padding-left: 0.1rem;"><span>联系电话： <?= UtilService::encode( $brand_info['mobile'] ) ?></span></a></li>
            <li><a href="javascript:void(0);"
                   style="padding-left: 0.1rem;"><span>联系地址：  <?= UtilService::encode( $brand_info['address'] ) ?></span></a></li>
            <li><a href="javascript:void(0);" style="padding-left: 0.1rem;"><span>品牌介绍： <?= UtilService::encode( $brand_info['description'] )  ?></span></a>
            </li>
        </ul>
    </div>



