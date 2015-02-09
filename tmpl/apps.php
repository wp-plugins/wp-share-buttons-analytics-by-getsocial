
<h2>
    <i class="fa fa-list"></i>Apps
    <? if(!$GS->is_pro()): ?>
    <a href="<?= $GS->gs_account() ?>/sites/gs-wordpress/billing/select_tier?api_key=<?= $GS->api_key ?>&amp;source=wordpress" target="_blank" class="btn btn-pro">Upgrade to Pro</a>
    <? endif; ?>
</h2>
<div class="sub-wrap">
    <div class="app-list">
        <?php
            $apps = array(
                'Custom Sharing Actions' => array(
                    'file' => 'custom-actions',
                    'active' => $GS->is_active('custom_actions'),
                    'pro' => true,
                    'href' => $GS->gs_account().'/sites/gs-wordpress/elements/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                    'desc' => "Sometimes we need to say more than a simple 'Like'. Here you'll find more than 50 custom stories such as Awesome, Wish or Love."
                ),
                'Horizontal Sharing Bar' => array(
                    'file' => 'sharing-bar',
                    'active' => $GS->is_active('sharing_bar'),
                    'href' => $GS->gs_account().'/sites/gs-wordpress/groups/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                    'desc' => "Use one of our templates or design your own social sharing bar. Customize size, shape & colour and pick from 15 social networks."
                ),
                'Native Sharing Bar' => array(
                    'file' => 'native-bar',
                    'active' => $GS->is_active('native_bar'),
                    'href' => $GS->gs_account().'/sites/gs-wordpress/native_bar/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                    'desc' => "It doesn't get much more classic than this. Your native sharing buttons with tracking abilities. Great for those who want to keep it real."
                ),
                'Floating Sharing Bar' => array(
                    'file' => 'floating-bar',
                    'active' => $GS->is_active('floating_bar'),
                    'href' => $GS->gs_account().'/sites/gs-wordpress/floating_bar/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                    "desc" => "Use one of our templates or design your own floating sharing bar. Customize size, shape & placement and pick from 15 social networks."
                ),
                'Mobile Sharing Bar' => array(
                    'file' => 'mobile-bar',
                    'active' => $GS->is_active('mobile_bar'),
                    'pro' => true,
                    'href' => $GS->gs_account().'/sites/gs-wordpress/mobile_bar/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                    "desc" => "Mobile Web is one of the fastest growing platform both in traffic and shares. Don't miss out on the opportunity to boost your traffic with our slick mobile web sharing interface. No code needed."
                ),
            );

            foreach($apps as $app => $settings):
        ?>

        <div class="app-wrapper">
            <img src="<? echo plugins_url( '../images/'.$settings['file'].'.png', __FILE__ ) ?>" alt="">


            <div class="title">
                <div class="info">
                    <? if($settings['active']): ?>
                        <div class="app-status done">Installed</div>
                    <? endif; ?>

                    <? if( isset($settings['pro']) && $settings['pro'] ): ?>
                        <div class="app-status pro">Pro</div>
                    <? else: ?>
                        <div class="app-status free">Free</div>
                    <? endif; ?>

                </div>
                <? echo $app ?>
                <p><? echo $settings['desc'] ?></p>
            </div>
            <div class="app-link-buttons app-type-edit">
                <a class="getsocial-tab" href="<?= $settings['href'] ?>" target="_blank">
                    <?php echo ($settings['active']) ? '<i class="fa fa-edit"></i>Edit' : '<i class="fa fa-plus"></i>Add' ?>
                </a>
            </div>

        </div>

        <?php endforeach; ?>

    </div>
</div>
