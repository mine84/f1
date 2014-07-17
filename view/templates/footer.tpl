            </div> <!-- /.content -->
        </div> <!-- /.box-holder -->
    </div><!-- /.site-holder -->

<!-- Load JS here for Faster site load =============================-->
<script src="{$smarty.const.JS_URL}/jquery-1.10.2.min.js"></script>
<script src="{$smarty.const.JS_URL}/jquery-ui-1.10.3.custom.min.js"></script>
<script src="{$smarty.const.JS_URL}/less-1.5.0.min.js"></script>
<script src="{$smarty.const.JS_URL}/jquery.ui.touch-punch.min.js"></script>
<script src="{$smarty.const.JS_URL}/bootstrap.min.js"></script>
<script src="{$smarty.const.JS_URL}/bootstrap-select.js"></script>
<script src="{$smarty.const.JS_URL}/bootstrap-switch.js"></script>
<script src="{$smarty.const.JS_URL}/jquery.tagsinput.js"></script>
<script src="{$smarty.const.JS_URL}/jquery.placeholder.js"></script>
<script src="{$smarty.const.JS_URL}/bootstrap-typeahead.js"></script>
<script src="{$smarty.const.JS_URL}/application.js"></script>
<script src="{$smarty.const.JS_URL}/moment.min.js"></script>
<script src="{$smarty.const.JS_URL}/jquery.dataTables.min.js"></script>
<script src="{$smarty.const.JS_URL}/jquery.sortable.js"></script>
<script type="text/javascript" src="{$smarty.const.JS_URL}/jquery.gritter.js"></script>
<script src="{$smarty.const.JS_URL}/jquery.nicescroll.min.js"></script>
<script src="{$smarty.const.JS_URL}/skylo.js"></script>
<script src="{$smarty.const.JS_URL}/prettify.min.js"></script>
<script src="{$smarty.const.JS_URL}/jquery.noty.js"></script>
<script src="{$smarty.const.JS_URL}/bic_calendar.js"></script>
<script src="{$smarty.const.JS_URL}/jquery.accordion.js"></script>
<script src="{$smarty.const.JS_URL}/theme-options.js"></script>

<script src="{$smarty.const.JS_URL}/bootstrap-progressbar.js"></script>
<script src="{$smarty.const.JS_URL}/bootstrap-colorpicker.min.js"></script>

<!-- Core Graph File  =============================-->
<script src="{$smarty.const.JS_URL}/raphael-min.js"></script>
<script src="{$smarty.const.JS_URL}/morris-0.4.3.min.js"></script>

    <script type="text/javascript">
    {if $arrRanking}
    var tax_data = {$arrRanking};

    new Morris.Line({
      element: 'ranking-graph',
      data: tax_data,
      xkey: 'ranking_date_time',
      ykeys: {$arrRankingKeys},
      labels: {$arrRankingKeys},
      continuousLine: true,
      ymin: 200,
      ymax: 1,
    });
    {/if}

    $('.tooltips').tooltip({
          selector: "a",
          container: "body"
        });

    $("[data-toggle=popover]").popover();
    </script>

<script src="{$smarty.const.JS_URL}/highcharts.js"></script>
<script src="{$smarty.const.JS_URL}/modules/exporting.js"></script>

    <script type="text/javascript">
        $('#highchart_container').highcharts({
            title: {
                text: 'ランキング',
                x: -20 //center
            },
            // subtitle: {
            //     text: 'Source: WorldClimate.com',
            //     x: -20
            // },
            chart: {
                height: 500,
            },
            xAxis: {
                categories: {$arrHighchartGraphCategoies}
            },
            yAxis: {
                title: {
                    text: 'ランキング'
                },
                max: 200,
                min: 1,
                reversed: true,
                {literal}
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
                {/literal}
            },
            tooltip: {
                valueSuffix: '位'
            },
            legend: {
                layout: 'vertical',
                align: 'center',
                verticalAlign: 'bottom',
                borderWidth: 0
            },
            series: {$arrHighchartRanking}
        });
    </script>


<!-- Core Jquery File  =============================-->
<script src="{$smarty.const.JS_URL}/core.js"></script>

<!-- Page Scripts  =============================-->
<script src="{$smarty.const.JS_URL}/bootstrap-progressbar.js"></script>
<script src="{$smarty.const.JS_URL}/bootstrap-progressbar-custom.js"></script>

{if $jsfile}
<script type="text/javascript" src="{$smarty.const.JS_URL}/{$jsfile}"></script>
{/if}

<!-- google analytics  =============================-->
{literal}
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52116235-1', 'ec2-54-248-42-151.ap-northeast-1.compute.amazonaws.com');
  ga('send', 'pageview');
</script>
{/literal}

</body>

</html>