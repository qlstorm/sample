<?php

namespace controllers;

use lib\Connection;

class Managers {

    public static function show(int $id) {
        $res = Connection::query("
            select
                *
            from managers
            where
                id = $id
        ");

        $list = [];

        while ($row = $res->fetch_assoc()) {
            $list[] = $row;
        }

        require 'views/managers.php';
    }
}
