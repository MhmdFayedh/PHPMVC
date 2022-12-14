<?php

namespace app\model;

use app\core\Model;
use app\core\DBModel;
use app\core\UserModel;

class User extends UserModel
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    public string $name = "";
    public string $email = "";
    public int $status = self::STATUS_INACTIVE;
    public string $password = "";
    public string $repassword = "";

    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function rules(): array
    {
        return [
            "name" => [self::RULE_REQUIRED],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 
            'class' => self::class 
            ]],
            "password" => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 25]],
            "repassword" => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]

        ];
    }

    public static function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function attribute(): array
    {
        return ['name', 'email', 'password', 'status'];
    }

    public function labels(): array
    {
        return [
            'name' => 'Full Name',
            'email' => 'Email',
            'password' => "Password",
            'repassword' => "Confirm Password ",

        ];
    }

    public function getUserName(): string
    {
        return $this->name;
    }
}