<?php

/**
*
*/
class RankingUtil
{

    function __construct()
    {
        # code...
    }

    // objectを配列に変換
    function object2array($obj)
    {
        $arr = $obj;
        if (is_object($arr)) {
            $arr = (array)$arr;
        }
        if (is_array($arr)) {
            foreach ($arr as &$a) {
                if (is_object($a)) {
                    $a = (array)$a;
                }
                $a = RankingUtil::object2array($a);
            }
        }
        return $arr;
    }

    function array_value_search ($arrTarget, $value)
    {
        foreach ($arrTarget as $arrTargetKey => $arrTargetValue) {
            if ($arrTargetValue == $value) {
                return true;
            }
        }
        return false;
    }
}