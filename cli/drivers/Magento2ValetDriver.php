<?php

class Magento2ValetDriver extends ValetDriver
{

    /**
     * Determine if the driver serves the request.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return bool
     */
    public function serves($sitePath, $siteName, $uri)
    {
        return file_exists($sitePath.'/pub/index.php') &&
        file_exists($sitePath.'/bin/magento');
    }

    /**
     * Determine if the incoming request is for a static file.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string|false
     */
    public function isStaticFile($sitePath, $siteName, $uri)
    {
        if (file_exists($staticFilePath = $sitePath.'/pub'.$uri)) {
            return $staticFilePath;
        }

        if (strpos($uri, '/static/') === 0) {
            $_GET['resource'] = substr($uri, strpos($uri, '/', 1) );
            include($sitePath.DIRECTORY_SEPARATOR.'pub/static.php');
            exit;
        }

        if (strpos($uri, '/media/') === 0) {
            include($sitePath.DIRECTORY_SEPARATOR.'pub/get.php');
            exit;
        }

        return false;
    }

    /**
     * Get the fully resolved path to the application's front controller.
     *
     * @param  string  $sitePath
     * @param  string  $siteName
     * @param  string  $uri
     * @return string
     */
    public function frontControllerPath($sitePath, $siteName, $uri)
    {
        return $sitePath.'/pub/index.php';
    }
}
