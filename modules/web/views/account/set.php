<?php 
use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use \app\common\services\StaticService;

StaticService::includeAppJsStatic('/js/web/account/set.js', app\assets\WebAsset::className() );
 ?>

<?=  \Yii::$app->view->renderFile('@app/modules/web/views/common/tab_account.php');?>

<div class="row m-t  wrap_account_set">
    <div class="col-lg-12">
        <h2 class="text-center">账号设置</h2>
        <div class="form-horizontal m-t m-b">
            <div class="form-group">
                <label class="col-lg-2 control-label">姓名:</label>
                <div class="col-lg-10">
                    <input type="text" name="nickname" class="form-control" placeholder="请输入姓名~~" value="<?= $user_info['nickname'] ?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">手机:</label>
                <div class="col-lg-10">
                    <input type="text" name="mobile" class="form-control" placeholder="请输入手机~~" value="<?= $user_info['mobile'] ?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">邮箱:</label>
                <div class="col-lg-10">
                    <input type="text" name="email" class="form-control" placeholder="请输入邮箱~~" value="<?= $user_info['email'] ?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">登录名:</label>
                <div class="col-lg-10">
                    <input type="text" name="login_name" class="form-control" autocomplete="off" placeholder="请输入登录名~~"
                           value="<?= $user_info['login_name'] ?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">登录密码:</label>
                <div class="col-lg-10">
                    <input type="password" name="login_pwd" class="form-control" autocomplete="new-password"
                           placeholder="请输入登录密码~~" value="<?= $user_info['login_pwd'] ? ConstantMapService::$default_pwd :''; ?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-lg-4 col-lg-offset-2">
                    <input type="hidden" name="id" value="<?= $user_info['uid'] ?$user_info['uid'] :0 ?>">
                    <button class="btn btn-w-m btn-outline btn-primary save">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>


