<?php

namespace App\Units\ACL\Http\Controllers;

use App\Support\Http\Controllers\Controller;
use App\Domains\ACL\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PermissionController extends Controller
{

    protected $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->middleware('auth');
        $this->permissionRepository = $permissionRepository;
    }

    public function index()
    {
        try {
            $permissions = $this->permissionRepository->getAll();
            return response()->json($permissions, Response::HTTP_OK);

        } catch (\Exception $e) {
            return  response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $permission = $this->permissionRepository->findId($id);

            if ($permission) {
                return response()->json($permission, Response::HTTP_OK);
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
            $permission = $this->permissionRepository->create($data);

            if ($permission) {
                return response()->json($permission, Response::HTTP_OK);
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
            $permission = $this->permissionRepository->findId($id);

            if (!$permission) {
                return response()->json(['error' => 'Registro não encontrado!'], Response::HTTP_NOT_FOUND);
            }

            $data = $request->all();
            $this->permissionRepository->update($permission, $data);

            return response()->json($permission, Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
