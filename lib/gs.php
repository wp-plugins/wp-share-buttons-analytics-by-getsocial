<?php

class GS {
    private $gs_url = "http://api.at.getsocial.io";
    private $api_url = "http://getsocial.io/api/v1/";

    // private $gs_url = "http://localhost:3001";
    // private $api_url = "http://localhotst:3000/api/v1/";

    function __construct($api_key, $identifier, $elements, $lang){
        $this->api_key = $api_key;
        $this->identifier = $identifier;
        $this->elements = $elements;
        $this->lang = $lang == null ? 'en' : $lang;
    }

    private function api($path) {
        try {
            $r = wp_remote_get($this->api_url.$path, array());

            if(is_wp_error($r)):
                return null;
            endif;

            if ($r['response']['code'] == 200) {
                return json_decode($r['body']);
            } else {
                return null;
            }
        } catch (HttpException $ex) {
            echo "Error: ".$ex;
        }
    }

    function api_url($path){
        return $this->api_url.$path;
    }

    function getElements(){
        return json_decode($this->elements,true);
    }

    function hasElements(){
        return count($this->getElements()) > 0;
    }

    function getSite(){
        if($this->api_key != ''):
            return $this->api('sites/'.$this->api_key);
        else:
            return '3';
        endif;
    }

    function refreshSite(){
        $site = $this->getSite();
        if($site != null):
            $this->save($site);
            update_option('gs-needs-update', 0);
        endif;
    }

    function save($site_info){
        print_r($site_info);
        update_option('gs-identifier', $site_info->identifier);
        update_option('gs-elements', json_encode($site_info->elements));
    }

    function needs_update(){
        // if(get_option('gs-needs-update') == '1'):
        //     return true;
        // endif;

        $site = $this->getSite();

        $needs_update = $site == null ? '2' : $site == '3' ? '3' : '0';

        if($site != null && $needs_update != '3'):
            $needs_update = (json_encode($site->elements) != get_option('gs-elements')) ? '1' : '0';

            update_option('gs-needs-update', $needs_update);
        endif;

        return $needs_update;
    }

    function getLib(){
        $code = <<<EOF
<script type="text/javascript">
    var GETSOCIAL_ID = "$this->identifier";
    var GETSOCIAL_LANG = "$this->lang";
    (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = '$this->gs_url/widget/v1/gs_async.js?id='+GETSOCIAL_ID;
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
    })();
</script>
EOF;
        return $code;
    }

    function getButton($identifier, $action){
        global $post;

        $permalink = esc_url( get_permalink() );
        $title = esc_html( get_the_title() );
        $image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

        $code = <<<EOF
<div class="getsocial gs-expression gs-$identifier"
    data-action="$action"
    data-identifier="$identifier"
    data-url="$permalink"
    data-image="$image"
    data-title="$title">
</div>
EOF;
        return $code;
    }

    function getGroup(){
        $permalink = esc_url( get_permalink() );
        $template = get_option('gs-group-template');
        $size = get_option('gs-group-size');
        $counter = get_option('gs-group-counter') == 'Y' ? 'true' : 'false';
        $position = get_option('gs-group-position');

        $ntw_fb = get_option('gs-group-network-fb');
        $ntw_tw = get_option('gs-group-network-tw');
        $ntw_pn = get_option('gs-group-network-pn');
        $ntw_gp = get_option('gs-group-network-gp');

        $networks = '';
        $networks_available = array('fb', 'tw', 'pn', 'gp');
        foreach($networks_available as $nw):
            if(get_option('gs-group-network-'.$nw) == 'Y'):
                $networks .= ( $networks == '' ? $nw : ','.$nw);
            endif;
        endforeach;

        $code = <<<EOF
<div class="gs-group"
    data-template="$template:$size"
    data-networks="$networks"
    data-counter="$counter"
    data-url="$permalink"></div>
EOF;

        return $code;

    }

    function getFloatingBar(){
        $permalink = esc_url( get_permalink() );
        $template = get_option('gs-floating-template');
        $size = get_option('gs-floating-size');
        $counter = get_option('gs-floating-counter') == 'Y' ? 'true' : 'false';
        $position = get_option('gs-floating-position');
        $floating = ($position == '1' ? 'right' : 'left');

        $ntw_fb = get_option('gs-floating-network-fb');
        $ntw_tw = get_option('gs-floating-network-tw');
        $ntw_pn = get_option('gs-floating-network-pn');
        $ntw_gp = get_option('gs-floating-network-gp');

        $networks = '';
        $networks_available = array('fb', 'tw', 'pn', 'gp');
        foreach($networks_available as $nw):
            if(get_option('gs-floating-network-'.$nw) == 'Y'):
                $networks .= ( $networks == '' ? $nw : ','.$nw);
            endif;
        endforeach;

        $code = <<<EOF
<div class="gs-group"
    data-template="$template:$size"
    data-networks="$networks"
    data-counter="$counter"
    data-floating="$floating"
    data-url="$permalink"></div>
EOF;

        return $code;

    }

}
