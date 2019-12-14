<?php

namespace App\Units\ACL\Http\Controllers;

use App\Support\Http\Controllers\Controller;
use App\Domains\ACL\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class RoleController extends Controller
{
    protected $roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->middleware('auth');
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        try {
            $roles = $this->roleRepository->getAll();
            return response()->json($roles, Response::HTTP_OK);

        } catch (\Exception $e) {
            return  response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $role = $this->roleRepository->findId($id);

            if ($role) {
                return response()->json($role, Response::HTTP_OK);
            }

            return response()->json(['error' => 'Registro não encontrado!'], Response::HTTP_NOT_FOUND);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $role = $this->roleRepository->create($data);

            if ($role) {
                return response()->json($role, Response::HTTP_OK);
            }

            return response()->json('Ocorreu um error interno', Response::HTTP_INTERNAL_SERVER_ERROR);


        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update($id, Request $request)
    {
        try {

            $role = $this->roleRepository->findId($id);

            if (!$role) {
                return response()->json(['error' => 'Registro não encontrado!'], Response::HTTP_NOT_FOUND);
            }

            $data = $request->all();
            $this->roleRepository->update($role, $data);

            return response()->json($role, Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
