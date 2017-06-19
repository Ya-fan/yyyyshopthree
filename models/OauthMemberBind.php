<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "oauth_member_bind".
 *
 * @property string $id
 * @property integer $member_id
 * @property string $client_type
 * @property integer $type
 * @property string $openid
 * @property string $unionid
 * @property string $extra
 * @property string $updated_time
 * @property string $created_time
 */
class OauthMemberBind extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'oauth_member_bind';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'type'], 'integer'],
            [['extra'], 'required'],
            [['extra'], 'string'],
            [['updated_time', 'created_time'], 'safe'],
            [['client_type'], 'string', 'max' => 20],
            [['openid'], 'string', 'max' => 80],
            [['unionid'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => '会员id',
            'client_type' => '客户端来源类型。qq,weibo,weixin',
            'type' => '类型 type 1:wechat ',
            'openid' => '第三方id',
            'unionid' => 'Unionid',
            'extra' => '额外字段',
            'updated_time' => '最后更新时间',
            'created_time' => '插入时间',
        ];
    }
}
