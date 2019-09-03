<?php

namespace Werp\Http\Controllers\AdminAuth;

use Werp\Admin;
use Werp\Http\Controllers\Controller;

class ImpersonateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function impersonate($id)
    {
        $user = Admin::find($id);
        \Auth::user()->impersonate($user);

        return redirect(route('admin.home'));
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function leaveImpersonation()
    {
        \Auth::user()->leaveImpersonation();

        return redirect(route('admin.home'));
    }
}
