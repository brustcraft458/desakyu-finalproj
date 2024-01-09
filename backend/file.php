<?php
class File {
    private $dir;
    private $name;
    private $target;
    public $state = false;

    public function __construct($dir, $name = "") {
        $this->dir = $dir;
        $this->name = $name;
    }

    public function moveUpload($pname) {
        global $rootdir;
        $fileType = strtolower(pathinfo($_FILES[$pname]["name"], PATHINFO_EXTENSION));
        $this->name = uniqid() . "-" . uniqid() . '.' . $fileType;
        $fullpath = $rootdir . $this->dir . $this->name;

        if (move_uploaded_file($_FILES[$pname]["tmp_name"], $fullpath)) {
            $this->state = true;
        }
    }

    public function saveDownload() {
        global $rootdir;
        $fullpath = $rootdir . $this->dir . $this->name;

        if (file_exists($fullpath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($fullpath));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($fullpath));
            ob_clean();
            flush();
            readfile($fullpath);
            exit;
        } else {
            echo 'File not found';
        }
    }
}
?>