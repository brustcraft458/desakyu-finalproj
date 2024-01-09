<?php
class Table {
    static private $page = 1;
    static private $total = 0;
    static private $search = "";

    static public function initPage() {
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            self::$page = intval($_GET['page']);
        }
        
        // Count
        $query = static::queryPage(self::$search);
    
        if(!$query->state) {
            echo "query: $query->message";
            die;
        }
    
        // Max
        $count = $query->getData()['count'];
        self::$total = ceil($count / 5);
    
        return true;
    }

    static public function initSearch($sname) {
        if (isset($_POST['search'])) {
            $search = $_POST['data'];
            $search = trim($search);

            self::$search = $search;
            $_SESSION[$sname] = $search;
        } elseif (isset($_SESSION[$sname])) {
            self::$search = $_SESSION[$sname];
        }
    }

    static public function searchBox() {
        elementSearchBox(self::$search);
    }

    static public function pagination() {
        $elementItem = "";

        // Item
        for ($counter = 1; $counter <= self::$total; $counter++){
            if ($counter > 7) {
                break;
            }
            
            if ($counter == self::$page) {
                $elementItem .= "<li class='page-item active'><a class='page-link'>$counter</a></li>";
            } else {
                $elementItem .= "<li class='page-item'><a class='page-link' href='?page=$counter'>$counter</a></li>";
            }
        }

        elementPagination($elementItem, self::$page, self::$total);
    }

    static public function queryPage($search) {
        $query = new Query("");
        return $query;
    }

    static public function queryTable($search, $min, $max) {
        $query = new Query("");
        return $query;
    }
    
    static public function loadTable() {
        global $query_state, $query_message;
        $page = self::$page;
        $search = self::$search;
    
        // Page
        $min = ($page - 1) * 5;
        $max = 5;
    
        // Read data
        $query = static::queryTable($search, $min, $max);
    
        // End
        $query_state = $query->state;
        return $query->getData("multi");
    }
}
?>

<?php function elementSearchBox($search) { ?>
    <input type="text" name="data" class="form-control bg-light border-0 small" placeholder="Cari untuk..." value="<?= $search ?>">
    <button class="btn btn-primary" type="submit" name="search">
        <i class="ri-search-line"></i>
    </button>
<?php } ?> 

<?php function elementPagination($elementItem, $current, $total) { ?>
    <ul class="pagination">
        <?php if ($current > 1) :?>
            <li class='page-item'><a class='page-link' href='?page=<?= $current - 1 ?>'><<</a></li>
        <?php else:?>
            <li class='page-item'><a class='page-link disabled' href=''><<</a></li>
        <?php endif;?>

        <?= $elementItem ?>

        <?php if ($current <= $total - 1) :?>
            <li class='page-item'><a class='page-link' href='?page=<?= $current + 1 ?>'>>></a></li>
        <?php else :?>
            <li class='page-item'><a class='page-link disabled' href='#'>>></a></li>
        <?php endif;?>
    </ul>
<?php } ?>