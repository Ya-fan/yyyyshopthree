<?php 
use \app\common\services\UrlService;
use \app\common\services\UtilService;
use \app\common\services\StaticService;
?>
<?php 
// 引入前端资源的文件
use app\assets\MAsset;

MAsset::register( $this );
    
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <title><?= \Yii::$app->params['title']['name'] ?>微信图书商城</title>
    <link href="/web/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="/m/css/m/css_style.css" rel="stylesheet">
    <link href="/m/css/m/app.css?ver=20170401" rel="stylesheet">
</head>
<body>
<?php $this->beginBody(); ?>
<div style="min-height: 500px;">

	<!--view begin-->
	<?= $content; ?>
	<!--view end-->

</div>
<div class="layout_hide_wrap hidden">
    
<input type="hidden" id="share_info" value='<?= Yii::$app->getView()->params['share_info']  ?>'>

</div>
<div class="copyright clearfix">
<?php if( isset( $this->params['current_user'] ) ) {?>
    <p class="name">欢迎您，  <?= UtilService::encode( $this->params['current_user']['nickname']) ;?> </p>
    <?php } ?>
    <p class="copyright">由<a href="/" target="_blank">~敲程序的代码楊~</a>提供技术支持</p>
</div>
<div class="footer_fixed clearfix">
    <span><a href="<?= \Yii::$app->params['domain']['m'] ?>/default/index" class="default"><i class="home_icon"></i><b>首页</b></a></span>
    <span><a href="<?= UrlService::buildMUrl('/product/index') ?>" class="product"><i class="store_icon"></i><b>图书</b></a></span>
    <span><a href="<?= UrlService::buildMUrl('/user/index') ?>" class="user"><i class="member_icon"></i><b>我的</b></a></span>
</div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>