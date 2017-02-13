var GencellpharVM = function () {
	self = this;
	self.resultPath = ko.observable();
	self.patients = ko.observableArray();
	self.loadPatientList = function () {
		jQuery('#loading').modal();
		jQuery.ajax({
	        url: base + 'index.php?option=com_gencellpharma&view=rest&format=json&opt=client_list',
	        type: 'get',
	        dataType: 'json',
	        contentType: 'application/json;charset=utf-8',
	        success: function (data) {
	        	self.patients(data);
	        	jQuery('#loading').modal('hide');
	        },
	        error: function (jqXHR, textStatus, errorThrown) {
	        	console.error(errorThrown);
	        	jQuery('#loading').modal('hide');
	        }
        });
	};
	self.resultList = ko.observableArray();
	self.loadResultList = function (patient) {
		jQuery('#loading').modal();
		self.resultPath(undefined);
		jQuery.ajax({
	        url: base + 'index.php?option=com_gencellpharma&view=rest&format=json&opt=client_results&id=' + patient.user_id,
	        type: 'get',
	        dataType: 'json',
	        contentType: 'application/json;charset=utf-8',
	        success: function (data) {
	        	self.resultList(data);
	        	jQuery('#loading').modal('hide');
	        	jQuery('#resultListModal').modal();
	        },
	        error: function (jqXHR, textStatus, errorThrown) {
	        	console.error(errorThrown);
	        	jQuery('#loading').modal('hide');
	        }
        });
	};
	self.verResultado = function (result) {
		self.resultPath(base + 'index.php?option=com_gencellpharma&view=pdf&format=pdf&idr=' + result.id);
	};
};
jQuery(document).ready(function () {
	var gencellPharVM = new GencellpharVM();
	gencellPharVM.loadPatientList();
	ko.applyBindings(gencellPharVM);
});
