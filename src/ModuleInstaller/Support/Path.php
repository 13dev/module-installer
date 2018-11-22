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
    /**
     * @var string Path of modules
     */
    static $namespace;

    /**
     * Init class
     * @param $moduleName
     * @return Path
     */
    public static function Init($moduleName)
    {
        static::$namespace = base_path() . '/' . config('module-installer.path.namespace') . '/'. $moduleName;
        return new static;
    }

    /**
     * Get Migrations paths
     * @return string
     */
    public function migration()
    {
        return static::$namespace . '/' . config('module-installer.path.migrations');
    }

}
