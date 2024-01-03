<?php
class Table {
    static public function pagination($current, $total) {
        $elementItem = "";

        // Item
        if ($total <= 10){  	 
            for ($counter = 1; $counter <= $total; $counter++){
                if ($counter == $current) {
                    $elementItem .= "<li class='page-item active'><a class='page-link'>$counter</a></li>";
                } else {
                    $elementItem .= "<li class='page-item'><a class='page-link' href='?page=$counter'>$counter</a></li>";
                }
            }
        }

        elementPagination($elementItem, $current, $total);
    }
}
?>

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