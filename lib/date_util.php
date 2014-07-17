<?php

// メンドイからここでタイムゾーンを設定
date_default_timezone_set('Asia/Tokyo');
class DateUtil {

    function compute_month($year, $month, $day, $addMonths, $format = "Y-m-d") {
        $month += $addMonths;
        $endDay = DateUtil::get_month_end_day($year, $month);//ここで、前述した月末日を求める関数を使用します
        if($day > $endDay) $day = $endDay;
        $dt = mktime(0, 0, 0, $month, $day, $year);//正規化
        return date($format, $dt);
    }

    function conpute_hour($year, $month, $day, $time, $addHour, $format = "Y-m-d H:i")
    {
        // var_dump("$year-$month-$day $time $addHour hour");
        return date($format, strtotime("$year-$month-$day $time $addHour hour"));
    }

    function get_month_end_day($year, $month, $format = "d") {
        //mktime関数で日付を0にすると前月の末日を指定したことになります
        //$month + 1 をしていますが、結果13月のような値になっても自動で補正されます
        $dt = mktime(0, 0, 0, $month + 1, 0, $year);
        return date($format, $dt);
    }

    function compute_date($year, $month, $day, $addDays, $format = "Y-m-d H:i:s") {
        $baseSec = mktime(0, 0, 0, $month, $day, $year);//基準日を秒で取得
        $addSec = $addDays * 86400;//日数×１日の秒数
        $targetSec = $baseSec + $addSec;
        return date($format, $targetSec);
    }

    function get_year_list ($minYear, $maxYear) {
        $yearList = array();
        for ($i = $minYear; $i <= $maxYear; $i++) {
            $yearList[$i] = $i;
        }
        return $yearList;
    }

    function get_month_list () {
        $monthList = array();
        for ($i = 1; $i <= 12; $i++) {
            $month = $i < 10 ? "0$i" : $i;
            $monthList[$month] = $month;
        }
        return $monthList;
    }

    function get_day_list ($endDay = 31) {
        $dayList = array();
        for ($i = 1; $i <= $endDay; $i++) {
            $day = $i >= 10 ? $i : "0$i";
            $dayList[$day] = $day;
        }
        return $dayList;
    }

    function get_hour_list () {
        return DateUtil::get_time_list();
    }

    function get_minute_list () {
        $minuteList = array();
        for ($i = 0; $i <= 59; $i = $i + 10) {
            $minute = $i >= 10 ? $i : "0$i";
            $minuteList[$minute] = $minute;
        }
        return $minuteList;
    }

    function get_time_list () {
        $timeList = array();
        for ($i = 0; $i < 24; $i++) {
            $time = $i >= 10 ? $i : "0$i";
            $timeList[$time] = $time;
        }
        return $timeList;
    }

    function utc_to_tokyo_time ($strDateTime, $strFormat = "Y-m-d H:i:s")
    {
        // $t = new DateTime("2013-10-17T10:00:00.000Z");
        $t = new DateTime($strDateTime);
        $t->setTimeZone(new DateTimeZone('Asia/Tokyo'));
        return $t->format($strFormat);
    }
}

