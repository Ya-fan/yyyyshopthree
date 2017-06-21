<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pay_order_item".
 *
 * @property string $id
 * @property integer $pay_order_id
 * @property string $member_id
 * @property integer $quantity
 * @property string $price
 * @property string $discount
 * @property integer $target_type
 * @property integer $target_id
 * @property string $note
 * @property integer $status
 * @property integer $comment_status
 * @property string $updated_time
 * @property string $created_time
 */
class PayOrderItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_order_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_order_id', 'member_id', 'quantity', 'target_type', 'target_id', 'status', 'comment_status'], 'integer'],
            [['price', 'discount'], 'number'],
            [['note'], 'required'],
            [['note'], 'string'],
            [['updated_time', 'created_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pay_order_id' => '订单id',
            'member_id' => '会员id',
            'quantity' => '购买数量 默认1份',
            'price' => '商品总价格，售价 * 数量',
            'discount' => '当前折扣',
            'target_type' => '商品类型 1:书籍',
            'target_id' => '对应不同商品表的id字段',
            'note' => '备注信息',
            'status' => '状态：1：成功 0 失败',
            'comment_status' => '评价状态 1：已评价，0 ：未评价',
            'updated_time' => '最近一次更新时间',
            'created_time' => '插入时间',
        ];
    }
}
