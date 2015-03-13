<?php include('tmpl/header.php'); ?>
<?php include('tmpl/alerts.php'); ?>

<div class="wrap">
    <?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == true): ?>
        <div id="message" class="updated below-h2">
            <p>Preferences updated with success</p>
        </div>
    <?php endif; ?>


    <?php if(get_option('gs-api-key') == ''): ?>

        <div id="steps" class="form-content">
            <div class="step">
                <h1>Welcome and thanks for downloading GetSocial’s Share Buttons with Analytics.</h1>
                <p>To get started click on the button below to automatically create a GetSocial account.</strong></p>

                <p class="example">
                    <span>A few seconds away from this...</span><br/>
                    <img src="<?php echo plugins_url( '/images/big_total_horizontal.png', __FILE__ ) ?>" alt="">
                </p>

                <div class="info gs-clearfix">
                    <dl class="gs-clearfix">
                        <dt>URL</dt>
                        <dd><?php echo get_option('siteurl') ?></dd>
                        <dt>Email</dt>
                        <dd><?php echo get_option('admin_email') ?></dd>

                    </dl>

                    <p class="create-account">
                        <a href="<?php echo $GS->gs_account() ?>/api/v1/sites/create?source=wordpress&amp;email=<?php echo get_option('admin_email') ?>&amp;url=<?php echo get_option('siteurl') ?>" class="button button-primary create-gs-account">
                            Create your FREE account
                        </a>

                        <span class="loading-create">
                            <i class="fa fa-circle-o-notch fa-spin"></i> Creating Account...
                        </span>
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

            <?php if( isset($_GET['update']) ||  isset($_GET['delete'])  ): ?>
                <div class="notification-bar green-cta" id="success-message">
                    <p>App <?= isset($_GET['update']) ? 'updated' : 'deactivated' ?> with success</p>
                </div>
            <?php endif; ?>

            <?php include('tmpl/apps/'.$_GET['tab'].'.php') ?>

        <?php endif; ?>
    <?php endif; ?>
</div>
