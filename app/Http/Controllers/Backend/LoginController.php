<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {

        return view('backend.auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login (Request $request)
    {
        try {
            $input = $request->all();
            $admin = Admin::where('email', $input['email'])->first();

            if(!$admin || $admin->password != md5($input['email'].$input['password'])) {
                return redirect()->back()->withErrors(['msg' => 'Invalid email or password'])->withInput(['email' => $request->input('email')]);
            }

            $data = [
                'admin_id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'is_head' => $admin->is_head,
                'status' => $admin->status,
            ];

            session()->put('data', $data);

            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            \Log::error("Something went wrong ", $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        session()->forget('data');

        return redirect('/webadmin');
    }
}
