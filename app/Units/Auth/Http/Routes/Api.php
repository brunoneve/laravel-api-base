<?php

namespace App\Units\Auth\Http\Routes;

use App\Support\Http\Routing\RouteFile;

class Api extends RouteFile
{
    protected function routes()
    {
        $this->registerDefaultRoutes();
        $this->registerV1Routes();
    }

    protected function registerDefaultRoutes()
    {
        $this->userRoutes();
        $this->loginRoutes();
        $this->signUpRoutes();
        $this->passwordRoutes();
    }


    protected function registerV1Routes()
    {
        $this->router->group(['prefix' => 'v1'], function () {
            $this->registerDefaultRoutes();
        });
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
            //$this->router->get('logout', 'AuthController@logout');
        });
    }

    protected function signUpRoutes()
    {
        $this->router->post('register', 'RegisterController@register');
    }

    protected function passwordRoutes()
    {
        $this->router->post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
        // $this->router->post('password/reset', 'ResetPasswordController@reset');
    }

}
