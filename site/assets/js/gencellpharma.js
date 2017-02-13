var GencellpharVM = function () {
	self = this;
	self.resultPath = ko.observable();
	self.resultList = ko.observableArray();
	self.loadResultList = function () {
		jQuery('#loading').modal();
		jQuery.ajax({
	        url: base + 'index.php?option=com_gencellpharma&view=rest&format=json&opt=results',
	        type: 'get',
	        dataType: 'json',
	        contentType: 'application/json;charset=utf-8',
	        success: function (data) {
	        	self.resultList(data);
	        	jQuery('#loading').modal('hide');
	        },
	        error: function (jqXHR, textStatus, errorThrown) {
	        	console.error(errorThrown);
	        	jQuery('#loading').modal('hide');
	        }
        });
	};
	self.verResultado = function (result) {
		self.resultPath(base + 'index.php?option=com_gencellpharma&view=pdf&format=pdf&idr=' + result.id);
		jQuery('#resultModal').modal();
	};
};
jQuery(document).ready(function ($) {
	var gencellPharVM = new GencellpharVM();
	gencellPharVM.loadResultList();
	ko.applyBindings(gencellPharVM);
});
