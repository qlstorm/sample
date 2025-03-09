<?php

namespace lib;

class Connection {

    private static $connection;

    public static function connect() {
        if (!self::$connection) {
            require 'conf.php';

            self::$connection = mysqli_connect(
                $conf['host'],
                $conf['username'], 
                $conf['password'],
                $conf['database']
            );
        }

        return self::$connection;
    }

    public static function query($query) {
        $result = mysqli_query(self::connect(), $query);

        return $result;
    }

    public static function queryMulti($query) {
        $result = mysqli_multi_query(self::connect(), $query);

        // flush multiply results to let futher single queries execute
        while(mysqli_next_result(self::connect())){

        }

        return $result;
    }

    public static function insert($table, $row) {
        return self::insertBatch($table, array_keys($row), [$row]);
    }

    public static function insertBatch($table, $columns, $rows) {
        $rowsList = [];

        foreach ($rows as $row) {
            foreach ($row as &$value) {
                if ($value == '') {
                    $value = 'null';

                    continue;
                }

                if (!is_numeric($value)) {
                    $value = '\'' . self::escape($value) . '\'';
                }
            }

            $rowsList[] = '(' . implode(', ', $row) . ')';
        }

        $rowsString = implode(', ', $rowsList);

        $columnString = implode(', ', $columns);

        $query = "insert into `$table` ($columnString) values $rowsString";

        $updateList = [];

        foreach ($columns as $column) {
            $updateList[] = $column . ' = values(' . $column . ')';
        }

        $updateString = implode(', ', $updateList);

        $query .= ' on duplicate key update ' . $updateString;

        return self::query($query);
    }

    public static function escape($string) {
        return mysqli_real_escape_string(self::connect(), $string);
    }

    public static function insertId() {
        return mysqli_insert_id(self::connect());
    }
}
