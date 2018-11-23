<?php
/**
 * Created by PhpStorm.
 * User: tc24
 * Date: 22/11/2018
 * Time: 17:32
 */

namespace Dev13\ModuleInstaller\Support;

/**
 * Class Path
 * @package Dev13\ModuleInstaller\Support
 */
class Path
{

    private static $path;

    private static $_instance = null;

    private function __construct() {
        self::$path = base_path() . '/' . config('module-installer.path.namespace');
    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * @param $moduleName
     * @return $this
     */
    public function setModule($moduleName)
    {
        self::$path .= '/' . $moduleName;
        return $this;
    }

    /**
     * Get Migrations paths
     * @return $this
     */
    public function getMigrationPath()
    {
       self::$path  .= '/' . config('module-installer.path.migrations');
       return $this;
    }

    /**
     * @param $filename
     * @return string
     */
    public function withFile($filename)
    {
        return self::$path .= '/' . $filename;
    }

}
