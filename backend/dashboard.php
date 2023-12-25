<?php
session_start();

class StatisticDash extends Statistic {
    static public function getTotalPenduduk() {
        $query = new Query("SELECT COUNT(*) AS count FROM penduduk WHERE status_deleted = 0");
        $query->execute();

        $total = 0;
        if($query->state) {
            $data = $query->getData();
            $total = $data['count'];
        }

        return $total;
    }

    static public function getTotalUser() {
        $query = new Query("SELECT COUNT(*) AS count FROM user WHERE status_verified = 1");
        $query->execute();

        $total = 0;
        if($query->state) {
            $data = $query->getData();
            $total = $data['count'];
        }

        return $total;
    }
}
?>