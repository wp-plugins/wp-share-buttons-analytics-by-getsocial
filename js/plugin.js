function resizeIframe(obj) {
    // obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
}

function forceUpdate(event){
    var data = {
        'action': 'gs_update'
    };

    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    jQuery.post(ajaxurl, data, function(response) { console.log('getsocial.io updated');});
}

function forceUpdateWithValues(){
    jQuery.get(jQuery('main').attr('data-href'), {}, function(response){
        var data = {
            'action': 'gs_update_with_values',
            'response': response
        };

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajaxurl, data , function(response) {
            console.log('getsocial.io updated');
        });
    });
}

var getsocial_window;

// function checkForUpdate(){
//     getsocial_window.postMessage("needs update?", "*");
// }

jQuery('.getsocial-tab').on('click', function(e){
    e.preventDefault();
    $this = jQuery(this);

    if(!$this.hasClass('only-activate')){
        getsocial_window = window.open($this.attr('href'));
    }

    // setInterval('checkForUpdate()', 10000);
    setInterval('forceUpdateWithValues()', 5000);
})

function handleMessage(event){
    currEvent = event.data;

    switch (currEvent){
        case 'publish':
            forceUpdate(currEvent);
            break;
        default:
            break;
    }
}

jQuery(function($){
    jQuery('#api-key-form').submit(function(){
        var data = jQuery(this).serialize();
        jQuery('.notification-bar').hide();

        if(jQuery(this).find('#gs-api-key').val() != 0){
            jQuery(this).find('input').prop('disabled', true);
            jQuery(this).find('.loading-create').addClass('active');
            jQuery(this).find('input[type="submit"]').hide();

            jQuery.post( 'options.php', data).success( function(response){
                jQuery('.loading-create').removeClass('active');
                jQuery('.notification-bar.starting').show();

                setTimeout('window.location.reload();', 3000);
            });
        } else {
            jQuery('.notification-bar').hide();
            jQuery('.notification-bar.gs-error').show().find('p').html('API KEY cannot be blank.');
        }

        return false;
    });

    jQuery('.create-gs-account').on('click', function(e){
        e.preventDefault();

        jQuery('.notification-bar').hide();
        jQuery('.create-gs-account').hide();
        jQuery('.loading-create').addClass('active');

        jQuery.post(jQuery(this).attr('href'), { source: 'wordpress' }, function(data){
            if(data.errors != undefined){
                jQuery('.loading-create').removeClass('active');
                jQuery('.account-info').hide();
                jQuery('.notification-bar.gs-error').show().find('p').html(data.errors[0]);
                jQuery('.api-key').show();
            } else {
                jQuery('#gs-api-key').attr('value', data.api_key);
                jQuery('#api-key-form').trigger('submit');
            }
        });
    });

    if(jQuery('.graphs').length > 0){
        var $graphs = jQuery('.graphs'),
            graph_api = $graphs.attr('data-graph-api');

        $.get(graph_api, function(data){
            $.each(['total_visits', 'total_shares', 'total_leads'], function(i,stat){
                jQuery('.'+stat).html(data[stat]);
            });
        })
    }

    jQuery(document).on('click', '.deactivate', function(e){
        e.preventDefault();

        $this = jQuery(this);

        if(confirm('Are you sure you want to deactivate the application?') == true){
            $.post($this.attr('data-disable-app'), function(data){
                if(window.location.href.match(/delete/)) {
                    window.location.reload();
                } else {
                    window.location = window.location.href+'&delete=1'
                }
            });
        }
    });

    jQuery(document).on('click', '.only-activate', function(e){
        e.preventDefault();

        $.post($(this).attr('href'), function(data){
            window.location = window.location.href+'&update=1'
        });

        return false;
    });

    if (!window.addEventListener){
        window.attachEvent('onmessage', handleMessage);
    } else {
        window.addEventListener('message', handleMessage);
    }

   /** ==================================== *\
     *    HEADER SUBMENU ACTION
     * ===================================== */
    $('.submenu-link > a').on('click', function(e){
        e.stopPropagation();

        var $menu = $(this).next('.submenu-wrapper'),
            $menu_list = $menu.find('.submenu'),
            $link = $(this).closest('.submenu-link'),
            $link_list = $('.submenu-link');

        if( $menu.is(':visible') ){
            $menu_list.removeClass('active');
            $link_list.removeClass('active');
            $menu.stop().delay(200).hide(0);
        } else {
            var $link_active = $('.submenu-link.active'),
                $menu_active = $('.submenu.active');

            $menu_active.removeClass('active');
            $link_active.removeClass('active');
            $menu_active.parent().stop().delay(200).hide(0);

            $menu.stop().show();

            var $menu_height = $menu.find('.submenu').outerHeight();

            $menu.css({ height: $menu_height });
            $menu_list.addClass('active');
            $link.addClass('active');
        }
    });

    $('body').on('click', function(e) {
        var clickedElement = e.target;

        if( $(clickedElement).attr('id') !== 'help' ){
            if($('div.submenu-wrapper').is(':visible')) {
                $('.submenu.active').removeClass('active');
                $('.submenu-link.active').removeClass('active');
                $('div.submenu-wrapper').stop().delay(200).hide(0);
            }
            if( $('.uv-popover').is(':visible') ){
                $('.uv-popover').hide().removeClass().addClass('uv-popover  uv-is-hidden').removeAttr('style id');
            }
        }
    });

    /** ==================================== *\
     *    APP FILTER DROPDOWN
     * ===================================== */
    var app_title_parent = $('#app-title'),
        app_title = app_title_parent.children('span'),
        app_title_text = app_title.html();

    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    function clearFilters() {
        $('div.app-link-wrapper').show();
        $('div.app-group').show();
        app_title.html(app_title_text);
        app_title_parent.removeClass('filter-on');
        $('#clear-filter').hide();
        $('div.app-grid-filter-holder a').addClass('trans');
        $('#app-finder').show();

        // update app title count
        $.each($('.app-group'), function(i, group){
            $(group).find('.app-group-title h2 span').html("(" + $(group).find('.app-link-wrapper').length + " Apps)");
        });
    }

    function filterApps() {

        var filters = [],
            title = '',
            categoryFilter = '';

        $('div.app-grid-titles-wrapper').show();
        $('div.app-link-wrapper').hide();

        $('div.app-grid-filter-holder').find('a').each(function(i, el) {
            var filter = $(el).data('filter'),
                filterIsActive = !$(el).hasClass('trans'),
                isCategoryFilter = $(el).parent().attr('id') === 'app-filter-dropdown',
                filter_name = filter === 'two' ? 'starter' : filter;

            if(typeof(filter) === 'undefined') return;

            if(filterIsActive){
                filters.push('filter-' + filter);

                if(title.length > 0) title += '<i class="fa fa-plus"></i>';

                if(isCategoryFilter) {
                    categoryFilter = filter;

                    title += '<span class="filter-primary gs-tooltip">' + capitalizeFirstLetter(filter_name) + ' Apps';
                    title += "<div>";
                    title += 'Apps that are <strong>related to ' + capitalizeFirstLetter(filter_name) + '</strong>';
                } else {
                    title += '<span class="filter-' + filter + ' gs-tooltip">' + capitalizeFirstLetter(filter_name) + ' Apps';
                    title += "<div>";
                    title += filter === 'nocode' ? "Apps that <strong>require no code</strong> to be installed" : "Apps that are only available in the <strong>" + capitalizeFirstLetter(filter_name)  + " Plan</strong>";
                }

                title += "</div></span>";
            }
        });

        if(filters.length > 0) {
            $('div.app-link-wrapper.' + filters.join('.')).show();
            $('div.app-link-wrapper.' + filters.join('.')).parents('.app-group').first().show();
            app_title_parent.addClass('filter-on');
            app_title.html(title.replace('_', ' '));
            $('#clear-filter').show();
            $('#app-finder').hide();
        } else {
            clearFilters();
        }

        $.each($('.app-group'), function(i, group){

            var selectedApps = $(group).find('.app-link-wrapper').filter(function () { 
                return this.style.display == 'block'; 
            });
            
            if (selectedApps.length == 0) {
                $(group).hide();
            } else {
                $(group).find('.app-group-title h2 span').html("(" + selectedApps.length + " Apps)");
            }
        });
    }

    $('div.app-grid-filter-holder').find('a:not(#app-filter):not(.gs-error)').on('click', function() {
        var enableFilter = $(this).hasClass('trans'),
            isCategoryFilter = $(this).parent().attr('id') === 'app-filter-dropdown';

        // disable other filters
        if(isCategoryFilter) {
            $('div.app-grid-filter-holder').find('a:not(#app-filter):not(.gs-error)').each(function(i, el) { $(el).addClass('trans') });
        }

        if(enableFilter) {
            $(this).removeClass('trans');

            if(isCategoryFilter) { $('#app-filter').removeClass('trans'); }
        } else {
            $(this).addClass('trans');

            if(isCategoryFilter) { $('#app-filter').addClass('trans'); }
        }

        filterApps();
    });

    $('#clear-filter').on('click', function() {
        clearFilters();
    });

    /** ==================================== *\
     *    APP GRID TOGGLE
     * ===================================== */
    if( $('.app-group').length > 0 ){
        $('.app-group-title').find('a').on('click', function(){
            var group_toggle = $(this),
                group_parent = group_toggle.closest('.app-group'),
                group_body = group_parent.find('.app-group-body');

            group_toggle.find('i').toggleClass('fa-minus-square fa-plus-square');
            group_parent.toggleClass('active');
            group_body.slideToggle(250);
        });
    }

    /** ==================================== *\
     *    ALERT CLOSE BUTTON
     * ===================================== */
    $('.alert-block').children('.close').on('click', function(){
        var wrap = $(this).closest('.alert-block');

        if(wrap.length === 1){
            wrap.remove();
        } else {
            $(this).remove();
        }
    });

    /** ==================================== *\
     *    SCROLL TO TOP
     * ===================================== */
    $('#gs-backToTop').on('click', function(){
        $('html, body').animate({ scrollTop: 0 }, 400);
    });

    /** ==================================== *\
     *    MODAL ACTION
     * ===================================== */
    function modal(trigger){
        $(trigger).on('click', function(){
            var modal_link = $(this).attr('id'),
                modal_id = '#' + modal_link + '-modal';

            if( !$(modal_id).hasClass('active') ){
                $(modal_id).removeClass('hide').addClass('active');
                $('body').addClass('no-scroll');
            }
        });
    }
    modal('#settings');

    $('.modal-close').on('click', function(){
        $('.modal-wrapper.active').stop().removeClass('active').addClass('rewind').delay(700).queue(function(){
            $(this).removeClass('rewind').addClass('hide');
            $('body').removeClass('no-scroll');
            $.dequeue(this);
        });
    });

    forceUpdateWithValues();
});
