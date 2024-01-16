<?php

namespace Retamayo\Vector\Classes;

class PathResolver
{
    public static function getBasePath()
    {
        return dirname(dirname(dirname(dirname(__DIR__))));
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

    public static function getRouteConfigPath()
    {
        return self::getBasePath() . '/config/route_config.php';
    }
}