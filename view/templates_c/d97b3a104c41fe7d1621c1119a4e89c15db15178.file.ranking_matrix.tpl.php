<?php /* Smarty version Smarty-3.1.18, created on 2014-05-26 16:35:13
         compiled from "/Users/mnagamine/Desktop/desktop/work/D2C/01_tool/AppliRanking/view/templates/ranking_matrix.tpl" */ ?>
<?php /*%%SmartyHeaderCode:186169712537ef5b3b15cd0-10707115%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd97b3a104c41fe7d1621c1119a4e89c15db15178' => 
    array (
      0 => '/Users/mnagamine/Desktop/desktop/work/D2C/01_tool/AppliRanking/view/templates/ranking_matrix.tpl',
      1 => 1401089712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186169712537ef5b3b15cd0-10707115',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_537ef5b3c7c686_87902149',
  'variables' => 
  array (
    'os_id' => 0,
    'osOption' => 0,
    'categoryOption' => 0,
    'category_id' => 0,
    'yearOption' => 0,
    'ranking_year' => 0,
    'monthOption' => 0,
    'ranking_month' => 0,
    'dateOption' => 0,
    'ranking_date' => 0,
    'timeOption' => 0,
    'ranking_time' => 0,
    'listRanking' => 0,
    'rankingKey' => 0,
    'intFeedCount' => 0,
    'intCnt' => 0,
    'intRankingCount' => 0,
    'intRanking' => 0,
    'arrRankingKey' => 0,
    'intCountryCount' => 0,
    'intLoopCount' => 0,
    'countryOption' => 0,
    'ranking' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_537ef5b3c7c686_87902149')) {function content_537ef5b3c7c686_87902149($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/Users/mnagamine/Desktop/desktop/work/D2C/01_tool/AppliRanking/lib/smarty/plugins/function.html_options.php';
?><?php echo $_smarty_tpl->getSubTemplate ((@constant('SMARTY_TEMPLATES_DIR')).('header.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('jsfile'=>'ranking/ranking_list.js'), 0);?>


    <!-- Users widget -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading text-primary">
                    <?php if ($_smarty_tpl->tpl_vars['os_id']->value==@constant('IOS')) {?>
                    <h3 class="panel-title"><i class="fa fa-apple"></i> IOS Ranking
                    <?php } elseif ($_smarty_tpl->tpl_vars['os_id']->value==@constant('ANDROID')) {?>
                    <h3 class="panel-title"><i class="fa fa-android"></i> Android Ranking
                    <?php }?>

                    </h3>
                </div>
                <div class="panel-body">
                    <form id="ranking_search_condition" class="form-horizontal" action="<?php echo @constant('BASE_URL');?>
apps/ranking" method="POST">
                        <div class="form-group">
                            <div class="col-lg-8 col-md-4">
                            OS <?php echo smarty_function_html_options(array('name'=>'os_id','options'=>$_smarty_tpl->tpl_vars['osOption']->value,'selected'=>$_smarty_tpl->tpl_vars['os_id']->value,'id'=>"os_id"),$_smarty_tpl);?>

                            カテゴリー <?php echo smarty_function_html_options(array('name'=>'category_id','options'=>$_smarty_tpl->tpl_vars['categoryOption']->value,'selected'=>$_smarty_tpl->tpl_vars['category_id']->value,'id'=>"category_id"),$_smarty_tpl);?>

                            </div>
                            <div class="col-lg-8 col-md-4">
                            <?php echo smarty_function_html_options(array('name'=>'ranking_year','options'=>$_smarty_tpl->tpl_vars['yearOption']->value,'selected'=>$_smarty_tpl->tpl_vars['ranking_year']->value,'id'=>"ranking_year"),$_smarty_tpl);?>
年
                            <?php echo smarty_function_html_options(array('name'=>'ranking_month','options'=>$_smarty_tpl->tpl_vars['monthOption']->value,'selected'=>$_smarty_tpl->tpl_vars['ranking_month']->value,'id'=>"ranking_month"),$_smarty_tpl);?>
月
                            <?php echo smarty_function_html_options(array('name'=>'ranking_date','options'=>$_smarty_tpl->tpl_vars['dateOption']->value,'selected'=>$_smarty_tpl->tpl_vars['ranking_date']->value,'id'=>"ranking_date"),$_smarty_tpl);?>
日
                            <?php echo smarty_function_html_options(array('name'=>'ranking_time','options'=>$_smarty_tpl->tpl_vars['timeOption']->value,'selected'=>$_smarty_tpl->tpl_vars['ranking_time']->value,'id'=>"ranking_time"),$_smarty_tpl);?>
時
                            </div>
                        </div>
                    </form>
                    <table class="table users-table table-condensed table-hover" >
                        <thead>
                            <tr>
                                <?php $_smarty_tpl->tpl_vars['intFeedCount'] = new Smarty_variable(0, null, 0);?>
                                <?php $_smarty_tpl->tpl_vars['arrRankingKey'] = new Smarty_variable(array(), null, 0);?>
                                <?php  $_smarty_tpl->tpl_vars['ranking'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ranking']->_loop = false;
 $_smarty_tpl->tpl_vars['rankingKey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['listRanking']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ranking']->key => $_smarty_tpl->tpl_vars['ranking']->value) {
$_smarty_tpl->tpl_vars['ranking']->_loop = true;
 $_smarty_tpl->tpl_vars['rankingKey']->value = $_smarty_tpl->tpl_vars['ranking']->key;
?>
                                <?php $_smarty_tpl->createLocalArrayVariable('arrRankingKey', null, 0);
$_smarty_tpl->tpl_vars['arrRankingKey']->value[] = $_smarty_tpl->tpl_vars['rankingKey']->value;?>
                                <?php $_smarty_tpl->tpl_vars['intFeedCount'] = new Smarty_variable($_smarty_tpl->tpl_vars['intFeedCount']->value+1, null, 0);?>
                                <?php if ($_smarty_tpl->tpl_vars['intFeedCount']->value==1) {?>
                                <th class="visible-lg" colspan="6"><?php echo $_smarty_tpl->tpl_vars['rankingKey']->value;?>
</th>
                                <?php } else { ?>
                                <th class="visible-lg" colspan="5"><?php echo $_smarty_tpl->tpl_vars['rankingKey']->value;?>
</th>
                                <?php }?>
                                <?php } ?>
                                <?php $_smarty_tpl->tpl_vars['intFeedCount'] = new Smarty_variable($_smarty_tpl->tpl_vars['intFeedCount']->value-1, null, 0);?>
                            </tr>
                            <tr>
                                <?php $_smarty_tpl->tpl_vars['intCnt'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['intCnt']->step = 1;$_smarty_tpl->tpl_vars['intCnt']->total = (int) ceil(($_smarty_tpl->tpl_vars['intCnt']->step > 0 ? $_smarty_tpl->tpl_vars['intFeedCount']->value+1 - (0) : 0-($_smarty_tpl->tpl_vars['intFeedCount']->value)+1)/abs($_smarty_tpl->tpl_vars['intCnt']->step));
if ($_smarty_tpl->tpl_vars['intCnt']->total > 0) {
for ($_smarty_tpl->tpl_vars['intCnt']->value = 0, $_smarty_tpl->tpl_vars['intCnt']->iteration = 1;$_smarty_tpl->tpl_vars['intCnt']->iteration <= $_smarty_tpl->tpl_vars['intCnt']->total;$_smarty_tpl->tpl_vars['intCnt']->value += $_smarty_tpl->tpl_vars['intCnt']->step, $_smarty_tpl->tpl_vars['intCnt']->iteration++) {
$_smarty_tpl->tpl_vars['intCnt']->first = $_smarty_tpl->tpl_vars['intCnt']->iteration == 1;$_smarty_tpl->tpl_vars['intCnt']->last = $_smarty_tpl->tpl_vars['intCnt']->iteration == $_smarty_tpl->tpl_vars['intCnt']->total;?>
                                <?php if ($_smarty_tpl->tpl_vars['intCnt']->value==0) {?>
                                <th class="visible-lg">国</th>
                                <?php }?>
                                <?php $_smarty_tpl->tpl_vars['intRankingCount'] = new Smarty_variable(5, null, 0);?>
                                <?php $_smarty_tpl->tpl_vars['intRanking'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['intRanking']->step = 1;$_smarty_tpl->tpl_vars['intRanking']->total = (int) ceil(($_smarty_tpl->tpl_vars['intRanking']->step > 0 ? $_smarty_tpl->tpl_vars['intRankingCount']->value+1 - (1) : 1-($_smarty_tpl->tpl_vars['intRankingCount']->value)+1)/abs($_smarty_tpl->tpl_vars['intRanking']->step));
if ($_smarty_tpl->tpl_vars['intRanking']->total > 0) {
for ($_smarty_tpl->tpl_vars['intRanking']->value = 1, $_smarty_tpl->tpl_vars['intRanking']->iteration = 1;$_smarty_tpl->tpl_vars['intRanking']->iteration <= $_smarty_tpl->tpl_vars['intRanking']->total;$_smarty_tpl->tpl_vars['intRanking']->value += $_smarty_tpl->tpl_vars['intRanking']->step, $_smarty_tpl->tpl_vars['intRanking']->iteration++) {
$_smarty_tpl->tpl_vars['intRanking']->first = $_smarty_tpl->tpl_vars['intRanking']->iteration == 1;$_smarty_tpl->tpl_vars['intRanking']->last = $_smarty_tpl->tpl_vars['intRanking']->iteration == $_smarty_tpl->tpl_vars['intRanking']->total;?>
                                <th class="visible-lg"><?php echo $_smarty_tpl->tpl_vars['intRanking']->value;?>
</th>
                                <?php }} ?>
                                <?php }} ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $_smarty_tpl->tpl_vars['intCountryCount'] = new Smarty_variable(count($_smarty_tpl->tpl_vars['listRanking']->value[$_smarty_tpl->tpl_vars['arrRankingKey']->value[0]])-1, null, 0);?>
                            <?php $_smarty_tpl->tpl_vars['intLoopCount'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['intLoopCount']->step = 1;$_smarty_tpl->tpl_vars['intLoopCount']->total = (int) ceil(($_smarty_tpl->tpl_vars['intLoopCount']->step > 0 ? $_smarty_tpl->tpl_vars['intCountryCount']->value+1 - (0) : 0-($_smarty_tpl->tpl_vars['intCountryCount']->value)+1)/abs($_smarty_tpl->tpl_vars['intLoopCount']->step));
if ($_smarty_tpl->tpl_vars['intLoopCount']->total > 0) {
for ($_smarty_tpl->tpl_vars['intLoopCount']->value = 0, $_smarty_tpl->tpl_vars['intLoopCount']->iteration = 1;$_smarty_tpl->tpl_vars['intLoopCount']->iteration <= $_smarty_tpl->tpl_vars['intLoopCount']->total;$_smarty_tpl->tpl_vars['intLoopCount']->value += $_smarty_tpl->tpl_vars['intLoopCount']->step, $_smarty_tpl->tpl_vars['intLoopCount']->iteration++) {
$_smarty_tpl->tpl_vars['intLoopCount']->first = $_smarty_tpl->tpl_vars['intLoopCount']->iteration == 1;$_smarty_tpl->tpl_vars['intLoopCount']->last = $_smarty_tpl->tpl_vars['intLoopCount']->iteration == $_smarty_tpl->tpl_vars['intLoopCount']->total;?>
                            <tr>
                                <td class="visible-lg"><?php echo $_smarty_tpl->tpl_vars['countryOption']->value[$_smarty_tpl->tpl_vars['listRanking']->value[$_smarty_tpl->tpl_vars['arrRankingKey']->value[0]][$_smarty_tpl->tpl_vars['intLoopCount']->value][0]['country_id']];?>
</td>
                                <?php $_smarty_tpl->tpl_vars['intCnt'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['intCnt']->step = 1;$_smarty_tpl->tpl_vars['intCnt']->total = (int) ceil(($_smarty_tpl->tpl_vars['intCnt']->step > 0 ? $_smarty_tpl->tpl_vars['intFeedCount']->value+1 - (0) : 0-($_smarty_tpl->tpl_vars['intFeedCount']->value)+1)/abs($_smarty_tpl->tpl_vars['intCnt']->step));
if ($_smarty_tpl->tpl_vars['intCnt']->total > 0) {
for ($_smarty_tpl->tpl_vars['intCnt']->value = 0, $_smarty_tpl->tpl_vars['intCnt']->iteration = 1;$_smarty_tpl->tpl_vars['intCnt']->iteration <= $_smarty_tpl->tpl_vars['intCnt']->total;$_smarty_tpl->tpl_vars['intCnt']->value += $_smarty_tpl->tpl_vars['intCnt']->step, $_smarty_tpl->tpl_vars['intCnt']->iteration++) {
$_smarty_tpl->tpl_vars['intCnt']->first = $_smarty_tpl->tpl_vars['intCnt']->iteration == 1;$_smarty_tpl->tpl_vars['intCnt']->last = $_smarty_tpl->tpl_vars['intCnt']->iteration == $_smarty_tpl->tpl_vars['intCnt']->total;?>
                                <?php  $_smarty_tpl->tpl_vars['ranking'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ranking']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['listRanking']->value[$_smarty_tpl->tpl_vars['arrRankingKey']->value[$_smarty_tpl->tpl_vars['intCnt']->value]][$_smarty_tpl->tpl_vars['intLoopCount']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ranking']->key => $_smarty_tpl->tpl_vars['ranking']->value) {
$_smarty_tpl->tpl_vars['ranking']->_loop = true;
?>
                                <td class="visible-lg">
                                    <?php if ($_smarty_tpl->tpl_vars['ranking']->value['name']) {?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['ranking']->value['icon_url'];?>
" />
                                    <?php } else { ?>
                                    データを取得できませんでした。
                                    <?php }?>
                                </td>
                                <?php } ?>
                                <?php }} ?>
                            </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  <!-- / Users widget-->


<?php echo $_smarty_tpl->getSubTemplate ((@constant('SMARTY_TEMPLATES_DIR')).('footer.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array('jsfile'=>'ranking/ranking_list.js'), 0);?>
<?php }} ?>
