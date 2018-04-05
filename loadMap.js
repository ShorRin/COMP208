var map, infoWindow;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 53.405844, lng: -2.965814},
        zoom: 19,
        mapTypeId: 'hybrid', //hybrid,satellite
        //mapType:'hybird',
        heading: 90,
        tilt: 45,
        disableDefaultUI: true
    });
    infoWindow = new google.maps.InfoWindow;
    /*
    map.addListener('click', function(e) {
        placeMarkerAndPanTo(e.latLng, map);
    });
    */
}

/*
//set the marker
function placeMarkerAndPanTo(latLng, map) {
    var marker = new google.maps.Marker({
        position: latLng,
        map: map
    });
    map.panTo(latLng);
    addMarker(latLng);
}
*/

function handleLocationError(browserHasGeolocation, infoWindow, pos) {
    infoWindow.setPosition(pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
    infoWindow.open(map);
}

//add new tags to the map with description
function addSite(locID, inID, startTimePar, endTimePar){      //於：修改了参数，时间变成通过参数传入
    $.post("http://localhost/comp208/PHP/getLocationInfo.php",{locationID: locID},          //於：修改返回值的处理
    function(locInfo){
        thisLoc = locInfo.split(";");
        var locName = thisLoc[0];       //於：字符串转float，考虑数据库修改数据类型
        var thelng = parseFloat(thisLoc[1]);
        var thelat = parseFloat(thisLoc[2]);        //对应myList.js 101行也要修改
        var pos = {
            lat : thelat,
            lng: thelng
        }
        console.log(thelng+","+thelat);
        addMarker(pos, locName, inID, startTimePar, endTimePar);
        map.setCenter(pos);
    });
    
}

//used to add description marker to the map
function addMarker(position, locName, inID, start, end){
    //please convert the content to the contentString here
    var contentString = '<div id="content">'+
        '<div id="siteNotice">'+
        '</div>'+
        '<h1 id="firstHeading" class="firstHeading">'+eventList[inID].eventName+'</h1>'+
        '<div id="bodyContent">'+
        '<p>'+eventList[inID].brief+'</p>'+
        '<p>'+locName+'</p>'+
        '<p>Created by '+eventList[inID].founderName+'</p>'+
        '<p>'+ start + ' - ' + end + '</p>'+
        '</div>'+
        '</div>';

    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });

    var marker = new google.maps.Marker({
        position: position,
        map: map,
        title: 'Uluru (Ayers Rock)'
    })

    marker.addListener('click', function() {
        infowindow.open(map, marker);
    });
}

function viewLocation(){
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}
