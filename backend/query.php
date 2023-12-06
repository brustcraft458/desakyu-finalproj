<?php
class Query {
    static public function execute($sql, $params = []) {
        global $db_connect;

        // Query
        $presql = $db_connect->prepare($sql);
        if (!$presql) {return null;}

        // Bind the parameter
        if (isset($params) && $params) {
            $types = "";

            foreach ($params as $prm) {
                if (is_int($prm)) {
                    $types .= 'i';
                }
                elseif (is_string($prm)) {
                    $types .= 's';
                }
            }

            $bindParams = array_merge([$types], $params);

            print_r($bindParams);

            call_user_func_array([$presql, 'bind_param'], $bindParams);
            // $presql->bind_param("s", $username);
        }
    
        // Execute the prepared statement
        $presql->execute();
    
        // Check result
        $result = $presql->get_result();
        if (!$result) {return [];}

        // Get the result
        $data = [];
        while ($row = $result->fetch_assoc()) {
            array_push($data, $row);
        }
    
        // End
        $presql->close();
        return $data;
    }
}
?>