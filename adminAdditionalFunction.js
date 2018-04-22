function checkAdmin(){

}
function popUpCreationWindow(){
	$("#creationWindow").css("display","block");
	$("#fade2").css("display","block");			    
}

function hideCreationWindow(){
	$("#creationWindow").css("display","none");
	$("#fade2").css("display","none");
}

function popUpCreatedEventsWindow(){
	$("#createdEventsWindow").css("display","block");
	$("#fade1").css("display","block");			    	
}

function hideCreatedEventsWindow(){
	$("#createdEventsWindow").css("display","none");
	$("#fade1").css("display","none");	
}


function createNewEvent(){
	var eventName = document.getElementById("eventName").value;
	var founderName = document.getElementById("founderName").value;
    var type= document.querySelector('input[name="eventType"]:checked').value;// radio button: checked prop.
    var startTime= document.getElementById("startTime").value;
    var endTime = document.getElementById("endTime").value;
    var locationID = document.getElementById("selectLocation").value;
    var brief = document.getElementById("eventBrief").value;
    // console.log(eventName + " " + type + " " + startTime + " " + endTime+ " "+locationID) //debug
    $.post("http://localhost/comp208/PHP/CreateNewEvent.php",
    		{founderName: founderName, eventName: eventName, type: type, startTime: startTime, 
    			endTime: endTime, locationID: locationID,  brief: brief},
    		function(data){
    			console.log(data) //debug
    			$("#creationWindow").html(data);
    		});
    return false;
}

function showLocationOptions(){
	console.log("showAllLocation() called")
	$.post("http://localhost/comp208/PHP/ShowAllLocationID.php",
		function(data){
			$("#selectLocation").html(data);
		});
	console.log("showAllLocation() ends")
}

function getCreatedEventList(){
	console.log("getCreatedEventList() called")
	$.post("http://localhost/comp208/PHP/GetCreatedEventList.php",
		{userID: thisUserID, userName: thisUserName, orderBy: "startTime"},
		function(data){
			$("#createdEventTable").html(data);
			console.log(data);
		});
	console.log("getCreatedEventList() ends")
}