<?php
/**
 * Authorizer
 * @package lib-app
 * @version 0.0.1
 */

namespace LibApp\Iface;

interface Authorizer
{
    public static function hasScope(string $scope): bool;

    public static function getAppId(): ?int;

    public static function getAppSecret(): ?string;
}
