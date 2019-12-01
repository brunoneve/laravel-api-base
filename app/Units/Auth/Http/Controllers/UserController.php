<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;
use Modules\User\Repositories\ProfileRepository;
use Modules\User\Repositories\UserRepository;

class UserController extends Controller
{


    public function __construct()
    {
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
    }

    public function show($id)
    {
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'email'         => 'required|string|email|unique:users',
            'password'      => 'required|string|confirmed',
            'birth_date'    => 'required|date',
            'cpf'           => 'required|cpf',
            'phone'         => 'required|celular_com_ddd'
        ]);

        $user = $this->userRepository->create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        if ($user->id) {
            $profile = $this->profileRepository->create([
                'user_id'       => $user->id,
                'birth_date'    => $request->birth_date,
                'cpf'           => $request->cpf,
                'phone'         => $request->phone
            ]);
        }

        return response()->json([
            'message' => 'Usuário cadastrado com sucesso'
        ], 201);
    }

}
