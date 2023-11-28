<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model implements Authenticatable
{
    use Notifiable;
    protected $table = "users";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $timestamps = true;
    public $incrementing = true;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address'
    ];


    /**
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'email';
    }

    /**
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getRememberToken()
    {
        return $this->token;
    }

    /**
     * @param $value
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->token = $value;
    }

    /**
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'token';
    }
}
