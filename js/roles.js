		$(document).ready(function(){
			load(1);
		});

		function load(page){
			var q= $("#q").val();
			$("#loader").fadeIn('slow');
			$.ajax({
				url:'./ajax/roles.php?action=ajax&page='+page+'&q='+q,
				 beforeSend: function(objeto){
				 $('#loader').html('<img src="./images/ajax-loader.gif"> Cargando...');
			  },
				success:function(data){
					$(".outer_div").html(data).fadeIn('slow');
					$('#loader').html('');
					
				}
			})
		}

	
		
			function eliminar (id_rol)
		{
			var q= $("#q").val();
		if (confirm("Realmente deseas eliminar el Rol?")){	
		$.ajax({
        type: "GET",
        url: "./ajax/roles.php",
        data: "id_rol="+id_rol,"q":q,
		 beforeSend: function(objeto){
			$("#resultados").html("Mensaje: Cargando...");
		  },
        success: function(datos){
		$("#resultados").html(datos);
		load(1);
		}
			});
		}
		}	
		

