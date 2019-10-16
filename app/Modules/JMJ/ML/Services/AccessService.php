<?php

namespace Werp\Modules\JMJ\ML\Services;

use Werp\Modules\Core\Base\Services\BaseService;
use Werp\Modules\Core\Maintenance\Services\ConfigService;

class AccessService extends BaseService
{
    protected $mlService;
    protected $configService;
    protected $callback;

    public function __construct(ConfigService $configService, MLService $mlService)
    {
        $this->mlService = $mlService;
        $this->configService     = $configService;
        $this->callback = env('APP_URL').'/admin/ml/callback';
    }

    public function hasConfig()
    {
        return $this->configService->getValue('ml_app_id', false) &&
            $this->configService->getValue('ml_app_key', false) &&
            $this->configService->getValue('ml_app_country', false);
    }

    public function hasNotConfig()
    {
        return !$this->hasConfig();
    }

    public function getCallbackUrl()
    {
        $country = $this->configService->getValue('ml_app_country');
        return $this->mlService->getAuthUrl($this->callback, $country);
    }

    public function callback($code)
    {
        $access = $this->mlService->authorize($code, $this->callback);

        if (isset($access['body']->access_token)) {
            session(['ml_access_token' => $access['body']->access_token]);
            session(['ml_expires_in' => time() + $access['body']->expires_in]);
            session(['ml_refresh_token' => $access['body']->refresh_token]);

            $user = $this->getUser();

            session(['ml_nickname' => $user['body']->nickname ?? null]);
            session(['ml_first_name' => $user['body']->first_name ?? null]);
            session(['ml_last_name' => $user['body']->last_name ?? null]);
            session(['ml_email' => $user['body']->email ?? null]);

            /*
             array:2 [▼
              "body" => array:28 [▼
                "id" => 39975113
                "nickname" => "WILCARJOSE"
                "registration_date" => "2004-01-09T15:43:11.000-04:00"
                "first_name" => "wilcar"
                "last_name" => "angulo"
                "gender" => "M"
                "country_id" => "VE"
                "email" => "wilcarjose@gmail.com"
                "identification" => array:2 [▶]
                "internal_tags" => array:1 [▶]
                "address" => array:4 [▶]
                "phone" => array:4 [▶]
                "alternative_phone" => array:3 [▶]
                "user_type" => "normal"
                "tags" => array:3 [▶]
                "logo" => null
                "points" => 23
                "site_id" => "MLV"
                "permalink" => "http://perfil.mercadolibre.com.ve/WILCARJOSE"
                "shipping_modes" => array:2 [▶]
                "seller_experience" => "INTERMEDIATE"
                "bill_data" => array:1 [▶]
                "seller_reputation" => array:4 [▶]
                "buyer_reputation" => array:3 [▶]
                "status" => array:13 [▶]
                "secure_email" => "wangulo.3nygh3@mail.mercadolibre.com.ve"
                "credit" => array:3 [▶]
                "context" => []
              ]
              "httpCode" => 200
            ]
             * */
        }

        if(session('ml_expires_in') < time()) {
            try {
                // Make the refresh proccess
                $refresh = $this->mlService->refreshAccessToken();
                // Now we create the sessions with the new parameters
                session(['ml_access_token' => $refresh['body']->access_token]);
                session(['ml_expires_in' => time() + $refresh['body']->expires_in]);
                session(['ml_refresh_token' => $refresh['body']->refresh_token]);
            } catch (\Exception $e) {
                echo "Exception: ",  $e->getMessage(), "\n";
            }
        }
    }

    public function getUser()
    {
        $params = ['access_token' => session('ml_access_token')];
        return $this->mlService->get('/users/me', $params, false);
    }

    public function removeToken()
    {
        session()->forget('ml_access_token');
        session()->forget('ml_expires_in');
        session()->forget('ml_refresh_token');
        session()->forget('ml_nickname');
        session()->forget('ml_first_name');
        session()->forget('ml_last_name');
        session()->forget('ml_email');
    }

    public function isLoggedIn()
    {
        return session()->has('ml_access_token');
    }

    public function isNotLoggedIn()
    {
        return !$this->isLoggedIn();
    }
}
