<?php

namespace controllers;

use lib\Connection;

class Clients {

    public static function show(int $id) {
        $res = Connection::query("
            select
                *
            from clients
            where
                id = $id
        ");

        $list = [];

        while ($row = $res->fetch_assoc()) {
            $list[] = $row;
        }

        require 'views/clients.php';
    }
}
