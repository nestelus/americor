<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property int|null $age
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string $ssn
 * @property int|null $income
 * @property int|null $fico
 * @property string email
 * @property string|null $phone
 *
 */

class Client extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%clients}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [
                [
                    'ssn',
                    'email',
                ], 'required',
            ],
            ['email', 'email'],
            [['age', 'income', 'fico'], 'number'],
            ['ssn', 'match', 'pattern' => '/^(?!666|000|9\\d{2})\\d{3}-(?!00)\\d{2}-(?!0{4})\\d{4}$/']
        ];
    }
}
