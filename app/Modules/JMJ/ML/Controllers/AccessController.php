<?php

namespace Werp\Modules\JMJ\ML\Controllers;

use Illuminate\Http\Request;
use Werp\Http\Controllers\Controller;
use Werp\Modules\JMJ\ML\Builders\LoginForm;
use Werp\Modules\JMJ\ML\Services\AccessService;

class AccessController extends Controller
{
    protected $accessService;
    protected $loginForm;

    public function __construct(LoginForm $loginForm, AccessService $accessService)
    {
        $this->accessService = $accessService;
        $this->loginForm        = $loginForm;
    }

    public function callback(Request $request)
    {
        if ($token = $request->input('access_token', false)) {
            session(['ml_access_token' => $token]);
            return redirect(route('admin.ml.login.view'));
        }

        if ($code = $request->get('code', false)) {
            $this->accessService->callback($code);
            return redirect(route('admin.ml.login.view'));
        }
    }

    public function login()
    {
        if ($this->accessService->hasNotConfig()) {
            flash(trans('Debe completar la configuración para el acceso a mercado libre'), 'error', 'error');
            return redirect(route('admin.ml.config.edit'));
        }

        $isLoggedIn = $this->accessService->isLoggedIn();
        return $this->loginForm->page($isLoggedIn);
    }

    public function logout()
    {
        $this->accessService->removeToken();
        return redirect(route('admin.ml.login.view'));
    }

    public function access()
    {
        $url = $this->accessService->getCallbackUrl();
        return redirect($url);
    }
}
