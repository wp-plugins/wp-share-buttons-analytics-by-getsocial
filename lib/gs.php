<?php

class GS {
    private $gs_url = "https://api.at.getsocial.io";
    private $gs_url_api = "//api.at.getsocial.io";
    private $gs_account = "https://getsocial.io/";
    public $api_url = "https://getsocial.io/api/v1/";
    // private $gs_url = "//localhost:3001";
    // private $gs_account = "http://localhost:3000/";
    // private $gs_url_api = "http://localhost:3001";
    // public $api_url = "http://localhost:3000/api/v1/";

    function __construct($api_key, $identifier, $lang){
        $this->api_key = $api_key;
        $this->identifier = $identifier;
        $this->lang = $lang == null ? 'en' : $lang;
    }

    private function api($path) {
        try {
            $r = wp_remote_get($this->api_url.$path, array( 'sslverify' => false ));

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

    function utms($app){
        return '&amp;utm_source=wordpress-user&amp;utm_medium=plugin&amp;utm_term='.get_option('siteurl').'&amp;utm_content='.$app.'&amp;utm_campaign=Wordpress%20Plugin';
    }

    function api_url($path){
        return $this->api_url.$path;
    }

    function getSite(){
        if($this->api_key != ''):
            return $this->api('sites/'.$this->api_key);
        else:
            return null;
        endif;
    }

    function refreshSite($data = null){
        if($data == null){
            $site = (array) $this->getSite();
        } else {
            $site = $data;
        }

        if($site != null):
            $this->save($site);
        endif;
    }

    function save($site_info){
        update_option('gs-identifier', $site_info['identifier']);
        update_option('gs-pro', $site_info['pro']);
        update_option('gs-apps', json_encode($site_info['gs_apps']));
        update_option('gs-ask-review', $site_info['ask_review']);

        update_option('gs-alert-msg', $site_info['alert_msg']);
        update_option('gs-alert-utm', $site_info['alert_utm']);
        update_option('gs-alert-cta', $site_info['alert_cta']);
    }

    function apps($app_name){
        $apps = json_decode(get_option('gs-apps'), true);

        if($apps == null){
            return false;
        } else {
            return (array_key_exists($app_name, $apps) ? $apps[$app_name] : false);
        }
    }

    function is_pro(){
        return get_option('gs-pro');
    }

    function is_active($app_name){
        $app = $this->apps($app_name);

        return (!empty($app) ? $app['active'] == 'true' : false);
    }

    function prop($app_name, $prop){
        $app = $this->apps($app_name);
        return $app[$prop];
    }

    function getLib(){
        $code = <<<EOF
<script type="text/javascript">
    var GETSOCIAL_ID = "$this->identifier";
    var GETSOCIAL_LANG = "$this->lang";
    (function() {
    var po = document.createElement("script"); po.type = "text/javascript"; po.async = true;
    po.src = "$this->gs_url_api/widget/v1/gs_async.js?id="+GETSOCIAL_ID;
    var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(po, s);
    })();
</script>
EOF;
        return $code;
    }


    function getCode($app_name, $price = null, $currency = null){
        switch ($app_name) {
            case 'sharing_bar':
                return '<div class="getsocial gs-inline-group"></div>';
            case 'native_bar':
                return '<div class="getsocial gs-native-bar"></div>';
            case 'custom_actions':
                return '<div class="getsocial gs-custom-actions"></div>';
            case 'social_bar_big_counter':
                return '<div class="getsocial gs-inline-group gs-big-counter"></div>';
            case 'follow_bar':
                return '<div class="getsocial gs-inline-group gs-follow"></div>';
            case 'price_alert':
                return '<div class="getsocial gs-price-alert" data-price="'.$price.'" data-currency="'.$currency.'"></div>';
            default:
                return '';
        }
    }

    function gs_account(){
        return $this->gs_account;
    }

}
