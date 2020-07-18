<?php
/**
 * @copyright 2019-2020 Dicr http://dicr.org
 * @author Igor A Tarasov <develop@dicr.org>
 * @license MIT
 * @version 19.07.20 00:07:05
 */

/** @noinspection PhpUnused */
declare(strict_types = 1);

/** https://www.php.net/manual/ru/mysql.constants.php */
defined('MYSQL_ASSOC') || define('MYSQL_ASSOC', MYSQLI_ASSOC);
defined('MYSQL_BOTH') || define('MYSQL_BOTH', MYSQLI_BOTH);
defined('MYSQL_NUM') || define('MYSQL_NUM', MYSQLI_NUM);

// переопределяем только если Mysql не найден
if (! function_exists('mysql_connect')) {
    /**
     * Class mysql
     *
     * @link https://www.php.net/manual/ru/ref.mysql.php
     */
    class mysql extends mysqli
    {
        /** @var self|null */
        public static $link;

        /**
         * @inheritDoc
         */
        public function __construct(
            $host = null,
            $user = null,
            $pass = null,
            $dbname = null,
            $port = null,
            $socket = null)
        {
            parent::__construct($host, $user, $pass, $dbname, $port, $socket);

            self::$link = $this;
        }
    }

    /**
     * @param string $server
     * @param string $username
     * @param string $password
     * @return mysql
     */
    function mysql_connect($server = null, $username = null, $password = null)
    {
        return new mysql($server, $username, $password);
    }

    /**
     * @param mysql $link
     * @return int
     */
    function mysql_affected_rows($link = null)
    {
        return mysqli_affected_rows($link ?: mysql::$link);
    }

    /**
     * @param mysql $link
     * @return bool
     */
    function mysql_close($link = null)
    {
        return mysqli_close($link ?: mysql::$link);
    }

    /**
     * @param mysql $link
     * @return int
     */
    function mysql_errno($link = null)
    {
        return mysqli_errno($link ?: mysql::$link);
    }

    /**
     * @param mysql $link
     * @return string
     */
    function mysql_error($link = null)
    {
        return mysqli_error($link ?: mysql::$link);
    }

    /**
     * @param $string
     * @return string
     */
    function mysql_escape_string($string)
    {
        return mysqli_real_escape_string(mysql::$link, $string);
    }

    /**
     * @param mysqli_result $result
     * @param int|string $result_type
     * @return array|null
     */
    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH)
    {
        if (is_string($result_type)) {
            $result_type = constant(str_replace('MYSQL_', 'MYSQLI_', $result_type));
        }

        return mysqli_fetch_array($result, $result_type);
    }

    /**
     * @param mysqli_result $result
     * @return array|null
     */
    function mysql_fetch_row($result)
    {
        return mysqli_fetch_row($result);
    }

    /**
     * @param mysqli_result $result
     * @return string[]|null
     */
    function mysql_fetch_assoc($result)
    {
        return mysqli_fetch_assoc($result);
    }

    /**
     * @param mysqli_result $result
     * @param int $field_offset
     * @return object|false
     */
    function mysql_fetch_field($result, $field_offset = 0)
    {
        return mysqli_fetch_field($result);
    }

    /**
     * @param mysqli_result $result
     * @param string $class_name
     * @param array $params
     * @return object|null
     */
    function mysql_fetch_object($result, $class_name = null, $params = null)
    {
        if (! empty($class_name) && ! empty($params)) {
            return mysqli_fetch_object($result, $class_name, $params);
        }
        if (! empty($class_name)) {
            return mysqli_fetch_object($result, $class_name);
        }
        return mysqli_fetch_object($result);
    }

    /**
     * @param mysqli_result $result
     * @return int
     */
    function mysql_num_fields($result)
    {
        return mysqli_num_fields($result);
    }

    /**
     * @param mysqli_result $result
     * @param int $field_offset
     * @return string|null
     */
    function mysql_field_name($result, $field_offset)
    {
        $obj = mysqli_fetch_field_direct($result, (int)$field_offset);
        return is_object($obj) && isset($obj->name) ? $obj->name : null;
    }

    /**
     * @param mysqli_result $result
     * @param int $field_offset
     * @return mixed
     */
    function mysql_field_type($result, $field_offset)
    {
        $obj = mysqli_fetch_field_direct($result, (int)$field_offset);
        return is_object($obj) && isset($obj->type) ? $obj->type : null;
    }

    /**
     * @param mysqli_result $result
     */
    function mysql_free_result($result)
    {
        mysqli_free_result($result);
    }

    /**
     * @param mysql $link
     * @return int|string
     */
    function mysql_insert_id($link = null)
    {
        return mysqli_insert_id($link ?: mysql::$link);
    }

    /**
     * @param mysqli_result $result
     * @return int
     */
    function mysql_num_rows($result)
    {
        return mysqli_num_rows($result);
    }

    /**
     * @param string $query
     * @param mysql $link
     * @return mysqli_result|bool
     */
    function mysql_query($query, $link = null)
    {
        return mysqli_query($link ?: mysql::$link, $query);
    }

    /**
     * @param string $string
     * @param mysql $link
     * @return string
     */
    function mysql_real_escape_string($string, $link = null)
    {
        return mysqli_real_escape_string($link ?: mysql::$link, $string);
    }

    /**
     * @param mysqli_result $result
     * @param int $row
     * @param int $field
     * @return mixed
     */
    function mysql_result($result, $row, $field = 0)
    {
        mysqli_data_seek($result, $row);
        $data = mysqli_fetch_row($result);
        return $data[$field] ?? false;
    }

    /**
     * @param string $database
     * @param mysql $link
     * @return bool
     */
    function mysql_select_db($database, $link = null)
    {
        return mysqli_select_db($link ?: mysql::$link, $database);
    }

    /**
     * @param string $charset
     * @param mysql $link
     * @return bool
     */
    function mysql_set_charset($charset, $link = null)
    {
        return mysqli_set_charset($link ?: mysql::$link, $charset);
    }

    /**
     * @param string $database_name
     * @param string $table_name
     * @param mysql $link
     * @return mysqli_result|bool
     */
    function mysql_list_fields($database_name, $table_name, $link = null)
    {
        return mysqli_query($link ?: mysql::$link, sprintf('SHOW COLUMNS FROM `%s`', $table_name));
    }
}
