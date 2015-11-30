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
	this.settingsForm    = this.globalContainer.find('#bmag_settings_form');
	this.resetBtn        = this.globalContainer.find('#bmag_reset_savebar');
	this.saveBtn         = this.globalContainer.find('#bmag_save_savebar');
	this.saveBtnTop      = this.globalContainer.find('#bmag_save_infobar');
	this.saveTabTopBtn   = this.globalContainer.find('#bmag_save_tab_infobar');
	this.resetTabTopBtn   = this.globalContainer.find('#bmag_reset_tab_infobar');

	this.navigationTabs  = this.globalContainer.find('.bmag_nav_tab');
	this.settingsTabs    = this.globalContainer.find('.bmag_settings_tab');
	//binding necessary events
	this.bindEvents();
}

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
	tabname = tabname.split('_')[1];
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

 	this.saveBtn.on('click',function(){
 		controller.submitForm('submit-all');
 	});

	this.saveBtnTop.on('click',function(){
		controller.submitForm('submit-all');
	});

	this.resetBtn.on('click',function(){
		controller.submitForm('reset-all');
	});

	this.resetTabTopBtn.on('click',function(){
		var current_tab = controller.settingsForm.find('#bmag_current_tab').val();
		controller.submitForm('reset-'+current_tab);
	});

	this.saveTabTopBtn.on('click',function(){
		var current_tab = controller.settingsForm.find('#bmag_current_tab').val();
		controller.submitForm('submit-'+current_tab);
	});

	this.settingsForm.submit(function(){
		jQuery(this).ajaxSubmit({
			success: function(response){
				alert();
			}
		});
		return false;
	});
 }

 /*
  * Submits Form and saves all changed options
  *
  */
 bmag_admin_controller.submitForm = function(task){
 	//update hidden field
	this.settingsForm.find('#bmag_task').val(task);
	this.settingsForm.trigger('submit');
 }