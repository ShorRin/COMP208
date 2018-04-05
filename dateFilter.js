function checkDate(){
    console.log($("#fromDate").val()+"+++"+$("#toDate").val());
    setCookie("fromDate",$("#fromDate").val());
    setCookie("toDate",$("#toDate").val());
    var dateArray;
    var from = new Date();
    if($("#toDate").val()!=""){
        dateArray = $("#fromDate").val().split("-");
        from.setFullYear(dateArray[0],dateArray[1]-1,dateArray[2]);
        from.setHours(0,0,0,0);
    }
    var to = new Date();
    if($("#toDate").val()!=""){
        dateArray = $("#toDate").val().split("-");
        to.setFullYear(dateArray[0],dateArray[1]-1,dateArray[2]);
        to.setHours(23,59,59,999);
    }
    $("a[id^='M']").each(function(){              //筛选部分，取<a>且id以M开头的元素
        $(this).parent().hide();        //先全部隐藏
        innerID = $(this).attr("id").substring(1);
        var thisStart = new Date(eventList[innerID].startTime);
        console.log(innerID);
        if(from==""){
            if(to==""){ //to,from都未设置，显示全部
                $(this).parent().show();
            }else{      //from未设置，to设置，显示开始时间时间小于to的
                if(thisStart<=to) $(this).parent().show();
            }
        }else{
            if(to==""){ //from设置，to未设置，显示开始时间大于from的
                if(thisStart>=from) $(this).parent().show();
            }else{      //from，to都设置，显示大于from，小于to的
                if(thisStart>=from&&thisStart<=to) $(this).parent().show();
            }
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