bmag_admin_controller = {};

jQuery(document).ready(function(){
	//initialize controller
	bmag_admin_controller.init();
});

/**
 * Initialize page controls and main variables
 *
 */
bmag_admin_controller.init = function(){
	this.globalContainer = jQuery('#bmag_theme_options');
	this.navigationTabs  = this.globalContainer.find('.bmag_nav_tab');
	this.settingsForm    = this.globalContainer.find('#bmag_settings_form');
	this.settingsTabs    = this.globalContainer.find('.bmag_settings_tab');
	this.resetAllBtn     = this.globalContainer.find('#bmag_reset_savebar');
	this.saveAllBtn      = this.globalContainer.find('#bmag_save_savebar');
	this.resetTabBtn     = this.globalContainer.find('#bmag_reset_tab_infobar');
	this.saveTabBtn      = this.globalContainer.find('#bmag_save_tab_infobar');
	this.saveAllBtnTop   = this.globalContainer.find('#bmag_save_infobar');
	//binding necessary events
	this.bindEvents();
}
/**
 * Switches given tab
 */
bmag_admin_controller.switchTab = function( tabname ){
	//change current tab class
	this.navigationTabs.each( function(){
		if(jQuery( this ).attr( 'id' ) == tabname){
			jQuery( this ).addClass( 'bmag_nav_tab_current' );
		}else{
			jQuery( this ).removeClass( 'bmag_nav_tab_current' );
		}
	});

	//update options
	this.settingsTabs.each( function(){
		if( jQuery( this ).attr( 'tab' ) == tabname ){
			jQuery( this ).addClass( 'bmag_active' );
		}else{
			jQuery( this ).removeClass( 'bmag_active' );
		}
	});

	//update hidden field
	this.settingsForm.find('#bmag_current_tab').val(tabname);
}

/**
 * Opens or Closes settings sections
 */
 bmag_admin_controller.toggleSection = function( section ){
 	var settingsFields = section.parent().find('.bmag_settings_fields'),
 		caret          = section.find('.bmag_section_caret');

 	if(settingsFields.css('display') == 'none'){
 		settingsFields.css('display','block');
 		caret.css('transform','rotate(90deg)');
 	}else{
 		settingsFields.css('display','none');
 		caret.css('transform','rotate(0deg)');
 	}
 }

 /*
  * Binds Events for Settings page controls
  *
  */
 bmag_admin_controller.bindEvents = function(){
 	var controller = this;
 	//bind toggle event
 	jQuery('.bmag_section_title').on('click',function(){
 		controller.toggleSection(jQuery(this));
 	})

 	this.saveAllBtn.on('click',function(){
 		controller.submitForm('save_all');
 	});

	this.saveAllBtnTop.on('click',function(){
		controller.submitForm('save_all');
	});

	this.resetAllBtn.on('click',function(){
		controller.submitForm('reset_all');
	});

	this.resetTabBtn.on('click',function(){
		controller.submitForm('reset_tab');
	});

	this.saveTabBtn.on('click',function(){
		controller.submitForm('save_tab');
	});
 }

 /*
  * Submits Form and saves all changed options
  *
  */
 bmag_admin_controller.submitForm = function(task){
 	//update hidden field
	this.settingsForm.find('#bmag_task').val(task);
	var data = JSON.stringify(this.settingsForm.serializeArray());
	jQuery.ajax({
		type : 'POST',
		url : bmag_admin.ajax_url,
		data : {
			action: 'bmag_form_submit',
			data: data,
			nonce : bmag_admin.bmag_nonce
		},
		success: function(response){
			console.log(response);
		}
	});
 }