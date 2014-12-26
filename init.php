<? include('tmpl/header.php'); ?>
<? include('tmpl/alerts.php'); ?>

<div class="wrap">
    <?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == true): ?>
        <div id="message" class="updated below-h2">
            <p>Preferences updated with success</p>
        </div>
    <?php endif; ?>


    <?php if(get_option('gs-api-key') == ''): ?>

        <div id="steps" class="form-content">
            <div class="step">
                <h1>Thanks for downloading the GetSocial Plugin!</h1>
                <p>Just one more thing... To get started, you will need an API KEY.</strong></p>

                <div class="info gs-clearfix">
                    <dl class="gs-clearfix">
                        <dt>URL</dt>
                        <dd><?= get_option('siteurl') ?></dd>
                        <dt>Email</dt>
                        <dd><?= get_option('admin_email') ?></dd>
                    </dl>

                    <p class="create-account">
                        <a href="<?php echo $GS->getGSAccount() ?>/api/v1/sites/create?source=wordpress&amp;email=<?php echo get_option('admin_email') ?>&amp;url=<?php echo get_option('siteurl') ?>" class="button button-primary create-gs-account">
                            Get my API KEY!
                        </a>
                    </p>

                    <div class="notification-bar success green-cta hidden">
                        Congratulations! You are ready to start in 3..2..1..
                    </div>

                    <div class="notification-bar errors red-cta hidden">
                    </div>

                    <div class="api-key hidden">
                        <form id="api-key-form" method="post" action="options.php">
                            <?php settings_fields( 'getsocial-gs-settings' ); ?>
                            <?php do_settings_sections( 'getsocial-gs-settings' ); ?>
                            <p>Please go to your Getsocial Account and get your API KEY in the site options page.</p>
                            <input id="api-key" type="text" name="gs-api-key" size="60" value="" />
                            <?php submit_button('Save Changes'); ?>
                        </form>
                    </div>
                </div>





            </div>

        </div>

    <?php else: ?>

        <?php if( !isset($_GET['tab']) ): ?>

            <?php include('tmpl/basic_stats.php') ?>

            <?php include('tmpl/apps.php') ?>

        <?php else: ?>

            <?php include('tmpl/'.$_GET['tab'].'.php') ?>

        <?php endif; ?>
    <?php endif; ?>
</div>
