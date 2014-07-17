<?PHP
class SmartyUtil {
    var $objSmarty;

    function __construct ($temp_dir, $comp_dir, $cache_dir = null) {
        $this->objSmarty = new Smarty;
        $this->objSmarty->template_dir = $temp_dir;
        $this->objSmarty->compile_dir = $comp_dir;
        if ($cache != null) $this->objSmarty->cache_dir = $cache_dir;
    }

    // assignのラッパー
    function assign ($key, $value) {
        $this->objSmarty->assign($key, $value);
    }

    // displayのラッパー
    function display ($template_name) {
        $this->objSmarty->display($template_name);
    }

    function all_assign ($arrData) {
        foreach ($arrData as $key => $value) {
            $this->objSmarty->assign($key, $value);
        }
    }

    function get_template_vars ($strKey = null)
    {
        if (empty($strKey)) {
            return $this->objSmarty->getTemplateVars();
        } else {
            return $this->objSmarty->getTemplateVars($strKey);
        }
    }
}