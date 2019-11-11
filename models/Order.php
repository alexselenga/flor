<?php

namespace app\models;

use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "orders".
 *
 * @property int $id
 * @property int $status
 * @property string $client_email
 * @property int $partner_id
 * @property string $delivery_dt
 * @property string $created_at
 * @property string $updated_at
 *
 * @property OrderProduct[] $orderProducts
 * @property Partner $partner
 *
 * @property string $partnerName
 */
class Order extends \yii\db\ActiveRecord
{
    public $partnerName;

    const STATUS_NEW = 0;
    const STATUS_COMMIT = 10;
    const STATUS_DONE = 20;

    const STATUSES = [
        self::STATUS_NEW => 'новый',
        self::STATUS_COMMIT => 'подтвержден',
        self::STATUS_DONE => 'завершен'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'client_email', 'partner_id', 'delivery_dt'], 'required'],
            ['client_email', 'email'],
            [['status', 'partner_id'], 'integer'],
            [['delivery_dt', 'created_at', 'updated_at'], 'safe'],
            ['client_email', 'string', 'max' => 255],
            ['partner_id', 'exist', 'skipOnError' => true, 'targetClass' => Partner::className(), 'targetAttribute' => ['partner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Статус',
            'client_email' => 'E-mail клиента',
            'partner_id' => 'Партнер',
            'delivery_dt' => 'Delivery Dt',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'partnerName' => 'Партнер',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderProducts()
    {
        return $this->hasMany(OrderProduct::className(), ['order_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartner()
    {
        return $this->hasOne(Partner::className(), ['id' => 'partner_id']);
    }

    public function getOrderContent($delimiter = ', ') {
        $orderProductList = [];

        foreach ($this->orderProducts as $orderProduct) {
            $productName = HTML::encode($orderProduct->product->name);
            $quantity = $orderProduct->quantity;
            $orderProductList[] = "$productName ($quantity шт.)";
        }

        return implode($delimiter, $orderProductList);
    }

    public function getOrderCost() {
        $cost = 0;

        foreach ($this->orderProducts as $orderProduct) {
            $cost += $orderProduct->price * $orderProduct->quantity;
        }

        return "$cost руб.";
    }
}
