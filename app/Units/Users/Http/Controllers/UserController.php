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
            $user = $this->userRepository->create($data);

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

            $data = $request->all();
            unset($data['email']);
            $this->userRepository->update($user, $data);

            return response()->json($user, Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
