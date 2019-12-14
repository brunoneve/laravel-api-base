<?php

namespace App\Units\ACL\Http\Controllers;

use App\Support\Http\Controllers\Controller;
use App\Domains\ACL\Repositories\RoleRepository;
use App\Domains\ACL\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class RoleController extends Controller
{
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->middleware('auth');
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
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
            $this->validate($request, [
                'name'=>'required|unique:roles|max:20',
                'permissions' =>'required',
            ]);

            $data = $request->except(['permissions']);
            $permissions = $request['permissions'];
            $role = $this->roleRepository->create($data);

            foreach ($permissions as $permission) {
                $p = $this->permissionRepository->findId($permission);
                $role->givePermissionTo($p);
            }

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

            $this->validate($request, [
                'name' => 'required|max:20|unique:roles,name,'.$id,
                'permissions' => 'required',
            ]);

            $data = $request->except(['permissions']);
            $perms = $request['permissions'];
            $this->roleRepository->update($role, $data);

            $permissions = $this->permissionRepository->getAll(0,false); //All permissions

            foreach ($permissions as $p) {
                $role->revokePermissionTo($p); //Remove all permissions associated with role
            }

            foreach ($perms as $perm) {
                $p = $this->permissionRepository->findId($perm); //Get corresponding form //permission in db
                $role->givePermissionTo($p);  //Assign permission to role
            }

            return response()->json($role, Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
