<h2>
    <i class="fa fa-bar-chart"></i>Stats
    <? $from = date('Y-m-d', strtotime('-8 days')) ?>
    <? $to = date('Y-m-d', strtotime('-1 days')) ?>
    <small>from <strong><? echo $from ?></strong> to <strong><? echo $to ?></strong></small>
    <a href="<?= $GS->gs_account().'/sites/gs-wordpress/analytics/dashboard?api_key='.$GS->api_key.'&amp;source=wordpress' ?>" target="_blank" class="btn btn-default"><i class="fa fa-area-chart"></i>Detailed Stats</a>
</h2>
<div class="sub-wrap">
    <div class="graphs gs-clearfix" data-graph-api="<?php echo $GS->api_url('sites/analytics/'.get_option('gs-api-key')) ?>">
        <div class="graph">
            <h4><i class="fa fa-group"></i>Visits</h4>
            <h3 class="total_visits">...</h5>
        </div>
        <div class="graph">
            <h4><i class="fa fa-share-alt"></i>Shares</h4>
            <h3 class="total_shares">...</h5>
        </div>
        <div class="graph">
            <h4><i class="fa fa-sign-in"></i>Leads</h4>
            <h3 class="total_leads">...</h5>
        </div>
    </div>
    <div class="cl"></div>
</div>
