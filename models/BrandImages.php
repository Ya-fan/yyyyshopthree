<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brand_images".
 *
 * @property string $id
 * @property string $image_key
 * @property string $created_time
 */
class BrandImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'brand_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_time'], 'safe'],
            [['image_key'], 'string', 'max' => 200],
            [['image_key'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image_key' => '图片地址',
            'created_time' => '插入时间',
        ];
    }
}
