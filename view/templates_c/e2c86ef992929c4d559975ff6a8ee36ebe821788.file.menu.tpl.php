<?php /* Smarty version Smarty-3.1.18, created on 2014-05-23 16:10:04
         compiled from "/Users/mnagamine/Desktop/desktop/work/D2C/01_tool/AppliRanking/view/templates/menu.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16525723275374442dcabe95-26553667%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e2c86ef992929c4d559975ff6a8ee36ebe821788' => 
    array (
      0 => '/Users/mnagamine/Desktop/desktop/work/D2C/01_tool/AppliRanking/view/templates/menu.tpl',
      1 => 1400826098,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16525723275374442dcabe95-26553667',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5374442dcf71d6_14138511',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5374442dcf71d6_14138511')) {function content_5374442dcf71d6_14138511($_smarty_tpl) {?>            <div class="left-sidebar">
                <div class="sidebar-holder">
                    <ul class="nav  nav-list">

                        <!-- sidebar to mini Sidebar toggle -->
                        <li class="nav-toggle">
                            <button class="btn  btn-nav-toggle text-primary"><i class="fa fa-angle-double-left toggle-left"></i> </button>
                        </li>

                        <li>
                            <a href="<?php echo @constant('BASE_URL');?>
apps/ranking" data-original-title="topchart">
                                <i class="fa fa-trophy"></i><span class="hidden-minibar"> トップチャート </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo @constant('BASE_URL');?>
apps/topmatrix" data-original-title="topmatrix">
                                <i class="fa fa-th-large"></i><span class="hidden-minibar"> Top Matrix </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div><?php }} ?>
