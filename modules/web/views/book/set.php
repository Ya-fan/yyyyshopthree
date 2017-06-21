<?php 
use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use \app\common\services\StaticService;


StaticService::includeAppJsStatic( "/web/plugins/ueditor/ueditor.config.js",\app\assets\WebAsset::className() );
StaticService::includeAppJsStatic( "/web/plugins/ueditor/ueditor.all.min.js",\app\assets\WebAsset::className() );
StaticService::includeAppJsStatic( "/web/plugins/ueditor/lang/zh-cn/zh-cn.js",\app\assets\WebAsset::className() );

StaticService::includeAppCssStatic( "/web/plugins/tagsinput/jquery.tagsinput.min.css",\app\assets\WebAsset::className() );
StaticService::includeAppJsStatic( "/web/plugins/tagsinput/jquery.tagsinput.min.js",\app\assets\WebAsset::className() );

StaticService::includeAppCssStatic( "/web/plugins/select2/select2.css",\app\assets\WebAsset::className() );
StaticService::includeAppJsStatic( "/web/plugins/select2/select2.pinyin.js",\app\assets\WebAsset::className() );
StaticService::includeAppJsStatic( "/web/plugins/select2/zh-CN.js",\app\assets\WebAsset::className() );
StaticService::includeAppJsStatic( "/web/plugins/select2/pinyin.core.js",\app\assets\WebAsset::className() );

StaticService::includeAppJsStatic( '/js/web/book/set.js', app\assets\WebAsset::className() )
?>
<?=  \Yii::$app->view->renderFile('@app/modules/web/views/common/tab_book.php' ,['current'=>'set']);?>

<div class="row mg-t20 wrap_book_set">
    <div class="col-lg-12">
        <h2 class="text-center">图书设置</h2>
        <div class="form-horizontal m-t">
            <div class="form-group">
                <label class="col-lg-2 control-label">图书分类:</label>
                <div class="col-lg-10">
                    <select name="cat_id" class="form-control">
                        <option value="-1">请选择分类</option>
                         <?php foreach( $car_info as $key=>$val ) {?>
                        <option value="<?= $val['id'] ?>" <?php if( $book_info['status'] == $val['id'] ) {echo 'selected';}?>><?= $val['name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书名称:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入图书名" name="name" value="<?= $book_info['name'] ?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书价格:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" placeholder="请输入图书售价" name="price" value="<?= $book_info['price'] ?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">封面图:</label>
                <div class="col-lg-10">
                    <form class="upload_pic_wrap" target="upload_file" enctype="multipart/form-data" method="POST"
                          action="<?= UrlService::buildWebUrl('/upload/pic'); ?>">
                        <div class="upload_wrap pull-left">
                            <i class="fa fa-upload fa-2x"></i>
                            <input type="hidden" name="bucket" value="book"/>
                            <input type="file" name="pic" accept="image/png, image/jpeg, image/jpg,image/gif">
                        </div>
                        <?php if( isset( $book_info['main_image']) && $book_info['main_image'] ) {?>
                        <span class="pic-each">
                            <img src="<?= UrlService::buildImgUrl('book',$book_info['main_image']) ?>"><span class="fa fa-times-circle del del_image" data="<?= $book_info['main_image'] ?>"><i></i></span>
                        </span>
                        <?php } ?>
                    </form>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书描述:</label>
                <div class="col-lg-8">
                    <textarea id="editor" name="summary" style="height: 300px;"><?= $book_info['summary'] ?></textarea>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">库存:</label>
                <div class="col-lg-2">
                    <div class="input-group">
                        <div class="input-group-addon hidden">
                            <a class="disabled" href="javascript:void(0);">
                                <i class="fa fa-minus"></i>
                            </a>
                        </div>
                        <input type="text" name="stock" class="form-control" value="<?= $book_info['stock'] ?>">
                        <div class="input-group-addon hidden">
                            <a href="javascript:void(0);">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <label class="col-lg-2 control-label">图书标签:</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="tags" value="<?= $book_info['tags'] ?>">
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-lg-4 col-lg-offset-2">
                    <input type="hidden" name="id" value="<?= $book_info['id'] ?>">
                    <button class="btn btn-w-m btn-outline btn-primary save">保存</button>
                </div>
            </div>
        </div>
    </div>
</div>
<iframe src="" frameborder="0" class="hide" name="upload_file">
    
    
</iframe>