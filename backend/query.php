<?php
class Query {
    private $sql;
    private $presql;
    public $state = false;
    public $message = ""; // fail_query | fail_nodata | succes_nodata | succes_data | succes_multidata
    private $data = [];

    public function __construct($sql) {
        global $db_connect;
        $this->sql = $sql;

        // Query
        $this->presql = $db_connect->prepare($sql);
    }

    public function execute($params = []) {
        // Check
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
            }

            // Types
            foreach ($params as $prm) {
                if (is_int($prm)) {
                    $types .= 'i';
                }
                elseif (is_string($prm)) {
                    $types .= 's';
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
        if (!$result) {
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
        if ($result->num_rows == 1) {
            // Single
            $this->state = true;
            $this->message = "succes_data";

            $this->data = $result->fetch_assoc();
        } else {
            // Multi
            $this->state = true;
            $this->message = "succes_multidata";
            $this->data = [];

            while ($row = $result->fetch_assoc()) {
                array_push($this->data, $row);
            }
        }
    
        // End
        $this->presql->close();
        return;
    }

    public function getData() {
        return $this->data;
    }
}
?>