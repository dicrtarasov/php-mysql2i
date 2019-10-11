<?php
defined('MYSQL_ASSOC') || define('MYSQL_ASSOC', MYSQLI_ASSOC);
defined('MYSQL_BOTH') || define('MYSQL_BOTH', MYSQLI_BOTH);
defined('MYSQL_NUM') || define('MYSQL_NUM', MYSQLI_NUM);

if (! function_exists('mysql_connect')) {

    class mysql extends mysqli
    {
        public static $link = null;

        public function __construct($host = null, $user = null, $pass = null)
        {
            self::$link = $this;
            parent::__construct($host, $user, $pass);
        }
    }

    function mysql_connect($server = null, $username = null, $password = null, $new_link = false, $client_flags = 0)
    {
        return new mysql($server, $username, $password);
    }

    function mysql_affected_rows($link = null)
    {
        return mysqli_affected_rows(! empty($link) ? $link : mysql::$link);
    }

    function mysql_close($link = null)
    {
        return mysqli_close(! empty($link) ? $link : mysql::$link);
    }

    function mysql_errno($link = null)
    {
        return mysqli_errno(! empty($link) ? $link : mysql::$link);
    }

    function mysql_error($link = null)
    {
        return mysqli_error(! empty($link) ? $link : mysql::$link);
    }

    function mysql_escape_string($string)
    {
        return mysqli_real_escape_string(mysql::$link, $string);
    }

    function mysql_fetch_array($result, $result_type = MYSQLI_BOTH)
    {
        if (is_string($result_type))
            $result_type = constant(str_replace('MYSQL_', 'MYSQLI_', $result_type));
        return mysqli_fetch_array($result, $result_type);
    }

    function mysql_fetch_row($result)
    {
        return mysqli_fetch_row($result);
    }

    function mysql_fetch_assoc($result)
    {
        return mysqli_fetch_assoc($result);
    }

    function mysql_fetch_field($result, $field_offset = 0)
    {
        return mysqli_fetch_field($result);
    }

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

    function mysql_num_fields($result)
    {
        return mysqli_num_fields($result);
    }

    function mysql_field_name($result, $field_offset)
    {
        return mysqli_fetch_field_direct($result, (int) $field_offset)->name;
    }

    function mysql_field_type($result, $field_offset)
    {
        return mysqli_fetch_field_direct($result, (int) $field_offset)->type;
    }

    function mysql_free_result($result)
    {
        return mysqli_free_result($result);
    }

    function mysql_insert_id($link = null)
    {
        return mysqli_insert_id(! empty($link) ? $link : mysql::$link);
    }

    function mysql_num_rows($result)
    {
        return mysqli_num_rows($result);
    }

    function mysql_query($query, $link = null)
    {
        return mysqli_query(! empty($link) ? $link : mysql::$link, $query);
    }

    function mysql_real_escape_string($string, $link = null)
    {
        return mysqli_real_escape_string(! empty($link) ? $link : mysql::$link, $string);
    }

    function mysql_result($result, $row, $field = 0)
    {
        mysqli_data_seek($result, $row);
        $row = mysqli_fetch_row($result);
        return isset($row[$field]) ? $row[$field] : false;
    }

    function mysql_select_db($database, $link = null)
    {
        return mysqli_select_db(! empty($link) ? $link : mysql::$link, $database);
    }

    function mysql_set_charset($charset, $link = null)
    {
        return mysqli_set_charset(! empty($link) ? $link : mysql::$link, $charset);
    }

    function mysql_list_fields($database_name, $table_name, $link = NULL)
    {
        return mysqli_query(! empty($link) ? $link : mysql::$link, sprintf('SHOW COLUMNS FROM `%s`', $table_name));
    }
}
