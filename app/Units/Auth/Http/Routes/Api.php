<?php

namespace App\Units\Auth\Http\Routes;

use App\Support\Http\Routing\RouteFile;

class Api extends RouteFile
{
    protected function routes()
    {
        $this->userRoutes();
        $this->loginRoutes();
    }

    protected function userRoutes()
    {
        $this->router->get('/', function () {
            return [1=>2];
        });

        $this->router->group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {

        });

    }

    protected function loginRoutes()
    {
        $this->router->post('login', 'LoginController@login');
        $this->router->group(['prefix' => 'auth', 'middleware' => 'auth:api'], function () {
            $this->router->get('me', 'LoginController@me');
            $this->router->get('logout', 'AuthController@logout');
        });
    }
}
