<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property string $id
 * @property integer $cat_id
 * @property string $name
 * @property string $price
 * @property string $main_image
 * @property string $summary
 * @property integer $stock
 * @property string $tags
 * @property integer $status
 * @property integer $month_count
 * @property integer $total_count
 * @property integer $view_count
 * @property integer $comment_count
 * @property string $updated_time
 * @property string $created_time
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'stock', 'status', 'month_count', 'total_count', 'view_count', 'comment_count'], 'integer'],
            [['price'], 'number'],
            [['updated_time', 'created_time'], 'safe'],
            [['name', 'main_image'], 'string', 'max' => 100],
            [['summary'], 'string', 'max' => 2000],
            [['tags'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cat_id' => '分类id',
            'name' => '书籍名称',
            'price' => '售卖金额',
            'main_image' => '主图',
            'summary' => '描述',
            'stock' => '库存量',
            'tags' => 'tag关键字，以\",\"连接',
            'status' => '状态 1：有效 0：无效',
            'month_count' => '月销售数量',
            'total_count' => '总销售量',
            'view_count' => '总浏览次数',
            'comment_count' => '总评论量',
            'updated_time' => '最后更新时间',
            'created_time' => '最后插入时间',
        ];
    }
}
