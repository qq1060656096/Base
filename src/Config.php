<?php
namespace Zwei\Base;

use Symfony\Component\Yaml\Yaml;
use Zwei\Base\Exception\ConfigException;
use Zwei\ComposerVendorDirectory\ComposerVendor;

/**
 * 读取配置
 *
 * Class Config
 * @package Zwei\Base
 */
class Config
{
    /**
     * 默认配置文件路径
     * @var null
     */
    private static $defaultFileDir = null;
    /**
     * 变量前缀,避免冲突
     * @var null
     */
    private static $defaultPrefix = null;
    /**
     * 默认配置文件路径
     *
     * @return null|string
     */
    public static function getDefaultFileDir()
    {
        if (!self::$defaultFileDir) {}
            self::$defaultFileDir = ComposerVendor::getParentDir().'/config/';
        return self::$defaultFileDir;
    }

    /**
     * 变量前缀,避免冲突
     * @return string
     */
    public static function getDefaultPrefix()
    {
        if (!self::$defaultPrefix)
            self::$defaultPrefix = 'bao-loan';
        return self::$defaultFileDir;
    }

    /**
     * 读取配置文件
     *
     * @param string $name 名称
     * @param string $fileName 文件名(默认: bao-loan.yml)
     * @return mixed
     * @throws ConfigException 文件不存和键不存在都会跑出异常
     */
    public static function get(string $name, string $fileName = 'bao-loan.yml')
    {
        $filePath = self::getDefaultFileDir().$fileName;
        $defaultPrefix = self::getDefaultPrefix();
        if (!isset($_ENV[$defaultPrefix])) {
            if(!file_exists($filePath))
                throw new ConfigException(sprintf('%s not found', $filePath));
            $_ENV[$defaultPrefix] = Yaml::parseFile($filePath);
        }

        if (!isset($_ENV[$defaultPrefix][$name])) {
            $_ENV[$defaultPrefix] = Yaml::parseFile($filePath);
        }

        if (!isset($_ENV[$defaultPrefix][$name])) {
            throw new ConfigException(sprintf('%s undefined key:%s ', $filePath, $name));
        }
        return $_ENV[$defaultPrefix][$name];
    }
}