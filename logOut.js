
var justName;
function logOut() {
    window.location.reload();
}

function showTex(){
    justName = document.getElementById("logout").innerText;
    document.getElementById("logout").innerText = "Log Out";
}

function hideTex(){
    document.getElementById("logout").innerText = justName;
}