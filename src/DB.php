<?php
namespace Zwei\Base;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Logging\DebugStack;

/**
 * Class DB 数据库类
 * @package Zwei\Base
 */
class DB extends Base
{
    /**
     * 数据库连接
     * @var \Doctrine\DBAL\Connection
     */
    protected $dbConnection = null;

    /**
     * @var \Doctrine\DBAL\Logging\SQLLogger
     */
    protected $sqlLogger = null;
    /**
     * 数据库前缀
     * @var string
     */
    protected $tablePrefix = '';

    /**
     * 私有化构造方法,防止实例化
     */
    private function __construct()
    {
        $config = new Configuration();
        $connectionParams = array(
            'host' => Config::get('DB_HOST'),
            'port' => Config::get('DB_PORT'),
            'user' => Config::get('DB_USER'),
            'password' => Config::get('DB_PASS'),
            'dbname' => Config::get('DB_NAME'),
            'driver' => 'pdo_mysql',
        );
        $this->tablePrefix = Config::get('DB_TABLE_PREFIX');
        $dbConnection = DriverManager::getConnection($connectionParams, $config);
        $this->dbConnection = $dbConnection;

        // 设置字符编码
        $dbCharset = Config::get('DB_CHARSET');
        if ($dbCharset) {
            $this->dbConnection->query("set names $dbCharset");
        }
        // 设置启用sql调试
        if (Config::get('DB_SQLLOG')) {
            $this->enabledSqlLog();
        }
    }

    /**
     * 数据库连接
     *
     * @return \Doctrine\DBAL\Connection 数据库连接
     */
    public function getConnection(): Connection
    {
        return $this->dbConnection;
    }

    /**
     * 获取表名(带前缀)
     * @param string $tableName 表名(不带表前缀)
     * @return string 表名(带前缀)
     */
    public function getTable(string $tableName): string
    {
        return $this->tablePrefix.$tableName;
    }

    /**
     * 获取DB对象实例
     *
     * @return DB 数据库实例
     */
    public static function getInstance(): DB
    {
        static $obj = null;
        if ($obj) {
            return $obj;
        }
        $obj = new DB();
        return $obj;
    }


    /**
     * 开启sql日志
     *
     * @return DebugStack
     */
    public function enabledSqlLog(): void
    {
        if (!$this->sqlLogger) {
            $this->sqlLogger = new DebugStack();
            $this->dbConnection->getConfiguration()->setSQLLogger($this->sqlLogger);
        }
    }

    /**
     * 获取最后执行sql
     *
     * @see \Zwei\Base\DB::enabledSqlLog()
     * @return array
     */
    public function getLastRawSql(): array
    {
        if (!$this->logger) {

        }
        if(!isset($this->logger->queries[$this->logger->currentQuery])){
            $rawSql['msg']           = 'queries 没有数据';
            return $rawSql;
        }
        $rawSql = $this->logger->queries[$this->logger->currentQuery];
        $tmp['currentQuery'] = $rawSql;
        $query      = $tmp['currentQuery'];
        $tmp_sql    = $query['sql'];
        $tmp_params = $query['params'];
        count($tmp_params) < 1 ? $tmp_params = [] : null;
        foreach ($tmp_params as $key => $value) {
            if ($value === null) {
                $tmp_sql = preg_replace('/\?/', "NULL", $tmp_sql, 1);
            } else {
                $tmp_sql = preg_replace('/\?/', "'{$value}'", $tmp_sql, 1);
            }

        }
        $tmp['rawSql'] = $tmp_sql;
        return $tmp;
    }

}