<?php
namespace Zwei\Base\Tests;

use Zwei\Base\DB;

/**
 * 测试数据库操作
 *
 * Class DbTest
 * @package Zwei\Base\Tests
 */
class DbTest extends BaseTestCase
{
    public function test(){
        DB::getInstance()->getConnection();
        $this->assertTrue(true);
    }

}