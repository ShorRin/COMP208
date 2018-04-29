function alertSweet(title, text) {
    alert(title+"\n"+text);
}

function warnSweet(text) {
    alert("Warn"+"\n"+text);
}

function signUpAlertSweet(afterSignUp) {
    if(!afterSignUp) afterSignUp = function(){/*Do Nothing*/};
    alert("Success\nYou has already Signed Up!");
    alert(showUserGuild());
    afterSignUp();

    function showUserGuild() {
        return "1. Log in\n" +
            "    If you have had an account, you can log in the system by entering valid username and password. There will be a welcome window if you log in the system successfully.\n" +
            "\n" +
            "2. Open list menu\n" +
            "    After logging in to the system, you can click the button at the left of the application to open the menu. The menu consists of three parts: my list, events list and popular list. Each list may contain some events. The menu also has a date filter and a search box, which will help you to find the event you want.\n" +
            "\n" +
            "3. Search using search box and date filter\n" +
            "    You can find events you want by setting the value of date filter and enter text into search box. Those events whose start time is not in the range of date filter and whose name does not contain text in the search box will be hidden. Therefore, you can find the event you want quickly. All three list (my list, events list and popular list) can use this function. Date filter and search box in each list is independent so they will not disturb each other.\n" +
            "\n" +
            "4. Show event details on map\n" +
            "    For each event tab in list menu, you can show details of this event by clicking the event tab. There will be a pin on the map to show the location of this event. You can click the pin to open a box. This box will contain all information about this event. You can also add/remove this event to/from your list using the button in this box.\n" +
            "\n" +
            "5. Check my list\n" +
            "    You can check my list by moving you mouse on the “MYLIST” tab at the top of list menu. My list will show all events that have been added to your personal list. These events are ordered by start time. You can check the time of an event by put your mouse on this event tab. Search box and date filter is available in this list and you can also click the event tab to call “show event details on map” function.\n" +
            "\n" +
            "6. Check events list\n" +
            "    You can check events list by moving you mouse on the “ALL EVENTS” tab at the top of list menu. Event list contains all events that have not been added to your list. These events are ordered by start time. You can check the time of an event by put your mouse on this event tab. Search box and date filter is available in this list and you can also click the event tab to call “show event details on map” function.\n" +
            "\n" +
            "7. Check popular list\n" +
            "    You can check popular list by moving you mouse on the “POPULAR” tab at the top of list menu. Popular list contains all events that have not been added to your list but these events are ordered by popularity. This list is more likely to show those events which are popular among users. Search box and date filter is available in this list and you can also click the event tab to call “show event details on map” function.\n" +
            "\n" +
            "8. Log out\n" +
            "    You can log out by clicking the username tab at the top-right of the interface. After logging out the system, the interface will return the log in page and you need to log in again to use this system.\n" +
            "\n" +
            "9. Check current time\n" +
            "    You can check current time at the bottom-right of the interface. You can also find more detail about current date by clicking that current time tab.\n" +
            "\n" +
            "10. Check current location\n" +
            "    This function will find the rough location of current user using html5 technology and show this location on the map. This function depends on html5 so only web terminal can use it. You can use this function by clicking the “LOCATION” button at the bottom-right of the interface.\n" +
            "\n" +
            "11. Refresh lists and map\n" +
            "    You can reload all three lists and clear all pins on the map by using this function. You can call this function by clicking the “REFRESH” tab at the bottom-right of the interface.\n";
    }
}

function synAlertSweet(title, text, method) {
    alert(title+"\n"+text);
    method();
}

function logoutSweet(exitFunction) {
    var isConfirm = confirm("Exit!?"+"\n"+"Do you want to exit?");
    if(isConfirm){
        exitFunction();
    }else{
        alert("Cancel!"+"\n"+":)");
    }
}