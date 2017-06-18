<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "app_access_log".
 *
 * @property integer $id
 * @property string $uid
 * @property string $referer_url
 * @property string $target_url
 * @property string $query_params
 * @property string $ua
 * @property string $ip
 * @property string $note
 * @property string $created_time
 */
class AppAccessLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'app_access_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid'], 'integer'],
            [['query_params'], 'required'],
            [['query_params'], 'string'],
            [['created_time'], 'safe'],
            [['referer_url', 'target_url', 'ua'], 'string', 'max' => 255],
            [['ip'], 'string', 'max' => 32],
            [['note'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'uid',
            'referer_url' => '当前访问的refer',
            'target_url' => '访问的url',
            'query_params' => 'get和post参数',
            'ua' => '访问ua',
            'ip' => '访问ip',
            'note' => 'json格式备注字段',
            'created_time' => 'Created Time',
        ];
    }
}
