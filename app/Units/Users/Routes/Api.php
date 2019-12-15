<?php

namespace App\Units\Users\Routes;

use App\Support\Http\Routing\RouteFile;

class Api extends RouteFile
{
    protected function routes()
    {
        $this->registerDefaultRoutes();
        // $this->registerV1Routes();
    }

    protected function registerDefaultRoutes()
    {
        $this->userRoutes();
    }


    protected function registerV1Routes()
    {
        $this->router->group(['prefix' => 'v1'], function () {
            $this->registerDefaultRoutes();
        });
    }

    protected function userRoutes()
    {
        $this->router->group(['prefix' => 'user', 'middleware' => ['auth:api','role:Admin']], function () {
            $this->router->get('/', 'UserController@index')->middleware('permission:user.index');
            $this->router->get('/{id}', 'UserController@show')->middleware('permission:user.show');
            $this->router->post('/', 'UserController@store')->middleware('permission:user.create');
            $this->router->put('/{id}', 'UserController@update')->middleware('permission:user.edit');
        });
    }

}
