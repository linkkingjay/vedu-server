<?php
class MySQLite3 extends SQLite3 {
    public function insert($table, $data) {
        $key = implode(',', array_keys($data));
        $val = implode('\',\'', $data);
        $sql = "INSERT INTO $table ($key) VALUES ('$val')";
        $this->exec($sql);
        return $this->lastInsertRowId();
    }

    public function update($table, $data, $where) {
        $set = '';
        foreach ($data as $key => $value) {
            $set .= "$key='$value',";
        }
        $set = substr($set, 0, -1);
        if (count($where) != 0) {
            $w = '';
            foreach ($where as $key => $value ) {
                $w .= "\"$key\"=$value AND "; 
            }
            $w = substr($w, 0, -4);
        }
        $sql = "UPDATE $table SET $set WHERE $w";
        $this->exec($sql);
    }

    public function remove($table, $where = array()) {
        if (count($where) != 0) {
            $w = '';
            foreach ($where as $key => $value ) {
                $w .= "\"$value\"=$key AND "; 
            }
            $w = substr($w, 0, -4);
        }
        $sql = "DELETE FROM $table WHERE $w";
        $this->exec($sql);
    }

    public function select($table, $column = array(), $where = array()) {
        if (count($column) == 0) {
            $c = "*";
        } else {
            $c = implode(',', $column);
        }

        $sql = "SELECT $c FROM \"$table\"";

        if (count($where) != 0) {
            $w = '';
            foreach ($where as $key => $value ) {
                $w .= "\"$value\"=$key AND "; 
            }
            $w = substr($w, 0, -4);
            $sql .= " WHERE $w";
        }
        $ret = $this->query($sql);
        $result = array();
        while ($row = $ret->fetchArray(SQLITE3_ASSOC)) {
            $result[] = $row;
        }

        return $result;
    }
}

