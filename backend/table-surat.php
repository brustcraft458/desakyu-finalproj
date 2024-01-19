<?php
session_start();
$query_state = false;
$query_message = "";

class TableSurat extends Table {
    static public function queryPage($search) {
        if (!empty($search)) {
            $query = new Query(
                "SELECT
                    COUNT(*) AS count
                FROM surat
                    INNER JOIN penduduk ON surat.id_penduduk = penduduk.id_penduduk
                WHERE
                    surat.status_deleted = 0 AND
                    concat(nama, nik, jenis, status_pengajuan) LIKE ?"
            );

            $query->execute([
                "%$search%"
            ]);
        } else {
            $query = new Query(
                "SELECT
                    COUNT(*) AS count
                FROM surat
                    INNER JOIN penduduk ON surat.id_penduduk = penduduk.id_penduduk
                WHERE
                    surat.status_deleted = 0"
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
                    id_surat, nama, nik, jenis, status_pengajuan, kontak, file_surat, file_surat_final
                FROM surat
                    INNER JOIN penduduk ON surat.id_penduduk = penduduk.id_penduduk
                WHERE
                    surat.status_deleted = 0 AND
                    concat(nama, nik, jenis, status_pengajuan, kontak, file_surat, file_surat_final) LIKE ?
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
                    id_surat, nama, nik, jenis, status_pengajuan, kontak, file_surat, file_surat_final
                FROM surat
                    INNER JOIN penduduk ON surat.id_penduduk = penduduk.id_penduduk
                WHERE
                    surat.status_deleted = 0
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

TableSurat::initSearch("search_surat");
TableSurat::initPage();
?>