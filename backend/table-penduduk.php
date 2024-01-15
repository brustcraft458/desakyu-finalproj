<?php
session_start();
$query_state = false;
$query_message = "";

class TablePenduduk extends Table {
    static public function queryPage($search) {
        if (!empty($search)) {
            $query = new Query("SELECT COUNT(*) AS count FROM penduduk WHERE status_deleted = 0 AND concat(nama, nik, jenis_kelamin, status_perkawinan, pekerjaan) LIKE ?");
            $query->execute([
                "%$search%"
            ]);
        } else {
            $query = new Query("SELECT COUNT(*) AS count FROM penduduk WHERE status_deleted = 0");
            $query->execute();
        }

        return $query;
    }
    
    static public function queryTable($search, $min, $max) {
        if (!empty($search)) {
            // Search
            $query = new Query("SELECT * FROM penduduk WHERE status_deleted = 0 AND concat(nama, nik, jenis_kelamin, status_perkawinan, pekerjaan) LIKE ? LIMIT ?, ?");
    
            $query->execute([
                "%$search%",
                $min,
                $max
            ]);
        } else {
            // Default
            $query = new Query("SELECT * FROM penduduk WHERE status_deleted = 0 LIMIT ?, ?");
    
            $query->execute([
                $min,
                $max
            ]);
        }

        return $query;
    }
}

TablePenduduk::initSearch("search_penduduk");
TablePenduduk::initPage();

?>