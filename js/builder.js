var groupBuilder = {

    updateCode: function(options){
        var code_template = '&lt;div class="gs-group"\n \t\tdata-template="TEMPLATE:SIZE"\n \t\tdata-networks="NETWORKS"\n \t\tdata-counter="COUNTER"\n \t\tdata-url="[URL_TO_SHARE]">&lt;/div>';

        code_template = code_template.replace('TEMPLATE', options.template);
        code_template = code_template.replace('NETWORKS', options.networks);
        code_template = code_template.replace('SIZE', options.size);
        code_template = code_template.replace('COUNTER', options.counter);

        jQuery('#gs-group-code').html(code_template);
    },

    updatePreview: function(options){
        var template = options.template,
            size = options.size,
            networks = options.networks,
            has_counter = options.counter,
            has_counter = has_counter == '' || has_counter == 'false' ? 0 : 1,
            $elem = jQuery('#reaction-preview .gs-group');

        $elem.html('');

        if($elem.attr('class').match(/gs-template\d/) != null) {
            template_to_remove = $elem.attr('class').match(/gs-template\d/)[0]
            $elem.removeClass(template_to_remove);
        }

        $elem.addClass(template);
        $elem.removeClass('gs-small gs-medium gs-large').addClass(size);

        jQuery.each(networks.split(','), function(i,netw){
            if(netw == ''){ return; }

            providers = {
                'fb': ['facebook', 'share', false],
                'tw': ['twitter', 'tweet', true],
                'pn': ['pinterest', 'pin', true],
                'gp': ['google-plus', 'share', true]
            }

            d = document.createElement('div');
            b = document.createElement('a');
            i = document.createElement('i');

            pre_tracking = providers[netw][2];
            provider = providers[netw][0];
            paction = providers[netw][1];

            b.setAttribute('class', netw+' gs-tracking '+'gs-'+provider+'-'+paction+' '+(pre_tracking ? '' : 'gs-post-tracking'));
            b.setAttribute('data-provider', provider);
            b.setAttribute('data-action', paction);
            b.setAttribute('href', '#');

            b.innerHTML = i.outerHTML+'<span>'+provider+'</span>';

            d.innerHTML = b.outerHTML;

            if(has_counter){
                counter = document.createElement('span');
                counter.setAttribute('class', 'gs-counter');
                counter.innerHTML = parseInt(Math.random()*100);

                d.innerHTML += counter.outerHTML;
            }

            $elem.append(d);
        });

    },

    refresh: function(){
        // var $form = jQuery('#group-builder'),
            options = {
                template: jQuery('#group_template').val(),
                networks: jQuery.map(jQuery('.group-network'), function(val, i){
                    if(jQuery(val).is(':checked')){
                        return jQuery(val).attr('rel');
                    }
                }).join(','),
                size: jQuery('#group_size').val(),
                counter: jQuery('input[name="gs-group-counter"]:checked').val() == 'Y' ? 'true' : 'false'
            };

        this.updatePreview(options);
        this.updateCode(options);
    }

}

jQuery(function(){
    $group_builder = jQuery('#group-builder');
    if($group_builder.size() > 0){

        groupBuilder.refresh();

        jQuery('#group-builder input, #group-builder select').on('change', function(){
            groupBuilder.refresh();
        })

        jQuery('input.ntw').on('change', function(event){
            groupBuilder.refresh();
        });
    }


});
