<form id="config-form" method="post" action="options.php">
    <?php settings_fields( 'getsocial-gs-group' ); ?>
    <?php do_settings_sections( 'getsocial-gs-group' ); ?>

    <div id="dashboard-widgets-wrap">
        <div id="dashboard-widgets" class="metabox-holder">
            <div class="postbox-container" style="width: 50%">

                <!--reaction editor start-->
                <div id="group-builder" class="native-buttons button-editor-no-nav">
                    <div class="onoff_check">
                        <span class="label">Active? </span> <input type="checkbox" class="onoff" name="gs-group-active" value="1" style="display:none" <?php echo (get_option('gs-group-active') == '1' ? 'checked' : '') ?>/>
                    </div>

                    <div class="tab-content" id="config-form" >
                        <!--tab start-->
                        <div class="tab-pane clearfix" id="general-tab">
                            <div class="panel-body inline-editor-opt inline-editor-selector clearfix">
                                <div class="form-group">
                                    <label class="form-title" for="gs-buttons-position">Choose Social Networks</label>

                                    <br/>
                                    <?php
                                    $social = array(
                                        'fb' => array('facebook', 'facebook'),
                                        'tw' => array('twitter', 'twitter'),
                                        'pn' => array('pinterest', 'pinterest'),
                                        'gp' => array('google', 'google-plus')
                                    ); ?>

                                    <?php foreach($social as $key => $value): ?>

                                        <?php
                                        $name = $value[0];
                                        $icon = $value[1];
                                        $option_value_exists = !get_option('gs-group-network-'.$key);
                                        $option_value = get_option('gs-group-network-'.$key);
                                        ?>

                                        <input type="checkbox"
                                                name="gs-group-network-<?php echo $key ?>"
                                                id="gs-group-network-<?php echo $key ?>"
                                                class="ntw group-network"
                                                value="Y"
                                                rel="<?php echo $key ?>"
                                                <?php echo ($option_value == 'Y' || !$option_value_exists ? 'checked' : '') ?>/>

                                        <label for="gs-group-network-<?php echo $key ?>" class="no-padding"><?php echo $name ?></label>

                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <div class="half">
                            <div class="form-group">
                                <label class="form-title" for="gs-buttons-position">Choose Template</label>

                                <?php
                                    $templates = array(
                                        'Square Rounded' => 'gs-template1',
                                        'Rounded' => 'gs-template2',
                                        'Special' => 'gs-template3',
                                        'Basic Grey' => 'gs-template4',
                                        'Basic Black' => 'gs-template5'
                                    )
                                ?>

                                <select id="group_template" name="gs-group-template">
                                <?php foreach($templates as $name => $value): ?>
                                    <option value="<?= $value ?>" <?= get_option('gs-group-template') == $value ? 'selected' : '' ?>><?= $name ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="half gs-clearfix">
                            <div class="form-group">
                                <label class="form-title" for="gs-buttons-position">Choose Size</label>

                                <?php
                                    $sizes = array(
                                        'Small' => 'gs-small',
                                        'Medium' => 'gs-medium',
                                        'Large' => 'gs-large'
                                    )
                                ?>
                                <select id="group_size" name="gs-group-size">
                                <?php foreach($sizes as $name => $value): ?>
                                    <option value="<?php echo $value ?>" <?php echo get_option('gs-group-size') == $value || (!get_option('gs-group-size') && $value == 'gs-large') ? 'selected' : '' ?> ><?php echo $name ?></option>
                                <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="half">
                            <div class="form-group">
                                <label class="form-title" for="gs-buttons-position">Include Counter</label>

                                <label>Yes</label>

                                <input type="radio" value="Y" name="gs-group-counter" <?php echo (get_option('gs-group-counter') == 'Y' || !get_option('gs-group-counter') ? 'checked="checked"' : '') ?> />
                                <label>No</label>
                                <input type="radio" value="N" name="gs-group-counter" <?php echo (get_option('gs-group-counter') == 'N' ? 'checked="checked"' : '') ?> />
                            </div>
                        </div>

                        <div class="half gs-clearfix">
                            <div class="form-group">
                                <label class="form-title" for="gs-buttons-position">Position on post</label>

                                <label>Top</label>
                                <input type="radio" value="1" name="gs-group-position" <?php echo (get_option('gs-group-position') == 1 ? 'checked="checked"' : '') ?> />
                                <label>Bottom</label>
                                <input type="radio" value="0" name="gs-group-position" <?php echo (get_option('gs-group-position') == 0 ? 'checked="checked"' : '') ?> />
                            </div>
                        </div>

                    </div>

                    <div class="cl"></div>
                </div>
            </div>
            <div class="postbox-container" style="width: 50%">
                <fieldset>
                    <legend>Preview</legend>
                    <div id="reaction-preview" class="native-buttons text-center clearfix">
                        <div class="gs-group"></div>
                    </div>
                </fieldset>
            </div>

        </div>
    </div>

    <div class="bar-active">
        <?php submit_button('Save Changes'); ?>

        <div class="cl"></div>
    </div>

</form>
