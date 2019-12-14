<?php

namespace App\Domains\ACL\Repositories;

use App\Domains\ACL\Contracts\Repositories\PermissionRepository as PermissionRepositoryContract;
use Spatie\Permission\Models\Permission;
use App\Support\Domain\Repository\Repository;
use Illuminate\Database\Eloquent\Model;

class PermissionRepository extends Repository implements PermissionRepositoryContract
{

    protected $modelClass = Permission::class;

    protected function fillModel(Model $model, array $data = [])
    {
        parent::fillModel($model, $data);
    }

}
