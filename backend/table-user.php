<?php
session_start();
$query_state = false;
$query_message = "";

class TableUser extends Table {
    static public function queryPage($search) {
        if (!empty($search)) {
            $query = new Query("SELECT COUNT(*) AS count FROM user WHERE status_deleted = 0 AND concat(username, role) LIKE ?");
            $query->execute([
                "%$search%"
            ]);
        } else {
            $query = new Query("SELECT COUNT(*) AS count FROM user WHERE status_deleted = 0");
            $query->execute();
        }

        return $query;
    }
    
    static public function queryTable($search, $min, $max) {
        if (!empty($search)) {
            // Search
            $query = new Query("SELECT * FROM user WHERE status_deleted = 0 AND concat(username, role) LIKE ? LIMIT ?, ?");
    
            $query->execute([
                "%$search%",
                $min,
                $max
            ]);
        } else {
            // Default
            $query = new Query("SELECT * FROM user WHERE status_deleted = 0 LIMIT ?, ?");
    
            $query->execute([
                $min,
                $max
            ]);
        }

        return $query;
    }
}

TableUser::initSearch("search_user");
TableUser::initPage();

?>