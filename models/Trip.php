<?php
namespace app\models;
use Yii;

/**
 * This is the model class for table "{{%trip}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $desc
 * @property string $img
 * @property integer $is_stick
 */
class Trip extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%trip}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['desc'], 'string'],
            [['is_stick'], 'integer'],
            [['title'], 'string', 'max' => 45],
            ['title', 'unique','message'=>'标题存在,请重新选取哦'],
            ['img','string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'title' => '标题',
            'desc' => '简介',
            'img' => '图片',
            'is_stick' => '优先级',
        ];
    }
}
