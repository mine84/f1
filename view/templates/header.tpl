<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>アプリランキング</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="{$smarty.const.CSS_URL}/bootstrap.css" rel="stylesheet">

    <!-- Loading Stylesheets -->
    <link href="{$smarty.const.CSS_URL}/font-awesome.css" rel="stylesheet">
    <link href="{$smarty.const.CSS_URL}/style.css" rel="stylesheet" type="text/css">
    <link href="{$smarty.const.CSS_URL}/morris-0.4.3.min.css" rel="stylesheet" type="text/css">

    <link href="{$smarty.const.LESS_URL}/style.less" rel="stylesheet"  title="lessCss" id="lessCss">

    <!-- Loading Custom Stylesheets -->
    <link href="{$smarty.const.CSS_URL}/custom.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
      <!--[if lt IE 9]>
      <script src="{$smarty.const.JS_URL}/html5shiv.js"></script>
      <![endif]-->
</head>
<body>
    <div class="site-holder">
        <!-- this is a dummy text -->
        <!-- .navbar -->
        <nav class="navbar" role="navigation">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><span class="logo"><i class="fa fa-trophy"></i> Ranking</span></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav user-menu navbar-right ">
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav> <!-- /.navbar -->

        <!-- .box-holder -->
        <div class="box-holder">
            <!-- .left-sidebar -->
            {include file=$smarty.const.SMARTY_TEMPLATES_DIR|cat:'menu.tpl'}
            <!-- /.left-sidebar -->

            <!-- .content -->
            <div class="content">


