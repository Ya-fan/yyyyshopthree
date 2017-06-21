<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book_stock_change_log".
 *
 * @property string $id
 * @property integer $book_id
 * @property integer $unit
 * @property integer $total_stock
 * @property string $note
 * @property string $created_time
 */
class BookStockChangeLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book_stock_change_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['book_id'], 'required'],
            [['book_id', 'unit', 'total_stock'], 'integer'],
            [['created_time'], 'safe'],
            [['note'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'book_id' => '书籍商品id',
            'unit' => '变更多少',
            'total_stock' => '变更之后总量',
            'note' => '备注字段',
            'created_time' => '插入时间',
        ];
    }
}
