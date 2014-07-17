{include file=$smarty.const.SMARTY_TEMPLATES_DIR|cat:'header.tpl' jsfile='ranking/ranking_matrix.js'}

    <!-- Users widget -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-heading text-primary">
                    {if $os_id == $smarty.const.IOS}
                    <h3 class="panel-title"><i class="fa fa-apple"></i> IOS Ranking
                    {elseif $os_id == $smarty.const.ANDROID}
                    <h3 class="panel-title"><i class="fa fa-android"></i> Android Ranking
                    {/if}

                    </h3>
                </div>
                <div class="panel-body">
                    <form id="ranking_search_condition" class="form-horizontal" action="{$smarty.const.BASE_URL}apps/topmatrix" method="POST">
                        <div class="form-group">
                            <div class="col-lg-8 col-md-4">
                            OS {html_options name=os_id options=$osOption selected=$os_id id="os_id"}
                            カテゴリー {html_options name=category_id options=$categoryOption selected=$category_id id="category_id"}
                            </div>
                            <div class="col-lg-8 col-md-4">
                            {html_options name=ranking_year options=$yearOption selected=$ranking_year id="ranking_year"}年
                            {html_options name=ranking_month options=$monthOption selected=$ranking_month id="ranking_month"}月
                            {html_options name=ranking_date options=$dateOption selected=$ranking_date id="ranking_date"}日
                            {html_options name=ranking_time options=$timeOption selected=$ranking_time id="ranking_time"}時
                            </div>
                        </div>
                    </form>
                    <div class="panel-heading text-primary">
                        <h3 class="panel-title">
                        {$categoryOption.$category_id} - {$ranking_year}/{$ranking_month}/{$ranking_date} {$ranking_time}:00
                        </h3>
                    </div>
                    <table class="table users-table table-condensed table-hover" >
                        <thead>
                            <tr>
                                {$intFeedCount = 0}
                                {$arrRankingKey = array()}
                                {foreach from=$listRanking key=rankingKey item=ranking}
                                {$arrRankingKey[] = $rankingKey}
                                {$intFeedCount = $intFeedCount + 1}
                                {if $intFeedCount == 1}
                                <th class="visible-lg" colspan="{$smarty.const.DISP_MATRIX_LIMIT + 1}">{$rankingKey}</th>
                                {else}
                                <th class="visible-lg" colspan="{$smarty.const.DISP_MATRIX_LIMIT}">{$rankingKey}</th>
                                {/if}
                                {/foreach}
                                {$intFeedCount = $intFeedCount - 1}
                            </tr>
                            <tr>
                                {for $intCnt=0 to $intFeedCount}
                                    {if $intCnt == 0}
                                        <th class="visible-lg">国</th>
                                    {/if}
                                    {$intRankingCount = $smarty.const.DISP_MATRIX_LIMIT}
                                    {for $intRanking=1 to $intRankingCount}
                                        <th class="visible-lg">{$intRanking}</th>
                                    {/for}
                                {/for}
                            </tr>
                        </thead>
                        <tbody>
                            {$intCountryCount = count($listRanking[$arrRankingKey[0]]) - 1}
                            {foreach from=$countryOption key=countryKey item=countryValue}
                            <tr>
                                <td class="visible-lg">{$countryValue}</td>
                                {for $intCnt=0 to $intFeedCount}
                                    {if count($listRanking[$arrRankingKey[$intCnt]][$countryKey]) == $smarty.const.DISP_MATRIX_LIMIT}
                                        {foreach from=$listRanking[$arrRankingKey[$intCnt]][$countryKey] item=ranking}
                                        <td class="visible-lg tooltips">
                                            {if $ranking.name}
                                                <a data-original-title="{$ranking.name}" data-placement="top" href="{$smarty.const.BASE_URL}apps/detail?appli_id={$ranking.appli_id}&os_id={$ranking.os_id}&country_id={$ranking.country_id}&ranking_year={$ranking.ranking_year}&ranking_month={$ranking.ranking_month}&ranking_date={$ranking.ranking_date}">
                                                    <img src="{$ranking.icon_url}" style="width:50px;" />
                                                </a>
                                            {else}
                                                <img src="{$smarty.const.IMAGE_DIR}/nodate.jpeg" style="width:50px;" />
                                            {/if}
                                        </td>
                                        {/foreach}
                                    {else}
                                        {for $intNoDataCnt=1 to $smarty.const.DISP_MATRIX_LIMIT}
                                        <td class="visible-lg">
                                            <img src="{$smarty.const.IMAGE_URL}/nodata.jpeg" style="width:50px;" />
                                        </td>
                                        {/for}
                                    {/if}
                                {/for}
                            </tr>
                            {/foreach}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>  <!-- / Users widget-->


{include file=$smarty.const.SMARTY_TEMPLATES_DIR|cat:'footer.tpl' jsfile='ranking/ranking_list.js'}