<?php

namespace App\Units\Users\Http\Controllers;

use App\Domains\Users\Repositories\UserRepository;
use App\Support\Http\Controllers\Controller;
use App\Units\Users\Http\Requests\CreateUserRequest;
use App\Units\Users\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('auth');
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        try {
            $users = $this->userRepository->getAll();
            return response()->json($users, Response::HTTP_OK);

        } catch (\Exception $e) {
            return  response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $user = $this->userRepository->findId($id);
            return response()->json($user, Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(CreateUserRequest $request)
    {
        try {
            $data = $request->all();
            $roles = $request['roles']; //Retrieving the roles field
            $user = $this->userRepository->create($data);

            //Checking if a role was selected
            /*if (isset($roles)) {

                foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r); //Assigning role to user
                }
            }*/

            if ($user) {
                return response()->json($user, Response::HTTP_OK);
            }

            return response()->json('Ocorreu um error interno', Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update($id, UpdateUserRequest $request)
    {
        try {
            $user = $this->userRepository->findId($id);

            if (!$user) {
                return response()->json(['error' => 'Usuário não encontrado!'], Response::HTTP_NOT_FOUND);
            }

            $data = $request->only(['name', 'password', 'birth_date', 'cpf', 'phone']);
            $role = $request['role'];
            $this->userRepository->update($user, $data);

            if (isset($role)) {
                $user->roles()->sync($role);  //If one or more role is selected associate user to roles
            }
            else {
                $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
            }

            return response()->json($user, Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
