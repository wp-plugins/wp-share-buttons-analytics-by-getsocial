<div id="gs-master-wrapper">
    <?php include('tmpl/header.php'); ?>

    <?php include('tmpl/alerts.php'); ?>

    <main>

        <?php if( isset($_GET['settings-updated']) && $_GET['settings-updated'] == true): ?>

            <div class="notification-bar alert success clearfix small">
                <div class="col-16">
                    <p>Preferences updated successfully</p>
                </div>
            </div>

        <?php endif; ?>

        <?php if(get_option('gs-api-key') == ''): ?>
            <div class="title-wrapper">
                <h1>Welcome and thanks for downloading <span>GetSocial’s Share Buttons with Analytics.</span></h1>
                <p>To get started click on the button below to automatically create a GetSocial account.</strong></p>
            </div>

            <div class="account-info form small">
                <div class="form-content">
                    <div class="field-group">
                        <div class="field-label no-desc">
                            <label for="site-name">URL</label>
                        </div>
                        <div class="field-input">
                            <?php echo get_option('siteurl') ?>
                        </div>
                    </div>
                    <div class="field-group">
                        <div class="field-label no-desc">
                            <label for="site-name">Email</label>
                        </div>
                        <div class="field-input">
                            <?php echo get_option('admin_email') ?>
                        </div>
                    </div>
                </div>
                <div class="form-button-group">
                    <a href="<?php echo $GS->gs_account() ?>/api/v1/sites/create?source=wordpress&amp;email=<?php echo get_option('admin_email') ?>&amp;url=<?php echo get_option('siteurl') ?>" class="button success create-gs-account">Create your account</a>
                    <span class="loading-create button success trans border">
                        <i class="fa fa-refresh rotate"></i> Creating Account...
                    </span>
                </div>
            </div>

            <div class="notification-bar alert success clearfix small hidden">
                <div class="col-16">
                    <p><i class="fa fa-check"></i> <strong>Congratulations!</strong> You are ready to start in 3..2..1..</p>
                </div>
            </div>

            <div class="notification-bar alert error clearfix small hidden">
                <div class="col-16">
                    <p></p>
                </div>
            </div>

            <div class="small">
                <form id="api-key-form" method="post" class="api-key form hidden" action="options.php">
                    <?php settings_fields( 'getsocial-gs-settings' ); ?>
                    <?php do_settings_sections( 'getsocial-gs-settings' ); ?>

                    <div class="form-content">
                        <div class="field-clean">
                            <div class="field-input">
                                <p>Please go to your Getsocial Account and get your API KEY in the site options page.</p>
                                <input id="gs-api-key" type="text" name="gs-api-key" size="60" value="" />
                            </div>
                        </div>
                    </div>
                    <div class="form-button-group">
                        <input type="submit" class="button success" value="Save Changes" />
                    </div>
                </form>
            </div>

        <?php else: ?>

            <?php if( !isset($_GET['tab']) ): ?>

                <?php if(!$GS->is_pro()): ?>
                <div class="alert cta default clearfix simple">
                    <div class="col-16">
                        <p class="alert-title">Use this Coupon <span class="success">33OFF_4LIFE</span> for a 33% discount forever!</p>
                        <p id="info"><strong>This offer is limited to the first 50</strong></p>
                        <a href="<?php echo $GS->gs_account() ?>/sites/gs-wordpress/billing/select_tier?api_key=<?php echo $GS->api_key ?>&amp;source=wordpress" target="_blank" class="button cta pro">Upgrade to PRO @ <strong>6$ / month</strong></a>
                    </div>
                    <!-- <a href="javascript:void(0)" class="close"><i class="fa fa-times"></i></a> -->
                </div>
                <?php endif; ?>

                <?php if( isset($_GET['update']) ||  isset($_GET['delete'])  ): ?>

                    <div class="notification-bar alert global success clearfix simple small">
                        <div class="col-16">
                            <p class="alert-title">App <?php echo isset($_GET['update']) ? 'updated' : 'deactivated' ?> with success</p>
                        </div>
                    </div>

                <?php endif; ?>

                <div class="medium">
                    <?php include('tmpl/apps.php') ?>
                </div>


            <?php else: ?>


                <?php include('tmpl/apps/'.$_GET['tab'].'.php') ?>
            <?php endif; ?>


        <?php endif; ?>

    </main>

    <div id="settings-modal" class="modal-wrapper hide">
        <div class="modal">
            <div class="modal-title">
                <p class="title">Settings</p>
            </div>
            <form id="config-form" method="post" action="options.php" class="form">
                <?php settings_fields( 'getsocial-gs-settings' ); ?>
                <?php do_settings_sections( 'getsocial-gs-settings' ); ?>

                <!-- <div class="notification-bar alert error clearfix small">
                    <div class="col-16">
                        <p>Preferences updated successfully</p>
                    </div>
                </div> -->

                <div class="form-content">
                    <div class="field-group">
                        <div class="field-label no-desc">
                            <label for=""><br>API KEY</label>
                        </div>
                        <div class="field-input">
                            <input type="text" name="gs-api-key" size="60" value="<?php echo get_option('gs-api-key'); ?>" />
                        </div>
                    </div>
                    <div class="field-group">
                        <div class="field-label no-desc">
                            <label for="">Where it appears?</label>
                        </div>
                        <div class="field-input">
                            <div class="one-third">
                                <input type="radio" name="gs-place" value="place-posts" <?php echo (get_option('gs-place') == 'place-posts') ? 'checked' : '' ?> /><label>Only Posts</label>
                            </div>
                            <div class="one-third">
                                <input type="radio" name="gs-place" value="place-pages" <?php echo (get_option('gs-place') == 'place-pages') ? 'checked' : '' ?>/><label>Only Pages</label>
                            </div>
                            <div class="one-third">
                                <input type="radio" name="gs-place" value="place-all" <?php echo (get_option('gs-place') == 'place-all' || get_option('gs-place') == null) ? 'checked' : '' ?>/><label>Pages & Posts</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-button-group">
                    <input type="submit" value="Save Settings" class="button success">
                    <a href="javascript:void(0)" class="button error trans modal-close">Cancel</a>
                </div>
            </form>
        </div>
        <div class="modal-cover modal-close"></div>
    </div>
</div>
