<?php
use app\common\services\UrlService;
use app\common\services\ConstantMapService;
use \app\common\services\StaticService;
use \app\common\services\UtilService;

StaticService::includeAppJsStatic('/js/m/product/index.js', app\assets\MAsset::className());

?>

<div class="search_header">
    <a href="javascript:void(0);" class="category_icon"></a>
    <input name="kw" type="text" class="search_input" placeholder="请输入您搜索的关键词" value=""/>
    <i class="search_icon"></i>
</div>

<div class="sort_box">
    <ul class="sort_list clearfix">
        <li>
            <a href="javascript:void(0);" <?php if ($search_conditions['sort_field'] == 'default') { ?> class="aon"<?php } ?>
               data="default">
                <span>默认</span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" <?php if ($search_conditions['sort_field'] == 'month_count') { ?> class="aon" <?php } ?>
               data="month_count">
                <span>月销量
                    <?php if ($search_conditions['sort_field'] == 'month_count') { ?>
                        <?php if ($search_conditions['sort'] == 'asc') { ?>
                            <i class="lowly_icon"></i>
                        <?php } else { ?>
                            <i class="high_icon"></i>
                        <?php } ?>
                    <?php } else { ?>
                        <i></i>
                    <?php } ?>
                                    </span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" <?php if ($search_conditions['sort_field'] == 'view_count') { ?> class="aon" <?php } ?>
               data="view_count">
                <span>人气
                    <?php if ($search_conditions['sort_field'] == 'view_count') { ?>
                        <?php if ($search_conditions['sort'] == 'asc') { ?>
                            <i class="lowly_icon"></i>
                        <?php } else { ?>
                            <i class="high_icon"></i>
                        <?php }
                    } else { ?>
                        <i></i>
                    <?php } ?>

					                </span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" <?php if ($search_conditions['sort_field'] == 'price') { ?> class="aon" <?php } ?>
               data="price">
                <span>价格 <?php if ($search_conditions['sort_field'] == 'price') { ?>
                        <?php if ($search_conditions['sort'] == 'asc') { ?>
                            <i class="lowly_icon"> </i>
                        <?php } else { ?>
                            <i class="high_icon"></i>
                        <?php } ?>
                    <?php } else { ?>
                        <i></i>

                    <?php } ?>
					                </span>
            </a>
        </li>
    </ul>
</div>


<div class="probox">
    <ul class="prolist">
        <?php foreach ($book_info as $val) { ?>
            <li>
                <a href="<?= UrlService::buildMUrl('/product/info', ['id' => $val['id']]) ?>">
                    <i><img src="<?= $val['main_image'] ?>"
                            style="width: 100%;height: 200px;"/></i>
                    <span><?= $val['name'] ?></span>
                    <b><label>月销量<?= $val['month_count'] ?></label>¥ <?= $val['price'] ?></b>
                </a>
            </li>
        <?php } ?>

    </ul>
</div>
