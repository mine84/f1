{include file=$smarty.const.SMARTY_TEMPLATES_DIR|cat:'header.tpl'}

    <!-- Users widget -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel" style="overflow: scroll;">
                <div class="panel-heading text-primary">
                    {if $os_id == $smarty.const.IOS}
                    <h3 class="panel-title"><i class="fa fa-apple"></i> IOS Ranking
                    {elseif $os_id == $smarty.const.ANDROID}
                    <h3 class="panel-title"><i class="fa fa-android"></i> Android Ranking
                    {/if}

                    </h3>
                </div>
                <div class="panel-body">
                    <form id="ranking_transition_condition" class="form-horizontal" action="{$smarty.const.BASE_URL}apps/transition" method="POST">
                        <div class="form-group">
                            <div class="col-lg-10 col-md-4">
                            OS {html_options name=os_id options=$osOption selected=$os_id id="os_id"}
                            国 {html_options name=country_id options=$countryOption selected=$country_id id="country_id"}
                            フィード {html_options name=feed_id options=$feedOption selected=$feed_id id="feed_id"}
                            カテゴリー {html_options name=category_id options=$categoryOption selected=$category_id id="category_id"}
                            表示種別 {html_options name=disp_type options=$dispTypeOption selected=$disp_type id="disp_type"}
                            </div>
                            <div class="col-lg-8 col-md-4">
                            {html_options name=ranking_year options=$yearOption selected=$ranking_year id="ranking_year"}年
                            {html_options name=ranking_month options=$monthOption selected=$ranking_month id="ranking_month"}月
                            {html_options name=ranking_date options=$dateOption selected=$ranking_date id="ranking_date"}日
                            </div>
                        </div>
                    </form>
                    <div class="panel-heading text-primary">
                        <h3 class="panel-title">
                        {$countryOption.$country_id} - {$feedOption.$feed_id} - {$categoryOption.$category_id} - {$ranking_year}/{$ranking_month}/{$ranking_date}
                        </h3>
                    </div>
                    <table class="table users-table table-condensed table-hover" >
                        <thead>
                            <tr>
                                <th class="visible-lg">#</th>
                                {$intRankingCount}
                                {foreach from=$listRanking key=rankingKey item=ranking}
                                {$intRankingCount = $intRankingCount + 1}
                                <th class="visible-lg" colspan="2" style="width:130px;">{$rankingKey}</th>
                                {/foreach}
                            </tr>
                        </thead>
                        <tbody>
                            {counter name=intCnt start=0 skip=1 print=false}
                            {for $intRanking=0 to $smarty.const.DISP_RANKING_LIMIT - 1}
                            <tr>
                                <td class="visible-lg">{counter name=intCnt}</td>
                                {foreach from=$listRanking item=ranking}
                                <td class="visible-lg tooltips">
                                    {if $ranking[$intRanking].name}
                                        {if $disp_type == 1}
                                            <a href="{$smarty.const.BASE_URL}apps/detail?appli_id={$ranking[$intRanking].appli_id}&os_id={$ranking[$intRanking].os_id}&country_id={$ranking[$intRanking].country_id}&ranking_year={$ranking[$intRanking].ranking_year}&ranking_month={$ranking[$intRanking].ranking_month}&ranking_date={$ranking[$intRanking].ranking_date}">
                                                {$ranking[$intRanking].name|truncate:20:'...':true}
                                            </a>
                                        {elseif $disp_type == 2}
                                            <a data-original-title="{$ranking[$intRanking].name}" data-placement="top" href="{$smarty.const.BASE_URL}apps/detail?appli_id={$ranking[$intRanking].appli_id}&os_id={$ranking[$intRanking].os_id}&country_id={$ranking[$intRanking].country_id}&ranking_year={$ranking[$intRanking].ranking_year}&ranking_month={$ranking[$intRanking].ranking_month}&ranking_date={$ranking[$intRanking].ranking_date}">
                                            <img src="{$ranking[$intRanking].icon_url}" style="width:50px;" />
                                            </a>
                                        {/if}
                                </td>
                                <td>
                                    {$ranking[$intRanking].compare}
                                    {else}
                                </td>
                                <td>
                                    データを取得できませんでした。
                                    {/if}

                                </td>

                                {/foreach}
                            </tr>
                            {/for}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  <!-- / Users widget-->


{include file=$smarty.const.SMARTY_TEMPLATES_DIR|cat:'footer.tpl' jsfile='ranking/ranking_transition.js'}