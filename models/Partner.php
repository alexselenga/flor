<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "partners".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Order[] $orders
 */
class Partner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['email', 'name'], 'string', 'max' => 255],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['partner_id' => 'id']);
    }

    public static function getList() {
        return Partner::find()->select(['name'])->indexBy('id')->column();
    }
}
