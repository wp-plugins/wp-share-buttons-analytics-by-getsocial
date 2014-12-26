<h2><i class="fa fa-cog"></i>Floating Bar</h2>

<form id="social-bar" method="post" action="options.php">
    <?php settings_fields( 'getsocial-gs-floating' ); ?>
    <?php do_settings_sections( 'getsocial-gs-floating' ); ?>

    <div class="form-content editor-preview">
        <div id="reaction-preview" class="native-buttons text-center clearfix">
            <div class="gs-group"></div>
        </div>
    </div>

    <div class="form-content">
        <label class="control active">Active</label>
        <div class="activate">
            <input type="checkbox" name="gs-floating-active" value="1" <?php echo (get_option('gs-floating-active') == '1' ? 'checked' : '') ?>/>
        </div>
    </div>

    <div class="form-content">
        <label class="control">Social Networks</label>

        <div class="networks with-inputs-label">
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
            $option_value_exists = !get_option('gs-floating-network-'.$key);
            $option_value = get_option('gs-floating-network-'.$key);
            ?>

            <input type="checkbox"
            name="gs-floating-network-<?php echo $key ?>"
            id="gs-floating-network-<?php echo $key ?>"
            class="ntw group-network"
            value="Y"
            rel="<?php echo $key ?>"
            <?php echo ($option_value == 'Y' || !$option_value_exists ? 'checked' : '') ?>/>

            <label for="gs-floating-network-<?php echo $key ?>" class="no-padding"><?php echo $name ?></label>

        <?php endforeach; ?>

        </div>
    </div>

    <div class="form-content">
        <label class="control">Template</label>

        <div class="templates">
            <?php
            $templates = array(
                'Square Rounded' => 'gs-template1',
                'Rounded' => 'gs-template2',
                'Special' => 'gs-template3',
                'Basic Grey' => 'gs-template4',
                'Basic Black' => 'gs-template5'
            )
            ?>

            <select id="group_template" name="gs-floating-template">
                <?php foreach($templates as $name => $value): ?>
                    <option value="<?= $value ?>" <?= get_option('gs-floating-template') == $value ? 'selected' : '' ?>><?= $name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-content">
        <label class="control">Size</label>

        <div class="sizes">
            <?php
            $sizes = array(
                'Small' => 'gs-small',
                'Medium' => 'gs-medium',
                'Large' => 'gs-large'
            )
            ?>
            <select id="group_size" name="gs-floating-size">
                <?php foreach($sizes as $name => $value): ?>
                    <option value="<?php echo $value ?>" <?php echo get_option('gs-floating-size') == $value || (!get_option('gs-floating-size') && $value == 'gs-large') ? 'selected' : '' ?> ><?php echo $name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-content">
        <label class="control">Counter</label>
        <div class="counter with-inputs-label">

            <input type="radio" value="Y" class="has_counter" name="gs-floating-counter" <?php echo (get_option('gs-floating-counter') == 'Y' || !get_option('gs-floating-counter') ? 'checked="checked"' : '') ?> />
            <label>Yes</label>

            <input type="radio" value="N" class="has_counter" name="gs-floating-counter" <?php echo (get_option('gs-floating-counter') == 'N' ? 'checked="checked"' : '') ?> />
            <label>No</label>

        </div>
    </div>

    <div class="form-content">
        <label class="control">Position</label>

        <div class="position with-inputs-label">
            <input type="radio" value="0" name="gs-floating-position" <?php echo (get_option('gs-floating-position') == 0 ? 'checked="checked"' : '') ?> />
            <label>Left</label>

            <input type="radio" value="1" name="gs-floating-position" <?php echo (get_option('gs-floating-position') == 1 ? 'checked="checked"' : '') ?> />
            <label>Right</label>
        </div>

    </div>

    <div class="bar-active">
        <?php submit_button('Save Changes'); ?>

        <div class="cl"></div>
    </div>

</form>
