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

        /*$this->router->group(['prefix' => 'user', 'middleware' => 'auth:api'], function () {
            $this->router->get('/', 'UserController@index');
            $this->router->get('/{id}', 'UserController@show');
            $this->router->post('/', 'UserController@store');
        });

        $this->router->group(['prefix' => 'auth'], function () {

            $this->router->post('login', 'AuthController@login');
            $this->router->post('signup', 'UserController@store');

            $this->router->group(['middleware' => 'auth:api'], function() {

                $this->router->get('logout', 'AuthController@logout');
                $this->router->get('user', 'UserController@user');
            });
        });*/
    }

    protected function loginRoutes()
    {
        $this->router->post('login', 'LoginController@login');
    }
}
