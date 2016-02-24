$(document).ready(function() {
	
	$('#positionId').hide();
	$('#positionId').attr("required", false);
	$('#positionDrop').change(function () {
		var selectedId = $( "#positionDrop option:selected").get(0).id ;
		if(selectedId == "adminDrop" || selectedId == "managerDrop")
		{
			$('#positionId').attr("required", true);
			$('#positionId').show();
		}
		else
		{	
			$('#positionId').attr("required", false);
			$('#positionId').hide();
		}
		
    });
});