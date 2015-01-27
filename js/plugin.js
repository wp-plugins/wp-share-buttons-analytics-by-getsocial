jQuery(function($) {
  jQuery('#api-key-form').submit(function() {
      var data = jQuery(this).serialize();
      jQuery('.notification-bar').hide();
      jQuery('.api-key').hide();

      jQuery.post( 'options.php', data).success( function(response){
          jQuery('.notification-bar.success').show();

          setTimeout('window.location = window.location.href + "&signup=true"', 3000);
      });
      return false;
  });

  jQuery('.create-gs-account').on('click', function(e){
      e.preventDefault();
      jQuery('.create-account').hide();
      jQuery.post(jQuery(this).attr('href'), { source: 'wordpress' }, function(data){
          if(data.errors != undefined){
              jQuery('.notification-bar.errors').html(data.errors[0]).show();
              jQuery('.api-key').show();
          } else {
              jQuery('#api-key').attr('value', data.api_key);
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
});
