<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_order".
 *
 * @property string $id
 * @property string $order_sn
 * @property string $member_id
 * @property integer $target_type
 * @property integer $pay_type
 * @property integer $pay_source
 * @property string $total_price
 * @property string $discount
 * @property string $pay_price
 * @property string $pay_in_money
 * @property double $ratio
 * @property string $pay_sn
 * @property string $note
 * @property integer $status
 * @property integer $express_status
 * @property integer $express_address_id
 * @property string $express_info
 * @property integer $comment_status
 * @property string $pay_time
 * @property string $updated_time
 * @property string $created_time
 */
class PayOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_id', 'target_type', 'pay_type', 'pay_source', 'status', 'express_status', 'express_address_id', 'comment_status'], 'integer'],
            [['total_price', 'discount', 'pay_price', 'pay_in_money', 'ratio'], 'number'],
            [['note'], 'required'],
            [['note'], 'string'],
            [['pay_time', 'updated_time', 'created_time'], 'safe'],
            [['order_sn'], 'string', 'max' => 40],
            [['pay_sn'], 'string', 'max' => 128],
            [['express_info'], 'string', 'max' => 100],
            [['order_sn'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_sn' => '随机订单号',
            'member_id' => '会员id',
            'target_type' => '商品类型 1:书籍',
            'pay_type' => '1:微信 2：支付宝 3：银行转账 4: 现金 5:其他 6:刷卡',
            'pay_source' => '下单来源:1:PC 2:m',
            'total_price' => '订单应付金额',
            'discount' => '优惠金额',
            'pay_price' => '订单实付金额',
            'pay_in_money' => '扣点后的所得金额',
            'ratio' => '所扣点数',
            'pay_sn' => '第三方流水号',
            'note' => '备注信息',
            'status' => '1：支付完成 0 无效 -1 申请退款 -2 退款中 -9 退款成功  -8 待支付  -7 完成支付待确认',
            'express_status' => '快递状态，-8 待支付 -7 已付款待发货 1：确认收货 0：失败',
            'express_address_id' => '快递地址id',
            'express_info' => '快递单新',
            'comment_status' => '评论状态',
            'pay_time' => '付款到账时间',
            'updated_time' => '最近一次更新时间',
            'created_time' => '插入时间',
        ];
    }
}
