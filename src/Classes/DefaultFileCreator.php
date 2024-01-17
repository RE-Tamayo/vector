<?php

namespace Retamayo\Vector\Classes;

use Retamayo\Vector\Classes\File;
use Retamayo\Vector\Classes\PathResolver;

class DefaultFileCreator
{
    public static function createRoute() {
       File::createPath(PathResolver::getRouteDirPath());
       File::createFile(PathResolver::getRouteFilePath());
       $routes = file_get_contents(PathResolver::getPublishablePath() . '/routes.php');
       File::writeFile(PathResolver::getRouteFilePath(), $routes);
    }

    public static function createHttpResponses() {
        File::createPath(PathResolver::getHttpResponseDirPath());
        File::createFile(PathResolver::getHttpResponseFilePath(404));
        $response = file_get_contents(PathResolver::getPublishablePath() . '/http_responses/404.html');
        File::writeFile(PathResolver::getHttpResponseFilePath(404), $response);
    }
}