<?php

namespace App\Http\Controllers\Admin\Staff;

use App\Http\Controllers\Controller;
use App\Models\AdminModel;
use App\Models\AccessRightsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    function index()
    {
        $title = "List of Staff Admin";

        $list = DB::table('admins')
            ->leftJoin('users', 'admins.user_id', '=', 'users.id')
            ->select('admins.*', 'users.name as user_name', 'users.email as user_email')
            ->where('admins.created_at', '!=', NULL)
            ->where('admins.deleted_at', '=', NULL)
            ->orderBy('admins.created_at', 'DESC')
            ->get();

        return view('/pages/admin/staff/index', [
            'title' => $title,
            'list' => $list
        ]);
    }

    function formNew()
    {
        $title = "New Staff Admin";

        return view('/pages/admin/staff/form', [
            'title' => $title
        ]);
    }

    function formEdit($id)
    {
        $title = "Edit Admin Staff";

        $detailAdmin = AdminModel::where('id', $id)->first();

        $detailUser = User::where('id', $detailAdmin['user_id'])->first();

        $detailAccess = AccessRightsModel::where('admin_id', $id)->first();

        return view('/pages/admin/staff/form', [
            'title' => $title,
            'detailAdmin' => $detailAdmin,
            'detailUser' => $detailUser,
            'detailAccess' => $detailAccess
        ]);
    }

    function create(Request $request) {

        $data = $request->all();

        $data['id'] = Uuid::uuid4()->toString();

        unset($data['_token']);

        $findEmail = User::where('email', $data['email'])->first();

        if ($findEmail) {

            $findAdmin = AdminModel::where('user_id', $findEmail['id'])->first();

            if (isset($findAdmin->deleted) && $findAdmin->deleted == 1) {
                return back()->with('failed', 'Admin account has been deleted');
            } else {
                return back()->with('failed', 'The email already registered');
            }
        }

        $newUser = [
            "id" => $data['id'],
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => bcrypt($data['password'])
        ];

        User::create($newUser);

        $adminId = Uuid::uuid4()->toString();

        $newAdmin = [
            "id" => $adminId,
            "user_id" => $data['id']
        ];

        AdminModel::create($newAdmin);

        $accessRights = [
            "id" => Uuid::uuid4()->toString(),
            "admin_id" => $adminId,
            "links" => (!isset($data['access_rights_links'])) ? 0 : $data['access_rights_links'],
            "visitors" => (!isset($data['access_rights_visitors'])) ? 0 : $data['access_rights_visitors'],
            "settings" => (!isset($data['access_rights_settings'])) ? 0 : $data['access_rights_settings'],
            "admin_staff" => (!isset($data['access_rights_admin_staff'])) ? 0 : $data['access_rights_admin_staff']
        ];

        AccessRightsModel::create($accessRights);

        session()->flash('success', 'Successfully added new staff!');

        return redirect('/admin/staff/list');
    }

    function update(Request $request) {

        $data = $request->all();

        unset($data['_token']);

        $adminId = $data['id'];
        $userId = $data['user_id'];

        $checkUser = User::where('email', $data['email'])->first();
        $checkAdmin = User::where('id', $userId )->first();

        if ($checkUser != NULL && $checkAdmin['email'] != $data['email']) {
            session()->flash('success', 'Email already exists!');
            return redirect('/admin/staff/edit/'.$adminId );
        }

        $updateUser = [
            "name" => $data['name'],
            "email" => $data['email']
        ];

        if (isset($data['password']) && $data['password'] != "") {
            $updateUser['password'] = bcrypt($data['password']);
        }

        User::where('id', $userId)->update($updateUser);

        $updateAdmin = [
            "user_id" => $userId
        ];

        AdminModel::where('id', $adminId)->update($updateAdmin);

        $accessRights = [
            "id" => Uuid::uuid4()->toString(),
            "admin_id" => $adminId,
            "links" => (!isset($data['access_rights_links'])) ? 0 : $data['access_rights_links'],
            "visitors" => (!isset($data['access_rights_visitors'])) ? 0 : $data['access_rights_visitors'],
            "settings" => (!isset($data['access_rights_settings'])) ? 0 : $data['access_rights_settings'],
            "admin_staff" => (!isset($data['access_rights_admin_staff'])) ? 0 : $data['access_rights_admin_staff']
        ];

        $checkExistAccessRights = AccessRightsModel::where('admin_id', $adminId)->first();

        if ($checkExistAccessRights == NULL) {
            AccessRightsModel::create($accessRights);
        } else {
            unset($accessRights['id']);
            unset($accessRights['admin_id']);
            AccessRightsModel::where('id', $checkExistAccessRights['id'])->update($accessRights);
        }

        session()->flash('success', 'Successful change of staff!');

        return redirect('/admin/staff/list');
    }

    function delete($id) {

        $update = [
            "deleted" => 1
        ];

        AdminModel::where('id', $id)->update($update);

        session()->flash('success', 'Admin successfully deleted!');

        return redirect('/admin/staff/list');
    }

}
