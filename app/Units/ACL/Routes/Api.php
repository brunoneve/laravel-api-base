<?php

namespace App\Units\ACL\Routes;

use App\Support\Http\Routing\RouteFile;

class Api extends RouteFile
{
    protected function routes()
    {
        $this->registerDefaultRoutes();
    }

    protected function registerDefaultRoutes()
    {
        $this->roleRoutes();
        $this->permissionRoutes();
    }


    protected function registerV1Routes()
    {
        $this->router->group(['prefix' => 'v1'], function () {
            $this->registerDefaultRoutes();
        });
    }

    protected function roleRoutes()
    {
        $this->router->group(['prefix' => 'role', 'middleware' => ['auth:api','role:Admin']], function () {
            $this->router->get('', 'RoleController@index')->middleware('permission:role.index');
            $this->router->post('', 'RoleController@store')->middleware('permission:role.create');
            $this->router->get('/{id}', 'RoleController@show')->middleware('permission:role.show');
            $this->router->put('/{id}', 'RoleController@update')->middleware('permission:role.edit');
        });
    }

    public function permissionRoutes()
    {
        $this->router->group(['prefix' => 'permission', 'middleware' => ['auth:api','role:Admin']], function () {
            $this->router->get('', 'PermissionController@index')->middleware('permission:permission.index');
            $this->router->post('', 'PermissionController@store')->middleware('permission:permission.create');
            $this->router->get('/{id}', 'PermissionController@show')->middleware('permission:permission.show');
            $this->router->put('/{id}', 'PermissionController@update')->middleware('permission:permission.edit');
        });
    }
}
