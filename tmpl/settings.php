         
<form id="config-form" method="post" action="options.php">
    <?php settings_fields( 'getsocial-gs-settings' ); ?>
    <?php do_settings_sections( 'getsocial-gs-settings' ); ?>
    <div class="form-group">
        <label class="form-title" for="api-key">Insert/Update GetSocial API key here</label>
        <div id="api-key-wrap">
            <div id="api-key-field">
                <input id="api-key" type="text" name="gs-api-key" size="80" value="<?php echo get_option('gs-api-key'); ?>" />
                <!-- <div class="badge"><img src="<?php echo plugins_url('images/done.png', __FILE__); ?>" alt=""></div> -->
            </div>
        </div>
    </div>

    <?php if(get_option('gs-api-key') != ''): ?>

    <div class="form-group">
        <label class="form-title" for="gs-buttons-position">Custom Action Button Language</label>
        <select name="gs-lang">
            <option value="en" <?php echo (get_option('gs-lang') == 'en' ? 'selected="selected"' : '') ?>>English</option>
            <option value="es" <?php echo (get_option('gs-lang') == 'es' ? 'selected="selected"' : '') ?>>Spanish</option>
            <option value="pt_PT" <?php echo (get_option('gs-lang') == 'pt_PT' ? 'selected="selected"' : '') ?>>Portuguese (Portugal)</option>
            <option value="pt_BR" <?php echo (get_option('gs-lang') == 'pt_BR' ? 'selected="selected"' : '') ?>>Portuguese (Brazil)</option>
        </select>
    </div>

    <?php endif; ?>

    <div class="bar-active">
        <?php submit_button('Save Changes'); ?>
        <div class="cl"></div>
    </div>
</form>
