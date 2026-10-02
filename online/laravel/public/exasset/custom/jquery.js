$(function(){
    $(document).on('keydown','.decimal-num', function(event){

        
		if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190 || event.keyCode == 110) {

		} else {
			event.preventDefault();
		}
		
		if($(this).val().indexOf('.') !== -1 && event.keyCode == 190)
			event.preventDefault();

		if($(this).val().indexOf('.') !== -1 && event.keyCode == 110)
			event.preventDefault();

	});
	
	$(document).on('keydown','.numbers', function(event){

		if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46) {

		} else {
            // Ctrl+C or Cmd+C pressed?
            if ((event.ctrlKey || event.metaKey) && event.keyCode == 67) {

                
            }

            // Ctrl+V or Cmd+V pressed?
            else if ((event.ctrlKey || event.metaKey) && event.keyCode == 86) {
                
            }

            // Ctrl+X or Cmd+X pressed?
            else if ((event.ctrlKey || event.metaKey) && event.keyCode == 88) {
             // Do stuff.
            } else{
                event.preventDefault();
            } 
		}

	});
})