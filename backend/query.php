<?php
class Query {
    private $sql;
    private $presql;
    public $state = false;
    public $message = ""; // fail_query | fail_nodata | succes_nodata | succes_data
    public $duplicate = false;
    private $data = [];

    public function __construct($sql) {
        global $db_connect;
        $this->sql = $sql;

        // Query
        if (!$db_connect) {
            $this->message = "fail_query";
            return;
        }

        $this->presql = $db_connect->prepare($sql);
    }

    public function checkDuplicate($sqld, $data) {
        // No Duplicate
        $queryc = new Query($sqld);
        $queryc->execute($data);

        $count = $queryc->getData()['count'];
        if ($count > 0) {
            $this->duplicate = true;
            return;
        }
        
        $this->duplicate = false;
    }

    public function execute($params = []) {
        // Check
        if ($this->duplicate) {
            $this->state = false;
            $this->message = "fail_duplicate";
            return;
        }

        if (!$this->presql) {
            $this->state = false;
            $this->message = "fail_query";
            return;
        }

        // Bind the parameter
        if (isset($params) && $params) {
            $types = "";
            $bindParams = $params;

            // Params to references
            foreach($bindParams as $key => $value) {
                $bindParams[$key] = &$bindParams[$key];
                $prm = $bindParams[$key];

                // Types
                if (is_numeric($prm)) {
                    $types .= 'i';
                }
                elseif (is_string($prm)) {
                    $types .= 's';

                    if (isEmpty($prm)) {
                        $this->state = false;
                        $this->message = "fail_emptydata";
                        return;
                    }
                }
            }

            // Bind
            array_unshift($bindParams, $types);
            call_user_func_array([$this->presql, 'bind_param'], $bindParams);
        }
    
        // Execute the prepared statement
        $this->presql->execute();
    
        // Check result
        $result = $this->presql->get_result();
        if (!$result || !$result->num_rows > 0) {
            if ($this->presql->affected_rows > 0) {
                $this->state = true;
                $this->message = "succes_nodata";
                return;
            } else {
                $this->state = false;
                $this->message = "fail_nodata";
                return;
            }
        }

        // Get result
        $this->state = true;
        $this->message = "succes_data";
        $this->data = [];

        while ($row = $result->fetch_assoc()) {
            array_push($this->data, $row);
        }
    
        // End
        $this->presql->close();
        return;
    }

    
    public function getInsertedId() {
        return $this->presql->insert_id;
    }
    
    public function getData($type = "single") {
        if ($type == "single") {
            return $this->data[0];
        } elseif ($type == "multi") {
            return $this->data;
        }

        return [];
    }
}
?>