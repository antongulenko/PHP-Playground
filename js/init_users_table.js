
// This uses the DataTable jQuery enhancement
$(document).ready(function() {
	if ($('#users_table'))
		if ($('#users_table').dataTable)
			$('#users_table').dataTable({
				"aoColumns": [
					null, // username
					{ "sSortDataType": "dom-checkbox" }, // isActivated
					{ "sSortDataType": "dom-checkbox" }, // isAdmin
					{ "sSortDataType": "dom-checkbox" }, // isRoot
					{ "sType": "date-euro" }, // Last Login
					null, // Delete
					null // Reset password
				]});
});
