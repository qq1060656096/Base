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
    protected $defaultFileDir = null;
    /**
     * 变量前缀,避免冲突
     * @var null
     */
    protected $defaultPrefix = null;

    /**
     * 默认配置文件路径
     *
     * @return null|string
     */
    public function getDefaultFileDir()
    {
        if (!$this->defaultFileDir)
            $this->defaultFileDir = ComposerVendor::getParentDir().'/config/';
        return $this->defaultFileDir;
    }

    /**
     * 变量前缀,避免冲突
     * @return string
     */
    public function getDefaultPrefix()
    {
        if (!$this->defaultPrefix)
            $this->defaultPrefix = 'bao-loan';
        return $this->defaultPrefix;
    }

    /**
     * 设置默认前缀
     * @param string $defaultPrefix
     */
    public function setDefaultPrefix($defaultPrefix)
    {
        $this->defaultPrefix = $defaultPrefix;
    }

    /**
     * 读取配置文件
     * @param string $name 名称
     * @param string $defaultPrefix 前缀(默认前缀: 'bao-loan')
     * @param string $fileName 文件名
     * @return mixed
     * @throws ConfigException 文件不存和键不存在都会跑出异常
     */
    public function getValue($name, $defaultPrefix, $fileName)
    {
        $this->setDefaultPrefix($defaultPrefix);

        $filePath = $this->getDefaultFileDir().$fileName;
        $defaultPrefix = $this->getDefaultPrefix();
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

    /**
     * 获取对象实例
     *
     * @return Config 数据库实例
     */
    public static function getInstance()
    {
        static $obj = null;
        if ($obj) {
            return $obj;
        }
        $obj = new Config();
        return $obj;
    }

    /**
     * 读取配置文件
     *
     * @param string $name 名称
     * @param string $defaultPrefix 前缀(默认前缀: 'bao-loan')
     * @param string $fileName 文件名(默认: bao-loan.yml)
     * @return mixed
     * @throws ConfigException 文件不存和键不存在都会跑出异常
     */
    public static function get($name, $defaultPrefix = 'bao-loan', $fileName = 'bao-loan.yml')
    {
        return self::getInstance()->getValue($name, $defaultPrefix, $fileName);
    }
}