<?php

$sql = array();

foreach ($sql as $query) {
    if (false == Db::getInstance()->execute($query)) {
        return false;
    }
}
