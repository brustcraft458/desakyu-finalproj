<?php
class Sidebar {
    static $menuList = [
        "dashboard" => "Dashboard",
        "table-penduduk" => "Data Penduduk",
        "form-penduduk" => "Form Penduduk",
        "laporan" => "Laporan",
        "table-master" => "Master Data"
    ];
    static public function selection($select) {
        $username = "";
        if (isset($_SESSION['username'])) {
            $username = $_SESSION['username'];
        }

        return sidebarElement($select, self::$menuList, $username);
    }
}
?>

<!-- Sidebar -->
<?php function sidebarElement($select, $data, $username) {?>
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100vh">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap" />
            </svg>
            <span class="fs-4">Aplikasi Desa</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <?php foreach ($data as $key => $value) : ?>
                <li class="nav-item">
                    <a href="./<?= $key ?>.php" class="nav-link <?= ($key == $select) ? 'active' : 'text-white' ?>" aria-current="page">
                        <svg class="bi me-2" width="16" height="16">
                            <use xlink:href="#home" />
                        </svg>
                        <?= $value ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="./img/user-icon.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong><?= $username ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="./backend/logout.php">Log Out</a></li>
            </ul>
        </div>
    </div>
<?php }?>