<?php
session_start();
$query_state = false;
$query_message = "";

class TableSaran extends Table {
    static public function queryPage($search) {
        if (!empty($search)) {
            $query = new Query(
                "SELECT
                    COUNT(*) AS count
                FROM saran
                    INNER JOIN penduduk ON saran.id_penduduk = penduduk.id_penduduk
                WHERE
                    saran.status_deleted = 0 AND
                    concat(nama, nik) LIKE ?"
            );

            $query->execute([
                "%$search%"
            ]);
        } else {
            $query = new Query(
                "SELECT
                    COUNT(*) AS count
                FROM saran
                    INNER JOIN penduduk ON saran.id_penduduk = penduduk.id_penduduk
                WHERE
                    saran.status_deleted = 0"
            );

            $query->execute();
        }

        return $query;
    }
    
    static public function queryTable($search, $min, $max) {
        if (!empty($search)) {
            // Search
            $query = new Query(
                "SELECT
                    id_saran, nama, nik, rating, saran
                FROM saran
                    INNER JOIN penduduk ON saran.id_penduduk = penduduk.id_penduduk
                WHERE
                    saran.status_deleted = 0 AND
                    concat(nama, nik) LIKE ?
                LIMIT ?, ?"
            );
    
            $query->execute([
                "%$search%",
                $min,
                $max
            ]);
        } else {
            // Default
            $query = new Query(
                "SELECT
                    id_saran, nama, nik, rating, saran
                FROM saran
                    INNER JOIN penduduk ON saran.id_penduduk = penduduk.id_penduduk
                WHERE
                    saran.status_deleted = 0
                LIMIT ?, ?"
            );
    
            $query->execute([
                $min,
                $max
            ]);
        }

        return $query;
    }
}

TableSaran::initSearch("search_saran");
TableSaran::initPage();
?>