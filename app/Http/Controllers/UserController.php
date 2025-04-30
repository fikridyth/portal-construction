<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        $pageHeader = 'Index User';
        $pageTitle = 'List User';
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="' . route('users.create') . '" class="btn btn-sm btn-primary" role="button">Tambah User</a>';
        return $dataTable->render('global.datatable', compact('pageHeader', 'pageTitle', 'auth_user', 'assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageHeader = 'Tambah User';
        $roles = Role::where('status', 1)->where('name', '!=', 'system_admin')->get()->pluck('title', 'id');

        return view('users.form', compact('pageHeader', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        // dd($request->all());
        $passwordData = bcrypt($request->password);
        $usernameData = $request->username ?? stristr($request->email, "@", true) . rand(100, 1000);

        $data = [
            "username" => $usernameData,
            "first_name" => $request->first_name,
            "last_name" => $request->last_name,
            "email" => $request->email,
            "password" => $passwordData,
            "user_type" => $request->user_type,
            "phone_number" => $request->phone_number ?? null
        ];
        // dd($data);
        User::create($data);

        // storeMediaFile($user, $request->profile_image, 'profile_image');
        // $user->assignRole('user');
        // // Save user Profile data...
        // $user->userProfile()->create($request->userProfile);

        return redirect()->route('users.index')->withSuccess(__('Tambah User Berhasil', ['name' => __('users.store')]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pageHeader = 'Data User';
        $data = User::with('userProfile', 'roles')->findOrFail($id);

        $profileImage = getSingleMedia($data, 'profile_image');

        return view('users.profile', compact('pageHeader', 'data', 'profileImage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pageHeader = 'Ubah User';
        $data = User::with('userProfile', 'roles')->findOrFail($id);

        $data['user_type'] = $data->roles->pluck('id')[0] ?? null;

        $roles = Role::where('status', 1)->get()->pluck('title', 'id');

        $profileImage = getSingleMedia($data, 'profile_image');

        return view('users.form', compact('pageHeader', 'data', 'id', 'roles', 'profileImage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        // dd($request->all());
        $user = User::with('userProfile')->findOrFail($id);

        $role = Role::find($request->user_role);
        if (env('IS_DEMO')) {
            if ($role->name === 'admin' && $user->user_type === 'admin') {
                return redirect()->back()->with('error', 'Permission denied');
            }
        }
        $user->assignRole($role->name);

        $request['password'] = $request->password != '' ? bcrypt($request->password) : $user->password;

        // User user data...
        $user->fill($request->all())->update();

        // Save user image...
        if (isset($request->profile_image) && $request->profile_image != null) {
            $user->clearMediaCollection('profile_image');
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        // user profile data....
        $user->userProfile->fill($request->userProfile)->update();

        if (auth()->check()) {
            return redirect()->route('users.index')->withSuccess(__('Update User Berhasil', ['name' => __('message.user')]));
        }
        return redirect()->back()->withSuccess(__('Update User Berhasil', ['name' => 'My Profile']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $status = 'errors';
        $message = __('global-message.delete_form', ['form' => __('users.title')]);

        if ($user != '') {
            $user->delete();
            $status = 'success';
            $message = __('global-message.delete_form', ['form' => __('users.title')]);
        }

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status, $message);
    }
}
