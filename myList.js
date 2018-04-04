var eventList = [];

function allLine(){
    $.post("http://localhost/comp208/PHP/getEventList.php",{userID:thisUserID, orderBy:"startTime", userList:true},
    function(data){
        console.log(data);
        strings = data.split(";");
        for(var i = 0; i<strings.length-1; i++){        //这里i<strings.length-1，去除了那个多出来的空元素
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
        var text = "";
        for(var i = 0; i < eventList.length; i++){
            var thisLocationID = eventList[i].locationID;
            var thisInnerID = eventList[i].innerID;
            var thisEventName = eventList[i].eventName;
            text = text + newLine(thisInnerID, thisEventName, thisLocationID);
        }
        //document.getElementById("showMyList").innerText = text;
        $("#showMyList").html(text);
    });
}

/*function allLine(){                                       //於：注释的两个函数是原函数，有bug
    loadList();                                             //loadList()先被调用，loadList内进行post和php通信
    var text = "";                                          //bug在于这里的post是异步的，php的值还未返回，代码就继续往下走了
    for(var i = 0; i < eventList.length; i++){              //所以eventList会取到空值，此行还有个问题是eventList会比返回的event多一个空元素
            var thisLocationID = eventList[i].locationID;   //多一个空元素原因在于返回的字符串以；结尾，用；分割的时候会把最后的空也分出来
        var thisInnerID = eventList[i].innerID;
        var thisEventName = eventList[i].eventName;
        text = text + newLine(thisInnerID, thisEventName, thisLocationID);
    }
    console.log("adasdsad");
    document.getElementById("showMyList").innerText = text; //这里应该修改html整个元素，修改text会将<li>以字符串形式显示
}

function loadList(){
    $.post("http://localhost/comp208/PHP/getEventList.php",{userID:thisUserID, orderBy:"startTime", userList:true},
        function(data){
        console.log(data);
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

    });
}*/

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