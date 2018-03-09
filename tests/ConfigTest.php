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
    public function test(){
        $this->assertTrue(\Zwei\Base\Config::get('BASE_TEST_CONFIG') === 'base_test_config');
    }
}