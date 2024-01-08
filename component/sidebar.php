<?php
class Sidebar {
    static $menuList = [];
    static $username = "";
    static $select = "";
    static $role = "";
    
    static public function selection($select) {
        if (isset($_SESSION['username'])) {
            self::$username = $_SESSION['username'];
        }
        if (isset($_SESSION['role'])) {
            self::$role = $_SESSION['role'];
        }
        self::$select = $select;

        // Menu
        if (self::$role == "warga") {
            self::$menuList =  ["dashboard" => ["Dashboard", "ri-dashboard-2-line"]];
        } elseif (self::$role == "admin_rt" || self::$role == "admin_desa") {
            self::$menuList = [
                "dashboard" => ["Dashboard", "ri-dashboard-2-line"],
                "table-penduduk" => ["Data Penduduk", "ri-table-line"],
                "table-surat" => ["Layanan Surat", "ri-mail-line"],
                "table-laporan" => ["Layanan Laporan", "ri-file-text-line"],
                "table-saran" => ["Saran", "ri-chat-quote-line"]
            ];
        } elseif (self::$role == "admin_super") {
            self::$menuList = [
                "dashboard" => ["Dashboard", "ri-dashboard-2-line"],
                "table-penduduk" => ["Data Penduduk", "ri-table-line"],
                "table-surat" => ["Layanan Surat", "ri-mail-line"],
                "table-laporan" => ["Layanan Laporan", "ri-file-text-line"],
                "table-saran" => ["Saran", "ri-chat-quote-line"],
                "table-user" => ["Kelola User", "ri-user-settings-line"]
            ];
        }

        if (!array_key_exists(self::$select, self::$menuList)) {
            header("Location: login.php");
            die;
        }
    }

    static public function render() {
        return sidebarElement(self::$select, self::$menuList, self::$username);
    }
}
?>

<!-- Sidebar -->
<?php function sidebarElement($select, $data, $username) {?>
    <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; min-height: 100vh">
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
                        <i class="<?= $value[1] ?>"></i>
                        <?= $value[0] ?>
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