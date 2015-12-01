
var bmag_elements = {
	search_choice_template: function(value, choice, elemName) {
		var onclick = "javascript:bmag_elements.close_choice(jQuery(this),'" + elemName + "')";
		return jQuery('<li class="bmag_search_choice" search-value="' + value + '"></li>').html('<span>' + choice + '</span><span class="bmag_close_opt" onclick=' + onclick + '>x</span>');
	},
	multiple_select_interface_events: function(globalParent, elementName) {
		globalParent.find('.bmag_cst_opt').on('mouseenter', function() {
			if (!jQuery(this).hasClass('bmag_option_selected')) {
				jQuery(this).addClass('bmag_highlight');
			}
		});

		globalParent.find('.bmag_cst_opt').on('mouseleave', function() {
			jQuery(this).removeClass('bmag_highlight');
		});

		globalParent.find('.bmag_multi_choices input').on('click', function(e) {
			e.stopPropagation();
			var dropdown = jQuery(this).parent().parent().parent().find('.bmag_multi_drop');
			if (dropdown.hasClass('bmag_multi_drop_hide')) {
				dropdown.removeClass('bmag_multi_drop_hide');
			}
		});


		globalParent.find('.bmag_multi_choices input').on('keypress', function(e) {
			if (e.keyCode == 13) {
				e.preventDefault();
				var dropdown_opt = jQuery(this).parent().parent().parent().find('.bmag_multi_drop li');
				var flag = false;

				dropdown_opt.each(function() {
					if (flag == false && !jQuery(this).hasClass('bmag_option_selected') && !jQuery(this).hasClass('bmag_multi_drop_hide')) {
						jQuery(this).trigger('click');
						jQuery(this).parent().removeClass('bmag_multi_drop_hide');
						flag = true;
					} else {
						return;
					}
				});
				return false;
			}
		});


		globalParent.find('.bmag_multi_choices input').on('focus', function() {
			if (!jQuery(this).parent().parent().hasClass('bmag_multi_focused')) {
				jQuery(this).parent().parent().addClass('bmag_multi_focused');
			}
			jQuery('.bmag_multi_drop').removeClass('bmag_multi_drop_hide');
		});


		globalParent.find('.bmag_multi_choices input').on('focusout', function() {
			if (jQuery(this).parent().parent().hasClass('bmag_multi_focused')) {
				jQuery(this).parent().parent().removeClass('bmag_multi_focused');
			}
		});


		globalParent.find('.bmag_multi_choices input').on('input', function() {
			var search = jQuery(this).val().toLowerCase(),
				custom_select = globalParent.find('.bmag_multi_drop li');

			globalParent.find('.bmag_multi_drop').removeClass('bmag_multi_drop_hide');
			custom_select.each(function() {
				var key = jQuery(this).html().replace(/\s+/g, '').toLowerCase();
				if (key.indexOf(search) != 0) {
					jQuery(this).addClass("bmag_multi_drop_hide");
				} else {
					jQuery(this).removeClass("bmag_multi_drop_hide");
				}
			});
		});


		jQuery('html').on('click', function() {
			globalParent.find('.bmag_multi_drop').addClass('bmag_multi_drop_hide');
		});


		globalParent.find('.bmag_cst_opt').on('click', function() {
			var value = jQuery(this)[0].getAttribute('value');
			var select = jQuery("#" + elementName);
			var custom_select = jQuery(this);
			if (!custom_select.hasClass('bmag_option_selected')) {
				custom_select.addClass('bmag_option_selected');
			} else {
				return;
			}
			var opt = select.find('option').filter('[value=' + value + ']');
			opt.attr('selected', 'selected');
			select.trigger('change');
			custom_select.trigger('mouseleave');
			var text = jQuery(this).text();
			var newElement = bmag_elements.search_choice_template(value, text, elementName);
			var searchField = globalParent.find('.bmag_multi_choices .bmag_search_field');
			searchField.before(newElement);

			globalParent.find('.bmag_multi_choices input').trigger('focus');
		});

		globalParent.find('.bmag_multi_choices').on('click', function() {
			jQuery(this).find('.bmag_search_field input').trigger('focus');
		});

	},
	close_choice: function(btn, elemName) {
		var globalParent = jQuery("#bmag_wrap_" + elemName);
		var select = jQuery("#" + elemName);
		var value = btn.parent().attr('search-value');
		btn.parent().remove();
		select.find('option').filter('[value=' + value + ']').removeAttr('selected');
		select.trigger('change');
		globalParent.find('.bmag_multi_drop li').filter('[value=' + value + ']').removeClass('bmag_option_selected');
	},
}