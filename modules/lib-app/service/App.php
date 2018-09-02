<?php
/**
 * App
 * @package lib-app
 * @version 0.0.1
 */

namespace LibApp\Service;

use LibApp\Model\App as _App;

class App extends \Mim\Service
{

    private $app;

    public function __construct(){
        $authorizer = \Mim::$app->user->getAuthorizer();
        if(!$authorizer)
            return;

        if(!is_subclass_of($authorizer, 'LibApp\\Iface\\Authorizer'))
            return;

        $session = \Mim::$app->user->getSession();
        if(!isset($session->app))
            return;

        $app = _App::getOne(['id'=>$session->app]);
        if($app)
            $this->app = $app;
    }

    public function __get($name) {
        if(!$this->app)
            return null;
        return $this->app->$name ?? null;
    }

    public function isAuthorized(): bool {
        return !!$this->app;
    }

    public function revoke(): void{
        $authorizer = \Mim::$app->user->getAuthorizer();
        if($authorizer)
            $authorizer::logout();
    }

    public function hasScope(string $scope): bool{
        $authorizer = \Mim::$app->user->getAuthorizer();
        if($authorizer)
            return $authorizer::hasScope($scope);
        return false;
    }
}