<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $fio
 * @property string $phone
 * @property string $email
 * @property string $login
 * @property string $password
 * @property int $id_role
 * @property string $driver
 *
 * @property Request[] $requests
 * @property Role $role
 */
class RegForm extends User
{
    public $passwordConfirm;
    public $agree;

    public function rules()
    {
        return [
            [['fio', 'phone', 'email', 'login', 'password', 'driver', 'passwordConfirm', 'agree'], 'required'],
            [['id_role'], 'integer'],
            [['fio', 'phone', 'email', 'login', 'password', 'driver'], 'string', 'max' => 255],
            [['login'], 'unique', 'message' => 'Такой логин уже есть'],
            [['id_role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['id_role' => 'id']],

            ['email', 'email', 'message' => 'Некорректная почта'],
            ['fio', 'match', 'pattern' => '/^[А-Яа-я\s]{1,}$/u', 'message' => 'символы кириллицы и пробелы'],
            ['login', 'match', 'pattern' => '/^[A-Za-z0-9]{1,}$/u', 'message' => 'символы Латиница и цифры'],
            ['passwordConfirm', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать'],
            ['agree', 'boolean'],
            ['agree', 'compare', 'compareValue' => true, 'message' => 'Необходимо дать согласие'],
            ['password', 'string', 'min' => 8],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'ФИО',
            'phone' => 'Телефон',
            'email' => 'Email',
            'login' => 'Логин',
            'password' => 'Пароль',
            'passwordConfirm' => 'Повторите пароль',
            'agree' => 'Дать согласие',
            'id_role' => 'Id Role',
            'driver' => 'Водительские права',
        ];
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::class, ['id_user' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'id_role']);
    }









    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    public static function findByUsername($username)
    {
        return self::find()->where(['login' => $username])->one();
    }

    public function getId()
    {
        return $this->id;
    }


    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey)
    {
        return null;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
