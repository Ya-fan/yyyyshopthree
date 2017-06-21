<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_order_callback_data".
 *
 * @property integer $id
 * @property integer $pay_order_id
 * @property string $pay_data
 * @property string $refund_data
 * @property string $updated_time
 * @property string $created_time
 */
class PayOrderCallbackData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_order_callback_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_order_id'], 'integer'],
            [['pay_data', 'refund_data'], 'required'],
            [['pay_data', 'refund_data'], 'string'],
            [['updated_time', 'created_time'], 'safe'],
            [['pay_order_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_order_id' => '支付订单id',
            'pay_data' => '支付回调信息',
            'refund_data' => '退款回调信息',
            'updated_time' => '最后一次更新时间',
            'created_time' => '创建时间',
        ];
    }
}
