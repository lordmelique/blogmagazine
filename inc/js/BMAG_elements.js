jQuery(document).ready(function(){

	jQuery('.bmag_cst_opt').on('mouseenter',function(){
	   if(!jQuery(this).hasClass('bmag_option_selected')){
	     jQuery(this).addClass('bmag_highlight');
	   }
	 });

	jQuery('.bmag_cst_opt').on('mouseleave',function(){
		jQuery(this).removeClass('bmag_highlight');
	});

	jQuery('.bmag_multi_choices input').on('click',function(e){
		e.stopPropagation();
		var dropdown = jQuery(this).parent().parent().parent().find('.bmag_multi_drop');
		if(dropdown.hasClass('bmag_multi_drop_hide')){
		 dropdown.removeClass('bmag_multi_drop_hide');
		}
	});


	jQuery('.bmag_multi_choices input').on('keypress', function(e) {
		if(e.keyCode==13){
		 e.preventDefault();
		 var dropdown_opt = jQuery(this).parent().parent().parent().find('.bmag_multi_drop li');
		 var flag = false;
		 dropdown_opt.each(function(){
		   if(flag == false && !jQuery(this).hasClass('bmag_option_selected') && !jQuery(this).hasClass('bmag_multi_drop_hide')){
		     jQuery(this).trigger('click');
		     jQuery(this).parent().removeClass('bmag_multi_drop_hide');
		     flag = true;
		   }else{
		     return;
		   }
		   
		 });
		 return false;
		}
	});


	jQuery('.bmag_multi_choices input').on('focus',function(){
		if(!jQuery(this).parent().parent().hasClass('bmag_multi_focused')){
		 jQuery(this).parent().parent().addClass('bmag_multi_focused');
		}
		jQuery('.bmag_multi_drop').removeClass('bmag_multi_drop_hide');
	});

	jQuery('.bmag_multi_choices input').on('focusout',function(){
		if(jQuery(this).parent().parent().hasClass('bmag_multi_focused')){
		 jQuery(this).parent().parent().removeClass('bmag_multi_focused');
		}
	}); 


});

 function bmag_search_choice_template(value,choice,elemName){
           var onclick = "javascript:bmag_close_choice(jQuery(this),'"+elemName+"')";
           return jQuery('<li class="bmag_search_choice" search-value="'+value+'"></li>').html('<span>'+choice+'</span><span class="bmag_close_opt" onclick='+onclick+'>x</span>');
 }
 function bmag_close_choice(btn,elemName){
 		
           var globalParent = jQuery("#bmag_wrap_"+elemName);
           var select = jQuery("#"+elemName);
           var value = btn.parent().attr('search-value');
           btn.parent().remove();
           select.find('option').filter('[value='+value+']').removeAttr('selected');
           select.trigger('change');
           globalParent.find('.bmag_multi_drop li').filter('[value='+value+']').removeClass('bmag_option_selected');
 }  