<?php
    $has_custom_social_actions = !(get_option('gs-api-key') != '' && get_option('gs-elements') == '{}' );
    if(!$has_custom_social_actions): ?>
    <div class="notification-bar blue-cta">
        <p>You haven’t created any social action yet. Create your first action button now.</p>
        <a href="http://getsocial.io" target="_blank">Create Social Actions</a>
    </div>
<?php endif; ?>

<form id="config-form" method="post" action="options.php">
    <?php settings_fields( 'getsocial-gs-custom-expressions' ); ?>
    <?php do_settings_sections( 'getsocial-gs-custom-expressions' ); ?>

    <?php if($has_custom_social_actions): ?>
        <div class="bar-active">
            <a href="http://getsocial.io?source=wordpress" target="_blank" class="gsbutton" >New Custom Expression</a>

            <div class="cl"></div>
        </div>
        <hr />

        <div class="onoff_check">
            <span class="label">Active</span> <input type="checkbox" class="onoff" name="gs-custom-expression-active" value="1" style="display:none" <?php echo (get_option('gs-custom-expression-active') == '1' ? 'checked' : '') ?>/>
        </div>

        <h3>List of created expressions</h3>

        <table class="custom-expressions">
            <?php foreach($GS->getElements() as $identifier => $elem): ?>
            <tr>
                <td><?= $elem ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <div class="bar-active">
            <?php submit_button('Save Changes'); ?>

            <div class="cl"></div>
        </div>
    <?php endif; ?>
