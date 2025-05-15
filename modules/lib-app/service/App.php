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
                deb('aw');
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
