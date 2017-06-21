<?php
use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use \app\common\services\StaticService;
use \app\common\services\UtilService;

StaticService::includeAppJsStatic('/js/m/product/info.js', app\assets\MAsset::className());

?>
    <div class="pro_tab clearfix">
        <span>图书详情</span>
    </div>
    <div class="proban">
        <div id="slideBox" class="slideBox">
            <div class="bd">
                <ul>
                    <li><img src="<?= $data['main_image'] ?>"/></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="pro_header">
        <div class="pro_tips">
            <h2> <?= $data['name'] ?> </h2>
            <h3><b>¥ <?= $data['price'] ?> </b><font>库存量： <?= $data['stock'] ?></font></h3>
        </div>
        <span class="share_span"><i class="share_icon"></i><b>分享商品</b></span>
    </div>
    <div class="pro_express">月销量： <?= $data['month_count'] ?> <b>累计评价： <?= $data['comment_count'] ?></b></div>
    <div class="pro_virtue">
        <div class="pro_vlist">
            <b>数量</b>
            <div class="quantity-form">
                <a class="icon_lower"></a>
                <input type="text" name="quantity" class="input_quantity" value="1" readonly="readonly" max="<?= $data['stock'] ?>"/>
                <a class="icon_plus"></a>
            </div>
        </div>
    </div>
    <div class="pro_warp">
     <?= $data['summary'] ?></div>
    <div class="pro_fixed clearfix">
        <a href="/m/"><i class="sto_icon"></i><span>首页</span></a>
        <?php  if(!$has_faved ){?>
            <a class="fav" href="javascript:;" data="<?= $data['id'] ?>"><i class="keep_icon"></i><span>收藏</span></a>
        <?php }else{?>
            <a class="fav has_faved" href="javascript:;" ><i class="keep_icon"></i><span>已收藏</span></a>
        <?php }?>
        <input type="button" value="立即订购" class="order_now_btn" data="<?= $data['id'] ?>"/>
        <input type="button" value="加入购物车" class="add_cart_btn" data="<?= $data['id'] ?>"/>
        <input type="hidden" name="id" value="<?= $data['id']?>">
</div>

