<?PHP

class FileUtility {

    // ディレクトリ作成
    function make_dir ($dirName, $mode = null) {
        if (!file_exists($dirName) && !is_dir($dirName)) {
            $mode ? mkdir($dirName, $mode) : mkdir($dirName);
        }
    }

    function logger ($data, $filenNme)
    {
        FileUtility::file_write($data, $fileName, $mode = "wa");
    }

    // ファイル書込み
    function file_write ($data, $fileName, $mode = "wb") {
        $result = true;
        $fp = fopen($fileName, $mode);
        if ($fp) {
            if (fwrite($fp, $data) == false) {
                // error
                $result = false;
            }
        }
        fclose($fp);
        return $result;
    }

    function file_write_print ($data, $fileName, $mode = "wb")
    {
        ob_start();
        print_r($data);
        $result = ob_get_contents();
        ob_end_clean();
        $fp = fopen($fileName, $mode);
        fputs($fp, $result);
        fclose($fp);
    }

    //
    function file_write_fp($fp, $data, $fileName) {
        $result = true;
        if ($fp) {
            if (fwrite($fp, $data) == false) {
                // error
                $result = false;
            }
        }
        return $result;
    }

    function file_read ($fileName, $mode = "") {
    }

    // ディレクトリ一覧取得
    function get_dir_list ($targetDir) {
        $dirList = array();
        if ($dir = opendir($targetDir)) {
            while (($file = readdir($dir)) !== false) {
                if ($file != "." && $file != ".." && strpos($file, ".") !== 0) {
                    $dirList[] = $file;
                }
            }
            closedir($dir);
        }
        return $dirList;
    }

    // ファイル一覧取得
    function get_file_list ($targetDir, $search = "") {
        $fileList = array();
        $res_dir = opendir($targetDir);

        while ($file = readdir($res_dir)) {
            if ($search != "" && strpos($file, $search) === false) {
                continue;
            }
            if(is_file($targetDir . $file) && strpos($file, ".") !== 0) {
                $fileList[] = $file;
            }
        }
        closedir($res_dir);
        return $fileList;
    }
}

