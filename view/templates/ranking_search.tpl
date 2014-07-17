{include file=$smarty.const.SMARTY_TEMPLATES_DIR|cat:'header.tpl'}

    <!-- Users widget -->
    <div class="row">
        <div class="col-md-12">
            <div id="graph" class="panel panel-cascade">
                <div class="panel-heading text-primary">
                    <h3 class="panel-title"><i class="fa fa-search"></i>検索</h3>
                </div>
                <div class="panel-body">

                        <div class="panel">
                            <div class="panel-heading">
                                <form id="ranking_search" class="form-horizontal" action="{$smarty.const.BASE_URL}apps/search" method="POST">
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-4">
                                    <input type="text" name="search_word" class="form-control" size="20" placeholder="Search Appli Name." style="width: 30%; float: left;" />
                                    <button type="button" class="btn btn-success" style="margin-left: 20px;">検索</button>
                                    </div>

                                </div>
                                </form>
                            </div>
                            <div class="panel-body">
                                <table class="table users-table table-condensed table-hover" >
                                    <thead>
                                        <tr>
                                            <th class="visible-lg">OS</th>
                                            <th class="visible-lg">国</th>
                                            <th class="visible-lg" >アプリ名</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {if $arrAppli}
                                        {foreach from=$arrAppli key=appliKey item=appli}
                                        <tr>
                                            <td class="visible-lg">{$osOption[$appli.os_id]}</td>
                                            <td class="visible-lg">{$arrCountry[$appli.country_id]}</td>
                                            <td class="visible-lg">
                                                {if $appli.name}
                                                <a href="{$smarty.const.BASE_URL}apps/detail?appli_id={$appli.appli_id}&os_id={$appli.os_id}&country_id={$appli.country_id}&ranking_year={$appli.ranking_year}&ranking_month={$appli.ranking_month}&ranking_date={$appli.ranking_date}">{$appli.name}</a>
                                                {/if}
                                            </td>
                                        </tr>
                                        {/foreach}
                                        {/if}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>  <!-- / Users widget-->

{include file=$smarty.const.SMARTY_TEMPLATES_DIR|cat:'footer.tpl' jsfile='ranking/ranking_search.js'}