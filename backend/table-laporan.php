<?php
session_start();
$query_state = false;
$query_message = "";

class TableLaporan extends Table {
    static public function queryPage($search) {
        if (!empty($search)) {
            $query = new Query(
                "SELECT
                    COUNT(*) AS count
                FROM laporan
                WHERE
                    laporan.status_deleted = 0 AND
                    concat(nama, nik) LIKE ?"
            );

            $query->execute([
                "%$search%"
            ]);
        } else {
            $query = new Query(
                "SELECT
                    COUNT(*) AS count
                FROM laporan
                WHERE
                    laporan.status_deleted = 0"
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
                    id_laporan, nik, nama, jenis_laporan
                FROM laporan
                WHERE
                    status_deleted = 0 AND
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
                    id_laporan, nik, nama, jenis_laporan
                FROM laporan
                WHERE
                    status_deleted = 0
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

TableLaporan::initSearch("search_laporan");
TableLaporan::initPage();
?>