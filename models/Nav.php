<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nav".
 *
 * @property integer $nav_id
 * @property string $nav_name
 * @property string $nav_url
 * @property integer $is_new
 * @property string $position
 * @property integer $font_size
 * @property integer $font_bold
 * @property string $font_color
 * @property string $nav_color
 */
class Nav extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nav';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'font_size', 'font_bold'], 'integer'],
            [[ 'position', 'font_color', 'nav_color'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'nav_id' => 'Nav ID',
            'nav_name' => 'Nav Name',
            'position' => 'Position',
            'font_size' => 'Font Size',
            'font_bold' => 'Font Bold',
            'font_color' => 'Font Color',
            'nav_color' => 'Nav Color',
        ];
    }
}
