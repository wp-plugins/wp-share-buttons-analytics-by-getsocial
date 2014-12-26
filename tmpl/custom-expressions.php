<?php
    $has_custom_social_actions = !(get_option('gs-api-key') != '' && get_option('gs-elements') == '{}' );
    if(!$has_custom_social_actions): ?>
    <div class="notification-bar blue-cta">
        <p>You haven’t created any social action yet. Create your first action button now.</p>
        <a href="http://getsocial.io" target="_blank">Create Social Actions</a>
    </div>
<?php endif; ?>

<div class="editor">
    <form id="config-form" method="post" action="options.php">
        <?php settings_fields( 'getsocial-gs-custom-expressions' ); ?>
        <?php do_settings_sections( 'getsocial-gs-custom-expressions' ); ?>

        <?php if($has_custom_social_actions): ?>

            <div class="half">
                <div class="onoff_check">
                    <span class="label">Active</span> <input type="checkbox" class="onoff" name="gs-custom-expression-active" value="1" style="display:none" <?php echo (get_option('gs-custom-expression-active') == '1' ? 'checked' : '') ?>/>
                </div>

                <div class="tab-content" id="config-form" >
                    <div class="half gs-clearfix">
                        <div class="form-group">
                            <label class="form-title" for="gs-buttons-position">Position on post</label>

                            <label>Top</label>
                            <input type="radio" value="1" name="gs-custom-expression-position" <?php echo (get_option('gs-custom-expression-position') == 1 ? 'checked="checked"' : '') ?> />
                            <label>Bottom</label>
                            <input type="radio" value="0" name="gs-custom-expression-position" <?php echo (get_option('gs-custom-expression-position') == 0 ? 'checked="checked"' : '') ?> />                            
                        </div>
                    </div>
                </div>

                <div class="cl"></div>

                <?php submit_button('Save Changes'); ?>
            </div>

            <div class="half">
                <h3>List of created expressions</h3>

                <table class="custom-expressions">
                    <?php foreach($GS->getElements() as $identifier => $elem): ?>
                    <tr>
                        <td><?= $elem ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>

                <a href="http://getsocial.io?source=wordpress" target="_blank" class="gsbutton" >New Custom Expression</a>
            </div>

        <?php endif; ?>
    </form>
</div>
