<?php

namespace App\Domains\Users\Repositories;

use App\Domains\Users\Contracts\Repositories\UserRepository as UserRepositoryContract;
use App\Domains\Users\User;
use App\Support\Domain\Repository\Repository;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends Repository implements UserRepositoryContract
{

    protected $modelClass = User::class;

    protected function fillModel(Model $model, array $data = [])
    {
        if (array_key_exists('password', $data)) {
            $data['password'] = bcrypt($data['password']);
        }

        parent::fillModel($model, $data);
    }

}
