<?php

namespace Retamayo\Vector\Classes;

class PathResolver
{
    public static function getBasePath()
    {
        return dirname(dirname(dirname(dirname(dirname(__DIR__)))));
    }

    public static function getLibPath()
    {
        return dirname(__DIR__);
    }

    public static function getRouteDirPath()
    {
        return self::getBasePath() . '/routes';
    }

    public static function getRouteFilePath()
    {
        return self::getBasePath() . '/routes/routes.php';
    }

    public static function getConfigDirPath()
    {
        return self::getBasePath() . '/config';
    }

    public static function getHttpResponseDirPath()
    {
        return self::getBasePath() . '/config/http_responses';
    }

    public static function getHttpResponseFilePath($code)
    {
        return self::getBasePath() . '/config/http_responses/' . $code . '.html';
    }

    public static function getRouteConfigPath()
    {
        return self::getBasePath() . '/config/route_config.php';
    }

    public static function getPublishablePath()
    {
        return self::getLibPath() . '/Publishable';
    }
}