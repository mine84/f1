{include file=$smarty.const.SMARTY_TEMPLATES_DIR|cat:'header.tpl'}

    <!-- Users widget -->
    <div class="row">
        <div class="col-md-12">
            <div id="graph" class="panel panel-cascade">
                <div class="panel-heading text-primary">
                    <h3 class="panel-title"><i class="fa fa-trophy"></i>ランキング</h3>
                </div>
                <div class="panel-body">
                    <form id="ranking_graph_condition" class="form-horizontal" action="{$smarty.const.BASE_URL}apps/detail" method="POST">
                        <div class="panel">
                            <div class="panel-heading"><img src="{$arrAppli.icon_url}" style="width:50px;" />{$arrAppli.name}</div>
                            <div class="panel-heading">
                                <input type="hidden" name="appli_id" value="{$appli_id}" />
                                <input type="hidden" name="os_id" value="{$os_id}" />
                                <input type="hidden" name="country_id" value="{$country_id}" />
                                <input type="hidden" name="category_id" value="{$category_id}" />
                                <div class="form-group">
                                    <div class="col-lg-8 col-md-4">
                                    {html_options name=graph_kind options=$graphKindOption selected=$graph_kind id="graph_kind"}
                                    </div>
                                    {if $graph_kind == 1}
                                    <div class="col-lg-8 col-md-4">
                                    {html_options name=ranking_year options=$yearOption selected=$ranking_year id="ranking_year"}年
                                    {html_options name=ranking_month options=$monthOption selected=$ranking_month id="ranking_month"}月
                                    {html_options name=ranking_date options=$dateOption selected=$ranking_date id="ranking_date"}日
                                    <input type="hidden" name="ranking_time" value="{$ranking_time}" />
                                    </div>
                                    {elseif $graph_kind == 2}
                                    <div class="col-lg-8 col-md-4">
                                    {html_options name=ranking_year options=$yearOption selected=$ranking_year id="ranking_year"}年
                                    {html_options name=ranking_month options=$monthOption selected=$ranking_month id="ranking_month"}月
                                    　　　　　基準時間：{html_options name=ranking_time options=$dateOption selected=$ranking_time id="ranking_time"}時
                                    <input type="hidden" name="ranking_date" value="{$ranking_date}" />
                                    </div>
                                    {/if}
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- <div id="ranking-graph" class="graph col-md-12"></div> -->
                    <div id="highchart_container" class="graph col-md-12" style="height:500px;"></div>
                </div>
            </div>
            <div class="panel panel-cascade">
                <div class="panel-heading text-primary">
                    {if $os_id == $smarty.const.IOS}
                    <h3 class="panel-title"><i class="fa fa-apple"></i> IOS Ranking</h3>
                    {elseif $os_id == $smarty.const.ANDROID}
                    <h3 class="panel-title"><i class="fa fa-android"></i> Android Ranking</h3>
                    {/if}
                </div>
                <div class="panel-body">
                    <div class="panel">
                        <div class="panel-heading">アプリ名</div>
                        <div class="panel-body">{$arrAppli.name}</div>
                        <div class="panel-heading">説明</div>
                        <div class="panel-body">{$arrAppli.content|nl2br}</div>
                    </div>
                </div>
            </div>

        </div>
    </div>  <!-- / Users widget-->

{include file=$smarty.const.SMARTY_TEMPLATES_DIR|cat:'footer.tpl' jsfile='ranking/ranking_detail.js'}