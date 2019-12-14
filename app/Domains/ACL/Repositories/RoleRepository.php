<?php

namespace App\Domains\ACL\Repositories;

use App\Domains\ACL\Contracts\Repositories\RoleRepository as RoleRepositoryContract;
use Spatie\Permission\Models\Role;
use App\Support\Domain\Repository\Repository;
use Illuminate\Database\Eloquent\Model;

class RoleRepository extends Repository implements RoleRepositoryContract
{

    protected $modelClass = Role::class;

    protected function fillModel(Model $model, array $data = [])
    {
        parent::fillModel($model, $data);
    }

}
