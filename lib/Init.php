<?php

namespace lib;

class Init {

    public static $client;
    public static $manager;

    public static function init() {
        if (!Connection::query('show tables like \'clients\'')->fetch_assoc()) {
            Connection::queryMulti(file_get_contents('sql/test.sql'));
        }

        if (isset($_COOKIE['client'])) {
            self::$client = $_COOKIE['client'];

            if (!Connection::query('select 1 from clients where id = ' . (int)self::$client)->fetch_assoc()) {
                self::$client = null;
            }
        }

        if (isset($_COOKIE['manager'])) {
            self::$manager = $_COOKIE['manager'];

            if (!Connection::query('select 1 from managers where id = ' . (int)self::$manager)->fetch_assoc()) {
                self::$manager = null;
            }
        }

        if (!self::$client) {
            $row = Connection::query('select max(id) id from clients');

            $maxId = 0;

            if ($row) {
                $row = $row->fetch_assoc();

                $maxId = $row['id'];
            }

            $row = [
                'company_name' => 'Name' . ($maxId + 1)
            ];

            Connection::insert('clients', $row);

            self::$client = Connection::insertId();

            $res = setcookie('client', self::$client);

            if (!$res) {
                echo 'Не удалось создать COOKIE и клиента';
            }
        }

        if (!self::$manager) {
            $row = Connection::query('select max(id) id from managers');

            if ($row) {
                $row = $row->fetch_assoc();
            }

            $maxId = $row['id'];

            $row = [
                'surname' => 'surname' . ($maxId + 1),
                'name' => 'Name' . ($maxId + 1)
            ];

            Connection::insert('managers', $row);

            self::$manager = Connection::insertId();

            $res = setcookie('manager', self::$manager);

            if (!$res) {
                echo 'Не удалось создать COOKIE и менеджера';
            }
        }
    }
}
