<?php

class DB {
    var $db = false;

    function __constructor($dbuser, $dbpass, $dbhost, $dbname) {
        $db = new PDO("mysql:dbname=$dbname;host=$dbhost",$dbuser,$dbpass);
        query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
    }

    function query($query,$params = array()) {
        $q = $db->prepare($query);
        $q->execute($params);
        $e = $q->errorInfo();
        if($e[0]!='00000') {
            print "<span class='error'>";
            print $e[2];
            print "</span>";
            return false;
        }
        return $q;
    }

    function nextRecord($query) {
        $next = $query->fetchObject();
        return $next;
    }

    function lastId() {
        return $db->lastInsertId();
    }

    function update($table,$id,$data) {
        $values = array();
        foreach($data as $k=>$v) {
            $values[] = "`" . $k . "`" . "=:" . $k;
        }
        $query = sprintf("UPDATE `%s` set " . implode(",",$values) . " WHERE id=:id",$table);
        $data['id'] = $id;

        $q = query($query,$data);
        $id = id();
        return $id;
    }

    function insert($table,$data) {
        $fields = array();
        $values = array();
        foreach($data as $k=>$v) {
            $fields[] = $k;
            $values[] = ":" . $k;
        }
        $query = sprintf("INSERT INTO `%s` (" . implode(",",$fields) . ") VALUES (" . implode(",",$values) . ")",$table);
        $q = query($query,$data);
        $id = id();
        return $id;
    }

    function set($table,$record,$field,$value) {
        query("UPDATE `$table` SET `$field`=:f WHERE id=:i",array(
            'f'=>$value,
            'i'=>$record
        ));
    }

    function select($table,$record) {
        $query = sprintf("SELECT * FROM `%s` WHERE id=:id",$table);
        $q = query($query,array("id" => $record));
        $r = next($q);
        return $r;
    }
}

