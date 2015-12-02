jQuery('document').ready(function(){
  // Add pro banner
  if(!BMAG.is_pro){
    upgrade =  
    '<div class="bmag_pro_banner" style="font-size:16px; margin-top:8px; text-align:left;">'
      +'<a href="'+ BMAG.homepage +'/wordpress-themes/portfolio-gallery.html" target="_blank" style="color:red; text-decoration:none; display:block;">'
        +'<img src="'+BMAG.img_URL +'pro.png" border="0" alt="" width="215" >'
      +'</a>'
    +'</div>';
    jQuery('.preview-notice').append(upgrade);
    // Remove accordion click event
    jQuery('.bmag_pro_banner').on('click', function(e) {
      e.stopPropagation();
    });
  }

  // adding reset button to customizer
  var bmag_customizer_reset_btn = jQuery('<input style="float:right;margin-top:9px;margin-right:5px" type="button" value="Reset" name="reset" id="bmag_reset" class="button">');
  jQuery('#customize-header-actions input').after(bmag_customizer_reset_btn);
  //binding reset onclick event
  jQuery('#bmag_reset').on('click',function(){
    var bmag_spinner = jQuery('#customize-header-actions .spinner').css('visibility','visible');
    jQuery.ajax({
      'type': "POST",
      'url': ajaxurl,
      'data':{
        'wp_customize':'on',
        'action': 'bmag_customizer_reset',
        'bmag_reset_flag' : '1', 
        'nonce' : _wpCustomizeSettings['nonce']['save'],
        'bmag_customizer_reset_nonce' : bmag_customizer['bmag_customizer_reset_nonce']
      },
      success:function(response){
       bmag_spinner.css('visibility','hidden');
       window.location = ( bmag_customizer['bmag_server_name']+bmag_getParameterByName('return'));
      }
    });
  });


});


function bmag_getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


