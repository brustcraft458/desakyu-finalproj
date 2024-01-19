<?php
class File {
    static public function generateName() {
        $randomHex = bin2hex(random_bytes(16));
        $name = uniqid() . $randomHex;
        return $name;
    }

    static public function moveUpload($pname, $dir) {
        global $rootdir;
        $fileType = strtolower(pathinfo($_FILES[$pname]["name"], PATHINFO_EXTENSION));
        $name = self::generateName();

        $name = $name . '.' . $fileType;
        $path =  $dir . $name;
        $fullpath = "$rootdir/$path";

        if (move_uploaded_file($_FILES[$pname]["tmp_name"], $fullpath)) {
            return $path;
        } else {
            return null;
        }
    }

    static public function saveDownload($path) {
        global $rootdir;
        $fullpath = "$rootdir/$path" ;

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

    static public function move($path_a, $path_b) {
        global $rootdir;
        $pathf_b = $path_b . basename($path_a);

        rename("$rootdir/$path_a", "$rootdir/$pathf_b");
        return $pathf_b;
    }

    static public function delete($path) {
        global $rootdir;
        return unlink("$rootdir/$path");
    }
}
?>