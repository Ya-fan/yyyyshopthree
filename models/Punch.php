<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "punch".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $user_forenoon
 * @property integer $user_afternoon
 * @property integer $status
 */
class Punch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'punch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_forenoon', 'user_afternoon', 'status'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'user_forenoon' => 'User Forenoon',
            'user_afternoon' => 'User Afternoon',
            'status' => '1:正常，2:早退，3:迟到',
        ];
    }
}
