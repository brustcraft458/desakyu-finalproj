<?php
class Statistic {
    static public function getJenisKelamin() {
        // Query
        $query = new Query("SELECT jenis_kelamin, COUNT(jenis_kelamin) AS jumlah FROM penduduk GROUP BY jenis_kelamin");
        $query->execute();

        $data = $query->getData("multi");
        
        $laki = $data[0]["jumlah"];
        $perempuan = $data[1]["jumlah"];

        return [
            "Laki-Laki" => $laki,
            "Perempuan" => $perempuan
        ];
    }

    static public function getPekerjaan() {
        return "";
    }

    static public function getPendidikan() {
        return "";
    }

    static public function getPerkawinan() {
        return "";
    }
}
?>