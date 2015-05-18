$(document).ready(function() {
	$("#filter").click(function(){
		var firstname=$("#firstname").val();
		var lastname=$("#lastname").val();
		$.getJSON('actors.php?firstname='+firstname+'&lastname='+lastname,
		function(data) {
			if (data.length == 0){
				alert("The actor name was not found in the database");
			}
			$('select').empty().append('<option>Select an Actor</option>');
			$.each(data, function(key, value){
			$("#names").append("<option onclick='get_main()' class='actor_name'>"+value.first_name+' '+value.last_name+'</option>');		
			});
 		});
	});
});


$(document).ready(function(){
	$("#names").change(get_main);
	function get_main(){
		var check=$('#checkbox').is(':checked');
		var actor_name = this.value;
  		var firstname_lastname = actor_name.split(" ");
  		var firstname = "";
  		for (var i=0; i<(firstname_lastname.length-1); i++){
  			if (i == 0){
  				var firstname = firstname+firstname_lastname[0];
  			}
  			else{
  				var firstname = firstname + " " + firstname_lastname[i];
  			}
  		}
  		var lastname = firstname_lastname[firstname_lastname.length - 1];
  		window.open("search.php?firstname=" + firstname + "&lastname=" + lastname + "&check=" + check);
  	
	}
});