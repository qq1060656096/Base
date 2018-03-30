<?php
namespace Zwei\Base\Tests;



/**
 * 测试读取配置
 *
 * Class ConfigTest
 * @package Zwei\Base\Tests
 */
class ConfigTest extends BaseTestCase
{
    /**
     * 测试读取默认配置
     */
    public function test(){
        $this->assertTrue(\Zwei\Base\Config::get('BASE_TEST_CONFIG') === 'base_test_config');
        $this->assertTrue(isset($_ENV['bao-loan']));
    }

    /**
     * 测试读取新配置
     */
    public function testNewConfigFile()
    {
        $this->assertTrue(\Zwei\Base\Config::get('test-new-prefix-key', 'test-new-prefix', 'test-new-prefix.conf.yml') === 'new-prefix-value');
        $this->assertTrue(isset($_ENV['test-new-prefix']));
    }
}