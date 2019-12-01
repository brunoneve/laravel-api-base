<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'user_profile';
    protected $fillable = [
        'user_id',
        'cpf',
        'birth_date',
        'phone',
        'avatar'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
