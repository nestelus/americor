<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $title
 * @property string $number
 * @property int $term
 * @property float $rate
 * @property float $amount
 * @property bool $status
 * @property int $client_id
 *
 */
class Loan extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%loans}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'title',
                    'number',
                    'client_id',
                ], 'required',
            ],
            [[ 'rate', 'amount'], 'number'],
            [['status', 'term',], 'integer'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getOwner(): ActiveQuery
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }
}
