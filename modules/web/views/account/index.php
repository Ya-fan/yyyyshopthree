<?php 
use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use \app\common\services\StaticService;


StaticService::includeAppJsStatic( '/js/web/account/index.js', app\assets\webAsset::className() )

 ?>
<?=  \Yii::$app->view->renderFile('@app/modules/web/views/common/tab_account.php');?>
<div class="row">
    <div class="col-lg-12">
        <form class="form-inline wrap_search" method="get">
            <div class="row m-t p-w-m">
                <div class="form-group">
                    <select name="status" class="form-control inline">
                        <option value="<?= ConstantMapService::$status_default ?>">请选择状态</option>
                        <?php  foreach($status_mapping as $key=> $val) {?>
                        <option value="<?= $key ?>" <?php if($key == $status ){echo 'selected';}  ?> ><?= $val ?></option>
                        <?php 
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <input type="text" name="mix_kw" placeholder="请输入姓名或者手机号码" class="form-control" value="<?= $mix_kw ?>">
                        <input type="hidden" name="p" value="1">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary search">
                                <i class="fa fa-search"></i>搜索
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-w-m btn-outline btn-primary pull-right" href="/web/account/set">
                        <i class="fa fa-plus"></i>账号
                    </a>
                </div>
            </div>
        </form>
        <table class="table table-bordered m-t">
            <thead>
            <tr>
                <th>序号</th>
                <th>姓名</th>
                <th>手机</th>
                <th>邮箱</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach( $list as $val ) {?>
            <tr>
                <td><?= $val['uid'] ?></td>
                <td><?= $val['nickname'] ?></td>
                <td><?= $val['mobile'] ?></td>
                <td><?= $val['email'] ?></td>
                <td>
                    <a href="<?= UrlService::buildWebUrl('/account/info' ,['id' => $val['uid'] ]) ?>">
                        <i class="fa fa-eye fa-lg"></i>
                    </a>
                    <a class="m-l" href="<?= UrlService::buildWebUrl('/account/set',[ 'id'=> $val['uid'] ] ); ?>">
                        <i class="fa fa-edit fa-lg"></i>
                    </a>
                <?php if( $val['status'] ){ ?>
                    <a class="m-l remove" href="javascript:void(0);" data="<?= $val['uid'] ?>">
                        <i class="fa fa-trash fa-lg"></i>
                    </a>
                    <?php }else{?>
                    <a class="m-l recover" href="javascript:void(0);" data="<?= $val['uid'] ?>">
                        <i class="fa fa-rotate-left fa-lg"></i>
                    </a>
                    <?php 
                    }
                    ?>
                </td>
            </tr>
            <?php 
            }
            ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-12">
                <span class="pagination_count" style="line-height: 40px;">共 <?= $pages['total_count']  ?>条记录 | 每页<?= $pages['page_num'] ?>条</span>
                <ul class="pagination pagination-lg pull-right" style="margin: 0 0 ;">
                    <?php for( $i = 1; $i<= $pages['total_page']; $i++ ) {?> 

                        <?php if( $pages['page'] == $i ) {?>
                    <li class="active"><a href="<?= UrlService::buildWebUrl('/account/index', [ 'page'=>$i ]); ?>"><?= $i; ?></a></li>
                        <?php }else{?>
                    <li><a href="<?= UrlService::buildWebUrl('/account/index', ['page'=> $i]);?>"><?= $i; ?></a></li>
                    <?php 
                    } }
                     ?>
                </ul>
            </div>
        </div>
    </div>
</div>

