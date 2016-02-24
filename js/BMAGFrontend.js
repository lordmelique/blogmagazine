var BMAGFrontendController = function(){};
var BMAGFrontend = {
	
}

BMAGFrontendController.primaryMenu = function(args){
		if( typeof args.container == 'undefined' ){
			return;
		}
		var _this = this;
		this.container = args.container;
		this.menuItems = this.container.children().filter('.menu-item');
		this.eventRegister = function(){

		}

		this.eventRegister();
};


jQuery(document).ready(function(){
	
	BMAGFrontend.primaryMenu = new BMAGFrontendController.primaryMenu({
			container : jQuery('#bmag-primary-menu')
		});

});
