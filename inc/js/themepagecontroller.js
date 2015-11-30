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
 		controller.submitForm('submit-all');
 	});

	this.saveBtnTop.on('click',function(){
		controller.submitForm('submit-all');
	});

	this.resetBtn.on('click',function(){
		controller.submitForm('reset-all');
	});

	this.resetTabTopBtn.on('click',function(){
		controller.submitForm('reset-'+bmag_current_tab);
	});

	this.saveTabTopBtn.on('click',function(){
		controller.submitForm('submit-'+bmag_current_tab);
	});

	this.settingsForm.submit(function(){
		jQuery(this).ajaxSubmit({
			success: function(response){
				console.log(response);
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