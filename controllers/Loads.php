<?php

namespace controllers;

use lib\Connection;
use lib\Init;

class Loads {

    public static function show() {
        $list = self::getList();

        $client = Init::$client;
        $manager = Init::$manager;

        require 'views/loads.php';
    }

    private static function getList() {
        $filter = [];

        if (isset($_GET['manager'])) {
            $filter[] = 'loads.manager is null';
        }

        $cond = '';

        if ($filter) {
            $cond = 'where ' . implode(' and ', $filter);
        }

        $res = Connection::query('
            select
                loads.*,
                (
                    select company_name from clients where id = loads.client
                ) client,
                (
                    select concat(surname, \' \', name) from managers where id = loads.manager
                ) manager,
                client client_id,
                manager manager_id
            from loads ' . $cond
        );

        $list = [];

        while ($row = $res->fetch_assoc()) {
            $list[] = $row;
        }

        return $list;
    }

    // CSV простой формат данных, его можно открыть в виде Excel таблицы
    public static function export() {
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=loads.csv");

        $list = self::getList();

        $f = fopen('php://output', 'w');

        foreach ($list as $row) {
            fputcsv($f, $row);
        }

        fclose($f);        
    }

    public static function add($id) {
        $client = Init::$client;
        $manager = Init::$manager;

        if ($_POST) {
            $row = $_POST;

            if (isset($_POST['id'])) {
                $id = (int)$_POST['id'];

                $row = Connection::query('select client, manager from loads where id = ' . (int)$id)->fetch_assoc();

                $allowFields = ['id'];

                if ($client == $row['client']) {
                    $allowFields[] = 'container';
                }

                if ($manager == $row['manager']) {
                    $allowFields[] = 'status';
                }

                $row = [];

                foreach ($_POST as $key => $value) {
                    if (in_array($key, $allowFields)) {
                        $row[$key] = $value;
                    }
                }
            }

            Connection::insert('loads', $row);

            header('location: /');

            exit;
        }

        $row = [
            'container' => '',
            'status' => ''
        ];

        if ($id) {
            $row = Connection::query('select * from loads where id = ' . (int)$id)->fetch_assoc();
        }

        require 'views/loads_add.php';
    }

    public static function take($id) {
        $row = Connection::query('select manager from loads where id = ' . (int)$id)->fetch_assoc();

        if ($row['manager']) {
            exit;
        }

        $row = [
            'id' => $id,
            'manager' => Init::$manager
        ];

        Connection::insert('loads', $row);

        header('location: ' . $_SERVER['HTTP_REFERER']);
    }
}
