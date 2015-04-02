<h1>Install your apps bellow</h1>

<div class="app-grid clearfix">
    <?php
        $apps = array(

            'Horizontal Sharing Bar' => array(
                'file' => 'sharing-bar',
                'active' => $GS->is_active('sharing_bar'),
                'href' => $GS->gs_account().'/sites/gs-wordpress/groups/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                'desc' => "Use one of our templates or design your own social sharing bar. Customize size, shape & colour and pick from 15 social networks."
            ),
            'Mobile Sharing Bar' => array(
                'file' => 'mobile-bar',
                'active' => $GS->is_active('mobile_bar'),
                'pro' => true,
                'href' => $GS->gs_account().'/sites/gs-wordpress/mobile_bar/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                "desc" => "Mobile Web is one of the fastest growing platform both in traffic and shares. Don't miss out on the opportunity to boost your traffic with our slick mobile web sharing interface. No code needed."
            ),
            'Floating Sharing Bar' => array(
                'file' => 'floating-bar',
                'active' => $GS->is_active('floating_bar'),
                'href' => $GS->gs_account().'/sites/gs-wordpress/floating_bar/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                "desc" => "Use one of our templates or design your own floating sharing bar. Customize size, shape & placement and pick from 15 social networks."
            ),
            'Big Total Shares Horizontal' => array(
                'file' => 'social-bar-big-counter',
                'active' => $GS->is_active('social_bar_big_counter'),
                'href' => $GS->gs_account().'/sites/gs-wordpress/big_counter_sharing_bar/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                'pro' => true,
                'desc' => "Increase engagement by showing the total number of shares in a big counter on the left of your horizontal share bar."
            ),
            'Native Sharing Bar' => array(
                'file' => 'native-bar',
                'active' => $GS->is_active('native_bar'),
                'href' => $GS->gs_account().'/sites/gs-wordpress/native_bar/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                'desc' => "It doesn't get much more classic than this. Your native sharing buttons with tracking abilities. Great for those who want to keep it real."
            ),
            'Big Total Shares Floating' => array(
                'file' => 'floating-bar-big-counter',
                'active' => $GS->is_active('floating_bar_big_counter'),
                'href' => $GS->gs_account().'/sites/gs-wordpress/big_counter_floating_bar/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                'pro' => true,
                'desc' => "Increase engagement by showing the total number of shares in a big counter on top of your floating share bar."
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
            'Custom Sharing Actions' => array(
                'file' => 'custom-actions',
                'active' => $GS->is_active('custom_actions'),
                'pro' => true,
                'href' => $GS->gs_account().'/sites/gs-wordpress/elements/new?api_key='.$GS->api_key.'&amp;source=wordpress',
                'desc' => "Sometimes we need to say more than a simple 'Like'. Here you'll find more than 50 custom stories such as Awesome, Wish or Love."
            ),
        );

        foreach($apps as $app => $settings):
    ?>

    <div class="app-link-wrapper">
        <?php if($settings['active']): ?>
            <div class="app-status tooltip">
                <i class="fa fa-check"></i>
                <div>This app is installed</div>
            </div>
        <?php else: ?>
            <?php if( isset($settings['pro']) && $settings['pro'] ): ?>
                <a href="<?php echo $GS->gs_account() ?>/sites/gs-wordpress/billing/select_tier?api_key=<?php echo $GS->api_key ?>&amp;source=wordpress" target="_blank" class="app-link-plan clearfix text-right tooltip plan-pro">
                    Pro <div>This app is only available in the <strong>Pro plan</strong></div>
                </a>
            <?php endif; ?>
        <?php endif; ?>

        <div class="app-link">
            <!-- <div class="app-badge badge-special">New</div> -->
            <div class="app-image">
                <img src="<?php echo plugins_url( '../img/apps/'.$settings['file'].'.png', __FILE__ ) ?>" alt="">
            </div>
            <div class="app-link-info">
                <p class="app-title"><?php echo $app ?></p>
                <p><?php echo $settings['desc'] ?></p>
            </div>
            <div class="app-link-buttons app-type-simple">
                <a href="<?php echo $settings['href'] ?>" target="_blank" class="getsocial-tab">
                    <?php echo ($settings['active']) ? 'Edit App' : 'Install App' ?>
                </a>
            </div>
        </div>
    </div>

    <?php endforeach; ?>
</div>

<footer>
    <a id="backToTop" href="javascript:void(0)" class="button primary"><i class="fa fa-angle-up"></i> Back to Top</a>
    <?php if(!$GS->is_pro()): ?>
    &nbsp;&nbsp;&nbsp;&nbsp;or&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="<?php echo $GS->gs_account() ?>/sites/gs-wordpress/billing/select_tier?api_key=<?php echo $GS->api_key ?>&amp;source=wordpress" target="_blank" class="button plan-pro">Upgrade to Pro</a>
    <?php endif; ?>
</footer>
