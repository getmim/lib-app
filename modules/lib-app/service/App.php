<?php
/**
 * App
 * @package lib-app
 * @version 1.0.2
 */

namespace LibApp\Service;

use LibApp\Model\App as _App;

class App extends \Mim\Service
{

    private $app;
    private $authorizer;

    public function __construct()
    {
        $auths = \Mim::$app->config->libApp->authorizer;
        foreach ($auths as $mod => $serv) {
            $services = \Mim::$app->config->service;

            if (isset($services->{$serv})) {
                $authorizer = \Mim::$app->{$serv}->getAuthorizer();
                if (!$authorizer) {
                    continue;
                }
            }

            $authorizer = $serv;
            if (!is_subclass_of($authorizer, 'LibApp\\Iface\\Authorizer')) {
                continue;
            }

            $app_id = $authorizer::getAppId();
            if (!$app_id) {
                continue;
            }

            $app = _App::getOne(['id'=>$app_id]);
            if ($app) {
                $this->app = $app;
            }

            $this->authorizer = $authorizer;
        }
    }

    public function __get($name)
    {
        if (!$this->app) {
            return null;
        }

        return $this->app->$name ?? null;
    }

    public function isAuthorized(): bool
    {
        return !!$this->app;
    }

    public function isSigned(string $format): bool
    {
        $req = &\Mim::$app->req;
        $timestamp = $req->getServer('HTTP_X_TIMESTAMP');
        $client_signature = $req->getServer('HTTP_X_SIGNATURE');
        if (!$client_signature || !$timestamp) {
            return false;
        }

        $fields = explode(':', $format);
        $values = [];

        foreach ($fields as $field) {
            if ($field == 'timestamp') {
                $values[] = $timestamp;
            } else {
                $value = $req->getBody($field);
                if (is_null($value)) {
                    $value = $req->getPost($field);
                }
                if (is_null($value)) {
                    $value = $req->getQuery($field);
                }
                $values[] = $value;
            }
        }

        $payload = implode(':', $values);
        $authorizer = $this->authorizer;
        $secret = $authorizer::getAppSecret();
        $serv_signature = hash_hmac('sha256', $payload, $secret);

        return $client_signature == $serv_signature;
    }

    public function revoke(): void
    {
        $authorizer = $this->authorizer;
        if ($authorizer) {
            $authorizer::logout();
        }
    }

    public function hasScope(string $scope): bool
    {
        $authorizer = $this->authorizer;
        if ($authorizer) {
            return $authorizer::hasScope($scope);
        }

        return false;
    }
}
