var thisUserID;
var thisUserName;
var thisAuthority;

function closeUp() {
    var name = document.getElementById("unamein").value;
    var psw = document.getElementById("pswin").value;
    //the name is in name and password is in psw, call php to verify the identity
    if (name != '' && psw != '') {
        $("#loginButton").text("Connecting...");
        $.post("https://aooblog.me/COMP208/PHP/LogIn.php", {username: name, password: psw}, function (response) {
            console.log(response);
            if (response.includes("100")) {       //response返回字符串格式为000+" 0/1 "+userID or 100+" 0/1 "+userID
                alert("Log in succeed!");
                thisUserID = response.substring(6);
                thisUserName = name;
                thisAuthority = response.substring(4, 5);
                setCookie("userID", thisUserID);     //於：设置了cookie，刷新不会重置登录状态，
                setCookie("userName", thisUserName); //设置cookie使用的jq的方法（在cookie.js）里，没有用php的方法，如要修改，只需要修改cookie.js的方法即可
                setCookie("authority", thisAuthority);
                //於：这个延时感觉没必要啊，就把延时设为0了
                setTimeout("document.getElementById(\"login\").style.display = \"none\"", 0);
                setCurrentDate();       //把当前时间存入cookie
                getDateFilterCookie();      //设置from的值为cookie的时间（今天）
                $(".logout").html(thisUserName);
                initialiseAll();
                /*allLine();
                showAllEventsList();
                showPopularList();*/
            } else {
                if (response.includes("403 USERNAME")) {
                    $("#loginButton").text("Login");    //yu:把按钮文字改回Login
                    document.getElementsByName('unamein')[0].value = "";
                    document.getElementsByName('unamein')[0].placeholder = "this username does not exist";
                    document.getElementsByName('pswin')[0].value = "";
                }
                if (response.includes("403 PASSWORD")) {
                    $("#loginButton").text("Login");    //yu: 把按钮文字改回Login
                    document.getElementsByName('pswin')[0].value = "";
                    document.getElementsByName('pswin')[0].placeholder = "wrong password";
                }
            }
        });
    } else {
        if (name == '') {
            document.getElementsByName('unamein')[0].placeholder = "you did not enter username";
        }
        if (psw == '') {
            document.getElementsByName('pswin')[0].placeholder = "you did not enter password";
        }
        //this line only for test
        //setTimeout("document.getElementById(\"login\").style.display = \"none\"", 3000);
    }
}

function signUp() {
    var name = $("#unamereg").val();
    var psw = $("#pswreg").val();
    var email = $("#emailreg").val();
    var programme = $("#css option:selected").val();

    if (!name || !psw || !email || !programme) {
        if (!name) $("[name=unamereg]")[0].placeholder = "you did not enter username";
        if (!psw) $("[name=pswreg]")[0].placeholder = "you did not enter password";
        if (!email) $("[name=emailreg]")[0].placeholder = "you did not enter email address";
        return;
    }
    $("#signupButton").text("Connecting...");
    $.post("https://aooblog.me/COMP208/PHP/SignUp.php", {
        username: name,
        password: psw,
        email: email,
        programme: programme
    }, function (response) {
        if (response.includes("100"))
            signUpSuccess();
        else if (response.includes("402"))
            signUpFail(response);
        else
            alert(response);
    });

    /*Local Method for if sign successfully*/
    function signUpSuccess() {
        alert("Register succeed!");
        thisUserName = name;
        //setTimeout("document.getElementById(\"login\").style.display = \"none\"", 3000);
        location.reload();
    }

    /*Local Method for the condition if the sign is failed*/
    function signUpFail(response) {
        $("#signupButton").text("Create");
        if (response.includes("USERNAME")) {
            let nameDiv = $("[name=unamereg]")[0];
            nameDiv.value = "";
            nameDiv.placeholder = "the username has been used";
        } else if (response.includes("EMAIL")) {
            console.log("email");
            let emailDiv = $("[name=emailreg]")[0];
            emailDiv.value = "";
            emailDiv.placeholder = "the email address has been used";
        }
    }
}

function changeForm() {
    if (document.getElementById("2").style.display === "none") {
        document.getElementById("2").style.display = "block";
        document.getElementById("1").style.display = "none";
    } else {
        document.getElementById("2").style.display = "none";
        document.getElementById("1").style.display = "block";
    }
}

function initialiseAll() {
    allLine();
    showAllEventsList();
    showPopularList();
    if (getCookie('isSideNavOpen') == 'null' || getCookie('isSideNavOpen') == undefined) {
        setCookie('isSideNavOpen', 'false');
    }
    if (getCookie('currentMenu') == 'null' || getCookie('currentMenu') == undefined) {
        setCookie('currentMenu', 'myListMenu');
    }
    if (getCookie('isSideNavOpen') == 'false') {
        //do nothing
    } else if (getCookie('isSideNavOpen') == 'true') {
        openNav()
    }
    if (getCookie('currentMenu') == 'myListMenu') {
        $(".tablinks#myListButton").attr("class", "tablinks active");
        $("#myListMenu").css("display", "block");    //於：开始时根据cookie显示menu
    } else if (getCookie('currentMenu') == 'allListMenu') {
        $(".tablinks#allListButton").attr("class", "tablinks active");
        $("#allListMenu").css("display", "block");
    } else if (getCookie('currentMenu') == 'popularListMenu') {
        $(".tablinks#popularListButton").attr("class", "tablinks active");
        $("#popularListMenu").css("display", "block");
    }
    if (thisAuthority == "0") {
        $("#createdEventsButton").remove();
        $("#createNewEventButton").remove();
    }
}

function backTo() {
    if (document.getElementById("3").style.display === "none") {
        document.getElementById("3").style.display = "block";
        document.getElementById("1").style.display = "none";
    } else {
        document.getElementById("3").style.display = "none";
        document.getElementById("1").style.display = "block";
    }
}

function sendMail() {
    let email = $("#emailback").val();
    let username = $("#unameback").val();
    $("#sendButton").text("Sending..");
    $.post("https://aooblog.me/COMP208/PHP/changePassword.php", {
        email: email,
        username: username
    }, function (response) {
        if (response.includes("100 true"))
            alert("Please wait for email");
        else{
            $("#sendButton").text("Send");
            alert(response);
        }
            
    });
}