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
	this.saveBtnTop    = this.globalContainer.find('#bmag_save_infobar');
	this.resetBtnTop   = this.globalContainer.find('#bmag_reset_infobar');
	
	//binding necessary events
	this.bindEvents();
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
 		controller.submitForm('save');
 	});

	this.saveBtnTop.on('click',function(){
		controller.submitForm('save');
	});

	this.resetBtn.on('click',function(){
		controller.submitForm('reset');
	});

	this.resetBtnTop.on('click',function(){
		controller.submitForm('reset');
	});
 }

 /*
  * Submits Form and saves all changed options
  *
  */
 bmag_admin_controller.submitForm = function(task){
 	//update hidden field
	this.settingsForm.find('#bmag_task').val(task);
	this.settingsForm.submit();
 }