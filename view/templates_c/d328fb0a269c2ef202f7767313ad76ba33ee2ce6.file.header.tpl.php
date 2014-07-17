<?php /* Smarty version Smarty-3.1.18, created on 2014-05-23 11:36:55
         compiled from "/Users/mnagamine/Desktop/desktop/work/D2C/01_tool/AppliRanking/view/templates/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17390077015374442dbe25f2-57197113%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd328fb0a269c2ef202f7767313ad76ba33ee2ce6' => 
    array (
      0 => '/Users/mnagamine/Desktop/desktop/work/D2C/01_tool/AppliRanking/view/templates/header.tpl',
      1 => 1400812614,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17390077015374442dbe25f2-57197113',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5374442dc9b156_02868871',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5374442dc9b156_02868871')) {function content_5374442dc9b156_02868871($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>アプリランキング</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Loading Bootstrap -->
    <link href="<?php echo @constant('CSS_URL');?>
/bootstrap.css" rel="stylesheet">

    <!-- Loading Stylesheets -->
    <link href="<?php echo @constant('CSS_URL');?>
/font-awesome.css" rel="stylesheet">
    <link href="<?php echo @constant('CSS_URL');?>
/style.css" rel="stylesheet" type="text/css">

    <link href="<?php echo @constant('LESS_URL');?>
/style.less" rel="stylesheet"  title="lessCss" id="lessCss">

    <!-- Loading Custom Stylesheets -->
    <link href="<?php echo @constant('CSS_URL');?>
/custom.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
      <!--[if lt IE 9]>
      <script src="<?php echo @constant('JS_URL');?>
/html5shiv.js"></script>
      <![endif]-->
</head>
<body>
    <div class="site-holder">
        <!-- this is a dummy text -->
        <!-- .navbar -->
        <nav class="navbar" role="navigation">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="#"><i class="fa fa-list btn-nav-toggle-responsive text-white"></i> <span class="logo">Cas<strong>ca</strong>de <i class="fa fa-bookmark"></i></span></a>
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
            <?php echo $_smarty_tpl->getSubTemplate ((@constant('SMARTY_TEMPLATES_DIR')).('menu.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <!-- /.left-sidebar -->

            <!-- .content -->
            <div class="content">


<?php }} ?>
