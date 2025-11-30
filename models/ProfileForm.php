<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Profile form
 */
class ProfileForm extends Model
{
    public $phone;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['phone', 'string', 'max' => 20],
        ];
    }

    /**
     * Updates user profile.
     *
     * @return bool whether the update was successful
     */
    public function updateProfile()
    {
        if (!$this->validate()) {
            return false;
        }

        $user = Yii::$app->user->identity;
        $user->phone = $this->phone;

        return $user->save();
    }
}
