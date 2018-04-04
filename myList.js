var eventList = [];

function loadList(){
    $.post("http://localhost/comp208/PHP/getMyList.php",{userID:thisUserID, orderBy:"startTime"},data);
    strings = data.split(";");
    for(var i = 0; i<strings.length; i++){
        thisEvent = strings[i].split(",");
        var event = {
            innerID: i,
            eventID: thisEvent[0],
            eventName: thisEvent[1],
            founderName: thisEvent[2],
            startTime: thisEvent[3],
            endTime: thisEvent[4],
            popularity: thisEvent[5],
            locationID: thisEvent[6],
            brief: thisEvent[7],
            isAcademic: thisEvent[8]
        }
        eventList.push(event);
    }
}


    function allLine(){
        loadList();
        var text = "";
        for(var i = 0; i < eventList.length; i++){
            var thisLocationID = eventList[i].locationID;
            var thisInnerID = eventList[i].innerID;
            var thisEventName = eventList[i].eventName;
            text = text + newLine(thisInnerID, thisEventName, thisLocationID);
        }
        document.getElementById("showMyList").innerText = text;
    }

    function thisTime(id){
        document.getElementById(id).innerText = eventList[id].startTime + " - " + eventList[id].endTime;
    }

    function godef(id){
        document.getElementById(id).innerText = eventList[id].eventName;
    }

    function deleEvent(id) {
        $.post("http://localhost/comp208/PHP/DelEvent.php",{userID:thisUserID, eventID:eventList[id].eventID},data);
        allLine();
    }

    function newLine(thisInnerID, thisEventName, thisLocationID){
        var hereID = "M"+thisInnerID;
        var quest = "<li><a id= "+hereID+" onclick=\"addSite("+thisLocationID+","+thisInnerID+")\" onmouseover=\"thisTime("+hereID+")\" onmouseout=\"godef("+hereID+")\" ondblclick= \"deleEvent(" + thisInnerID + ")\">"+thisEventName+"</a></li>";
        return quest;
    }