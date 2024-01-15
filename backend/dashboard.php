<?php
session_start();

class StatisticDash extends Statistic {
    static $countTable = [];
    static public function init() {
        $query = new Query("SELECT table_name, count_value FROM count_total");
        $query->execute();
        $data = $query->getData("multi");

        foreach ($data as $val) {
            $table_name = $val['table_name'];
            $count_value = $val['count_value'];

            static::$countTable[$table_name] = $count_value;
        }
    }
    
    static public function getTotalPenduduk() {
        return static::$countTable['penduduk'];
    }

    static public function getTotalSuratPending() {
        return static::$countTable['surat_pending'];
    }

    static public function getTotalLaporan() {
        return static::$countTable['user'];
    }

    static public function getTotalUser() {
        return static::$countTable['user'];
    }
}
?>