<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property integer $n_id
 * @property string $n_title
 * @property string $n_desc
 * @property integer $c_id
 * @property integer $n_img
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['n_desc'], 'string'],
            [['c_id', 'n_img'], 'integer'],
            [['n_title'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'n_id' => 'N ID',
            'n_title' => '新闻标题',
            'n_desc' => '新闻描述',
            'c_id' => '新闻分类',
            'n_img' => '新闻图片',
        ];
    }
}
