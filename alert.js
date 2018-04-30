function alertSweet(title, text) {
    swal({
        title: title,
        text: text,
        type: "success",
    });
}

function waitSweet(title, text, time, method){
    method = method || function(){/*Do Nothing*/};
    swal({
        title: title,
        text: text,
        type: "success",
        showLoaderOnConfirm: true,
        timer: time,
    },method);
}

function warnSweet(text) {
    swal({
        title: "WARN",
        text: text,
        type: "error",
        confirmButtonColor: "#DD6B55",
    });
}

function signUpAlertSweet(afterSignUp) {
    if(!afterSignUp) afterSignUp = function(){/*Do Nothing*/};
    swal({
            title: "Success",
            text: "You has already Signed Up!",
            confirmButtonText: "Show User Guild",
            closeOnConfirm: false,
            type: "success",
        }, function (){
            alertHtmlSweet("UserGuild", showUserGuild(), afterSignUp);
        }
    );

    function showUserGuild() {
        return "<textarea readonly style='width:100%; height:300px; overflow:scroll';>\n" +
            "1. Log in/log out\n" +
            "\n" +
            "2. Open list menu\n" +
            "   It contains: my list, events list and popular list\n" +
            "\n" +
            "3. Search using search box and date filter\n" +
            "   Please set the value of date filter and enter text into search box.   \n" +
            "\n" +
            "4. Show event details on map(Just click the event tab )\n" +
            "   The pin on the map to show the location of this event.   \n" +
            "   You can also add/remove this event to/from your list using the button in this box.\n" +
            "\n" +
            "6. Check my list/all events list\n" +
            "   Your events are ordered by start time by default and date filter and the search box are available.\n" +
            "\n" +
            "7. Show event details on map\n" +
            "   You can click the event tab to call this function. Available for events from all these lists.\n" +
            "\n" +
            "8. Check popular list\n" +
            "   Popular list contains all events that have not been added to your list ordered by popularity.\n" +
            "\n" +
            "9. Get current time\n" +
            "   More detail about current date by clicking that current time tab.\n" +
            "\n" +
            "10. Get current location\n" +
            "   Click the “LOCATION” button at the bottom-right of the interface to get your location.\n" +
            "\n" +
            "11. Refresh lists and map\n" +
            "   Refresh all three lists and clear all pins on the map." +
            "</textarea>";
    }

}

function alertHtmlSweet(title, text, afterBehavior) {
    swal({
        imageUrl: 'https://unsplash.it/400/200',
        imageWidth: 200,
        imageHeight: 200,
        animation: false,
        title: title,
        type: "info",
        html: text,
    }, afterBehavior);
}

function synAlertSweet(title, text, method) {
    swal({
        title: title,
        text: text,
        type: "info",
        showCancelButton: true,
        closeOnConfirm: false,
        showLoaderOnConfirm: true,
    }, method);
}

function logoutSweet(exitFunction) {
    swal({
            title: "Exit!?",
            text: "Do you want to exit?",
            type: "warning",
            showCancelButton: true,
            closeOnConfirm: false,
            closeOnCancel: false,
        },
        function (isConfirm) {
            if (isConfirm) {
                waitSweet("Exit", "Your will exit!", 1000, exitFunction);
            } else {
                swal("Cancel!", ":)", "error");
            }
        }
    );
}