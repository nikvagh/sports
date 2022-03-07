//   function confirmDelete(nm,id,frm) {

// 		     // var r = confirm("Press a button!");
// 		     var html  = '<div class="modal-dialog">'+
// 		          '<div class="modal-content">'+
// 		            '<div class="modal-header">'+
// 		            '<h4 class="modal-title">Large Modal</h4>'+
// 		            '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
// 		                              '<span aria-hidden="true">&times;</span>'+
// 		              '</button>'+
// 		            '</div>'+
		        
// 		            '<div class="modal-body">'+
// 		              '<div id="modal_error"></div>'+
// 		              '<p>Are you sure to delete this '+nm+'</p>'+
// 		            '</div>'+
		        
// 		            '<div class="modal-footer with-border">'+
// 		              '<button type="button" class="btn btn-default " data-dismiss="modal">Cancel</button>'+
// 		              '<button onclick="delete_items(\''+frm+'\',\''+id+'\')" class="btn btn-danger send_btn" > Delete</button>'+
// 		            '</div>'+
// 		          '</div>'+
// 		        '</div>';

// 		      $('#confirm_model').html(html);
// 		  	$('#confirm_model').modal('show');
//    }
	
//    function delete_items(frm,id) {
// 			// $("#id").val(id);
// 			// $("#action").val("delete");
// 			$("#"+frm).submit();
// }


const ADMIN = 'admin';

function confirmDelete(id, item_name, action)
{
	var csrf = $('meta[name="csrf-token"]').attr('content');

	// console.log(id);
	// console.log(item_name);
	// return false;
	var html  = '<div class="modal-dialog">'+
					
					'<div class="modal-content">'+
						'<form id="deleteForm">'+
							'<input type="hidden" name="_token" value="'+csrf+'">'+
							'<input type="hidden" name="_method" value="delete">'+
							'<div class="modal-header">'+
								'<h5 class="modal-title">Delete Confirmation</h5>'+
								'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
									'<span aria-hidden="true">&times;</span>'+
								'</button>'+
							'</div>'+
						
							'<div class="modal-body">'+
								'<div id="modal_error"></div>'+
								'<p class="mb-0">Are you sure to delete this '+item_name+' ?</p>'+
							'</div>'+
							'<input type="hidden" name="id" value="'+id+'">'+
						'</form>'+

						'<div class="modal-footer with-border">'+
							'<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>'+
							'<button type="button" class="btn btn-danger send_btn" onClick="deleteRow(\''+id+'\')"> Delete </button>'+
						'</div>'+
					'</div>'+
					
				'</div>';
	$('#confirm_model').html(html);
	$('#confirm_model').modal('show');
}

function delete_items(frm,id){
	// console.log(frm);
	$("#id").val(id);
	$("#action").val("delete");
	$("#"+frm).submit();
}

function flashAlert(message,status,slideUPTime){
	let classes = '';
	if(status == 'success'){
		classes = 'success-popup';
	}
	if(status == 'error' || status == 'danger' || status == 'validation'){
		classes = 'validation-popup';
	}

	$('.'+classes+' span').html(message);

	if(typeof(slideUPTime) == 'undefined'){
		$('.'+classes).fadeTo(3000, 500);
	}else{
		$('.'+classes).fadeTo(3000, 500).slideUp(slideUPTime);
	}
}

function cancel(url){
    window.location.replace(url);
}

function btn_disable(status,className,text){
	$('.'+className).html(text);
	if(status){
		$('.'+className).css('pointer-events', 'none');
	}else{
		$('.'+className).css('pointer-events', 'auto');
	}
}

function getLatLongWithMap() {
	const map = new google.maps.Map(document.getElementById("map"), {
		center: { lat: 25.354, lng: 51.183 },
		zoom: 8,
		mapTypeId: "roadmap",
	});
	// Create the search box and link it to the UI element.
	const input = document.getElementById("pac-input");
	const searchBox = new google.maps.places.SearchBox(input);
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
	// Bias the SearchBox results towards current map's viewport.
	map.addListener("bounds_changed", () => {
		searchBox.setBounds(map.getBounds());
	});
	let markers = [];
	// Listen for the event fired when the user selects a prediction and retrieve
	// more details for that place.
	searchBox.addListener("places_changed", () => {
		const places = searchBox.getPlaces();

		if (places.length == 0) {
			return;
		}
		// Clear out the old markers.
		markers.forEach((marker) => {
			marker.setMap(null);
		});
		markers = [];
		// For each place, get the icon, name and location.
		const bounds = new google.maps.LatLngBounds();
		places.forEach((place) => {
			if (!place.geometry) {
				console.log("Returned place contains no geometry");
				return;
			}
			const icon = {
				url: place.icon,
				size: new google.maps.Size(71, 71),
				origin: new google.maps.Point(0, 0),
				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25),
			};
			// Create a marker for each place.
			markers.push(
				new google.maps.Marker({
					map,
					icon,
					title: place.name,
					position: place.geometry.location,
				})
			);

			if (place.geometry.viewport) {
				// Only geocodes have viewport.
				bounds.union(place.geometry.viewport);
			} else {
				bounds.extend(place.geometry.location);
			}
		});
		map.fitBounds(bounds);
	});

	map.addListener("click", (mapsMouseEvent) => {
		// lat_long = JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2);
		coordinates = mapsMouseEvent.latLng.toJSON();
		$("#latitude").val(coordinates.lat);
		$("#longitude").val(coordinates.lng);
	});

	// ==========================
}

// setTimeout(() => {
// 	$(".alert-dismissible").hide("slow");
// }, 3000);


function ajaxCall(url,method,datatype,data,headers){
	// console.log(base_url);
	return $.ajax({
		url: url,
		method: method,
		headers: headers,
		cache: false,
		contentType: false,
		processData: false,
		async: false,
		dataType: datatype,
		data: data,
		// success: function(result){
		//   // sendNotificationResult(result);
		//   console.log(result);
		//   // return result;
		// }
	});
}

function ajaxCall1(url,method,datatype,data,headers){
	// console.log(base_url);
	return $.ajax({
		url: url,
		method: method,
		headers: headers,
		cache: false,
		contentType: false,
		processData: false,
		async: false,
		dataType: datatype,
		data: data,
		// success: function(result){
		//   // sendNotificationResult(result);
		//   console.log(result);
		//   // return result;
		// }
	});
}

function userAuth(data){
	if(data.status == 401){
		window.location.reload();
	}
}

setTimeout(function() {
	$('.flashAlertOnLoad').slideUp(1000);
}, 3000);

$(document).on("submit", "#form", function(e) {
	console.log('submit');
    e.preventDefault();
    $('[name="submit"]').trigger('click');
});

const getEventsBYGame = (game_id,target_id) => {
    var call = ajaxCall('/'+ADMIN+'/events/eventsBYGame/'+game_id, 'get', 'json', [], []);
    userAuth(call);
    if (call.status == 200) {
      let response = call.responseJSON;

	  //   console.log(response);
      $("#"+target_id).find('option').remove().end()
                    .append($("<option></option>")
                    .attr("value", '')
                    .text('Select Event')); 
      response.result.events.forEach(element => {
        $("#"+target_id).append($("<option></option>").attr("value", element.id).text(element.name)); 
      });
    }
}

const getTeamsBYEvent = (game_id,target_class) => {
    var call = ajaxCall('/'+ADMIN+'/teams/teamsByEvent/'+game_id, 'get', 'json', [], []);
    userAuth(call);
    if (call.status == 200) {
      let response = call.responseJSON;

	    // console.log(response);
      $("body ."+target_class).find('option').remove().end()
                    .append($("<option></option>")
                    .attr("value", '')
                    .text('Select Team')); 
      response.result.teams.forEach(element => {
        $("."+target_class).append($("<option></option>").attr("value", element.id).text(element.team.name)); 
      });
    }
}

const getStadiumsByEvent = (event_id,target_class) => {
    var call = ajaxCall('/'+ADMIN+'/stadiums/stadiumsByEvent/'+event_id, 'get', 'json', [], []);
    userAuth(call);
    if (call.status == 200) {
      	let response = call.responseJSON;

	    console.log(response);
		$("body ."+target_class).find('option').remove().end()
						.append($("<option></option>")
						.attr("value", '')
						.text('Select Stadium'));
		response.result.stadiums.forEach(element => {
			$("."+target_class).append($("<option></option>").attr("value", element.id).text(element.name)); 
      	});
    }
}

const getAwardsByEvent = (event_id,target_class) => {
    var call = ajaxCall('/'+ADMIN+'/eventAwards/eventAwardsByEvent/'+event_id, 'get', 'json', [], []);
    userAuth(call);
    if (call.status == 200) {
      	let response = call.responseJSON;

	    // console.log(response);
		$("body ."+target_class).find('option').remove().end()
						.append($("<option></option>")
						.attr("value", '')
						.text('Select Award'));
		response.result.eventAwards.forEach(element => {
			$("."+target_class).append($("<option></option>").attr("value", element.id).text(element.title)); 
      	});
    }
}

const getPlayersByEvent = (event_id,target_class) => {
    var call = ajaxCall('/'+ADMIN+'/eventTeamPlayers/eventTeamPlayersByEvent/'+event_id, 'get', 'json', [], []);
    userAuth(call);
    if (call.status == 200) {
      	let response = call.responseJSON;

	    console.log(response);
		$("body ."+target_class).find('option').remove().end()
						.append($("<option></option>")
						.attr("value", '')
						.text('Select Award'));
		response.result.eventTeamPlayers.forEach(element => {
			$("."+target_class).append($("<option></option>").attr("value", element.id).text(element.player.name)); 
      	});
    }
}

const getRoleByGame = (game_id,target_class) => {
    var call = ajaxCall('/'+ADMIN+'/playerRoles/roleByGame/'+game_id, 'get', 'json', [], []);
    userAuth(call);
    if (call.status == 200) {
      	let response = call.responseJSON;

	    console.log(response);
		$("body ."+target_class).find('option').remove().end()
						.append($("<option></option>")
						.attr("value", '')
						.text('Select Role'));
		response.result.playerRoles.forEach(element => {
			$("."+target_class).append($("<option></option>").attr("value", element.id).text(element.name)); 
      	});
    }
}
