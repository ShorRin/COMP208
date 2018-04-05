function checkDate(){
    /*$("td#startTime").each(function(){
        $(this).html($(this).html().substr(0,16));
    });
    $("td#endTime").each(function(){
        $(this).html($(this).html().substr(0,16));
    });*/
    console.log($("#fromDate").val()+"+++"+$("#toDate").val());
    setCookie("fromDate",$("#fromDate").val());
    setCookie("toDate",$("#toDate").val());
    var dateArray;
    var from = new Date();
    dateArray = $("#fromDate").val().split("-");
    from.setFullYear(dateArray[0],dateArray[1]-1,dateArray[2]);
    from.setHours(0,0,0,0);
    var to = new Date();
    if($("#toDate").val()!=""){
        dateArray = $("#toDate").val().split("-");
        to.setFullYear(dateArray[0],dateArray[1]-1,dateArray[2]);
        to.setHours(23,59,59,999);
    }else{
        to = "";
    }
    $("td#startTime").each(function(){              //筛选部分，未完成
        $(this).parent().show();
        if(new Date($(this).text())>=from) {	//later than from
            if(to!="" && new Date($(this).text())>to){	//later than from, later than to
                $(this).parent().hide();
            }else{								//later than from, earlier than to
                //do nothing
            }
        }else{								//earlier than from
            $(this).parent().hide();
        }
    });
}
function setMinMaxDate(type){
    if(type=="from"){
        $("#toDate").attr('min',$("#fromDate").val());
        checkDate();
    }else if (type == "to"){
        $("#fromDate").attr('max',$("#toDate").val());
        checkDate();
    }
}
function getDateFilterCookie(){
    $(document).ready(function(){
        $("#fromDate").val(getCookie("fromDate"));
        $("#toDate").val(getCookie("toDate"));
        setMinMaxDate("to");
        setMinMaxDate("from");
    });
}
function setCurrentDate(){
    var now = new Date();
	var yearStr = now.getFullYear();
	var monthStr = now.getMonth()+1;
	if(monthStr<10) monthStr = "0"+monthStr;
	var dayStr = now.getDate();
	if(dayStr<10) dayStr = "0"+dayStr;
	setCookie("fromDate",yearStr+"-"+monthStr+"-"+dayStr);
    setCookie("toDate","");
}