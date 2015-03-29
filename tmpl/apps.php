
<h2>
    <i class="fa fa-list"></i>Apps

</h2>
<div class="sub-wrap">
    <div class="app-list">
        <?php // if(!$GS->is_pro()): ?>
        <div class="upgrade">
            <div class="promocode">
                COUPON
                <span>33OFF_4LIFE</span>
                <small>33% discount <b>forever</b>, limited to the first 100 ( only 3 left )</small>
            </div>
            <a href="<?php echo $GS->gs_account() ?>/sites/gs-wordpress/billing/select_tier?api_key=<?= $GS->api_key ?>&amp;source=wordpress" target="_blank" class="btn btn-pro">Upgrade to <b>Pro</b> @ <b>6$</b> / month</a>
        </div>
        <?php // endif; ?>

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
                'Big Total Shares Horizontal' => array(
                    'file' => 'social-bar-big-counter',
                    'active' => $GS->is_active('social_bar_big_counter'),
                    'href' => $GS->gs_account().'/sites/gs-wordpress/big_counter_sharing_bar/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                    'pro' => true,
                    'desc' => "Increase engagement by showing the total number of shares in a big counter on the left of your horizontal share bar."
                ),
                'Big Total Shares Floating' => array(
                    'file' => 'floating-bar-big-counter',
                    'active' => $GS->is_active('floating_bar_big_counter'),
                    'href' => $GS->gs_account().'/sites/gs-wordpress/big_counter_floating_bar/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                    'pro' => true,
                    'desc' => "Increase engagement by showing the total number of shares in a big counter on top of your floating share bar."
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
                'Welcome Bar' => array(
                    'file' => 'welcome-bar',
                    'active' => $GS->is_active('welcome_bar'),
                    'href' => $GS->gs_account().'/sites/gs-wordpress/welcome_bars/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                    "desc" => "Easily lead your visitors to a specific link. Great to generate conversions, engage with promotions and increase traffic. No code needed."
                ),
                'Subscriber Bar' => array(
                    'file' => 'subscriber-bar',
                    'active' => $GS->is_active('subscriber_bar'),
                    'pro' => true,
                    'href' => $GS->gs_account().'/sites/gs-wordpress/subscribe_bars/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                    "desc" => "Easily capture emails from your visitors by providing them with an engaging top bar. Export data to your favorite CRM or e-Mail marketing software."
                ),
            );

            foreach($apps as $app => $settings):
        ?>

        <div class="app-wrapper">
            <img src="<?php echo plugins_url( '../images/'.$settings['file'].'.png', __FILE__ ) ?>" alt="">


            <div class="title">
                <div class="info">
                    <?php if($settings['active']): ?>
                        <div class="app-status done">Installed</div>
                    <?php endif; ?>

                    <?php if( isset($settings['pro']) && $settings['pro'] ): ?>
                        <div class="app-status pro">Pro</div>
                    <?php else: ?>
                        <div class="app-status free">Free</div>
                    <?php endif; ?>

                </div>
                <?php echo $app ?>
                <p><?php echo $settings['desc'] ?></p>
            </div>
            <div class="app-link-buttons app-type-edit">
                <a class="getsocial-tab" href="<?php echo $settings['href'] ?>" target="_blank">
                    <?php echo ($settings['active']) ? '<i class="fa fa-edit"></i>Edit' : '<i class="fa fa-plus"></i>Add' ?>
                </a>
            </div>

        </div>

        <?php endforeach; ?>

    </div>
</div>
