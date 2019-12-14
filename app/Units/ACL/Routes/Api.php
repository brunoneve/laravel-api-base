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
        $this->router->group(['prefix' => 'role', 'middleware' => 'auth:api'], function () {
            $this->router->get('', 'RoleController@index');
            $this->router->post('', 'RoleController@store');
            $this->router->get('/{id}', 'RoleController@show');
            $this->router->put('/{id}', 'RoleController@update');
        });
    }

    public function permissionRoutes()
    {
        $this->router->group(['prefix' => 'permission', 'middleware' => 'auth:api'], function () {
            $this->router->get('/', 'PermissionController@index');

        });

    }

}
