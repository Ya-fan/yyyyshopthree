<?php 
use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use \app\common\services\StaticService;

StaticService::includeAppJsStatic( '/js/web/member/index.js', app\assets\WebAsset::className() )


?>
<?=  \Yii::$app->view->renderFile('@app/modules/web/views/common/tab_member.php',['current'=>'index']);?>

<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search" method="get">
            <div class="row  m-t p-w-m">
                <div class="form-group">
                    <select name="status" class="form-control inline">

                        <option value="<?= ConstantMapService::$status_default ?>">请选择状态</option>
                        <?php foreach($status_maping as $key => $val ) {?>
                        <option value="<?= $key ?>"><?= $val ?></option>
                  
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="mix_kw" placeholder="请输入关键字" class="form-control" value="">
                        <span class="input-group-btn">
                            <button type="button" class="btn  btn-primary search">
                                <i class="fa fa-search"></i>搜索
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="/web/member/set">
                        <i class="fa fa-plus"></i>会员
                    </a>
                </div>
            </div>

        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>头像</th>
                <th>姓名</th>
                <th>手机</th>
                <th>性别</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if( $member_info) {?>
            <?php foreach($member_info as $val)  {?>
            <tr>
                <td><img alt="image" class="img-circle"
                         src="/web/uploads/avatar/20170313/159419a875565b1afddd541fa34c9e65.jpg"
                         style="width: 40px;height: 40px;"></td>
                <td><?= $val['nickname'] ?></td>
                <td><?= $val['mobile'] ?></td>
                <td><?php if($val['sex'] == 0) {echo '未填写'; }else if($val['sex'] == 1){echo '男';}else if($val['sex'] == 2){echo '女';}?></td>
                <td><?php if( $val['status'] == 1){echo '正常';}else{echo '无效';} ?></td>
                <td>
                    <a href="/web/member/info?id=<?= $val['id'] ?>">
                        <i class="fa fa-eye fa-lg"></i>
                    </a>
                    <a class="m-l" href="/web/member/set?id=<?= $val['id'] ?>">
                        <i class="fa fa-edit fa-lg"></i>
                    </a>
                <?php if($val['status'] ) {?>
                    <a class="m-l remove" href="javascript:void(0);" data="<?= $val['id'] ?>">
                        <i class="fa fa-trash fa-lg"></i>
                    </a>
                  <?php }else{?>  
                     <a class="m-l recover" href="javascript:void(0);" data="<?= $val['id'] ?>">
                        <i class="fa fa-rotate-left fa-lg"></i>
                    </a>
                  <?php } ?>
                </td>
            </tr>
            <?php } }?>
            </tbody>
        </table>
        <?=  \Yii::$app->view->renderFile('@app/modules/web/views/common/pagination.php',[
                    'pages'=>$pages,
                    'url'=>"/member/index",
        ]);?>
        
    </div>
</div>

