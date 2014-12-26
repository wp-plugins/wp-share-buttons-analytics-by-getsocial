<h2><i class="fa fa-cog"></i>Custom Actions</h2>

<p class="notification-bar yellow-cta">
    Sorry, in this version you have to build our custom actions in our site editor.
    <a href="http://getsocial.io" target="_blank" class="button"><i class="fa fa-add"></i>New Custom Action</a>
</p>

<?php
    $has_custom_social_actions = !(get_option('gs-api-key') != '' && get_option('gs-elements') == '{}' );
    if(!$has_custom_social_actions): ?>
    <div class="notification-bar blue-cta">
        <p>You haven’t created any social action yet. Create your first action button now.</p>
    </div>

<?php endif; ?>

<form id="custom-bar" method="post" action="options.php">
    <?php settings_fields( 'getsocial-gs-custom-expressions' ); ?>
    <?php do_settings_sections( 'getsocial-gs-custom-expressions' ); ?>

    <?php if($has_custom_social_actions): ?>

        <div class="form-content">
            <h4>Expressions created</h4>
            <table class="custom-expressions">
                <?php foreach($GS->getElements() as $identifier => $elem): ?>
                    <tr>
                        <td><?= $elem ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="form-content">
            <label class="control active">Active</label>
            <div>
                <input type="checkbox" name="gs-custom-expression-active" value="1" <?php echo (get_option('gs-custom-expression-active') == '1' ? 'checked' : '') ?>/>
            </div>
        </div>

        <div class="form-content">
            <label class="control">Position</label>

            <div class="position with-inputs-label">
                <label>Top</label>
                <input type="radio" value="1" name="gs-custom-expression-position" <?php echo (get_option('gs-custom-expression-position') == 1 ? 'checked="checked"' : '') ?> />
                <label>Bottom</label>
                <input type="radio" value="0" name="gs-custom-expression-position" <?php echo (get_option('gs-custom-expression-position') == 0 ? 'checked="checked"' : '') ?> />
            </div>
        </div>

        <div class="bar-active">
            <?php submit_button('Save Changes'); ?>

            <div class="cl"></div>
        </div>

    <?php endif; ?>
</form>
