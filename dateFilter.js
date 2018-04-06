function checkDate(){
    console.log($("#fromDate").val()+"+++"+$("#toDate").val());
    var dateArray;
    var from = new Date();
    if($("#fromDate").val()!=""){
        dateArray = $("#fromDate").val().split("-");
        from.setFullYear(dateArray[0],dateArray[1]-1,dateArray[2]);
        from.setHours(0,0,0,0);
    }else{
        from="";
    }
    var to = new Date();
    if($("#toDate").val()!=""){
        dateArray = $("#toDate").val().split("-");
        to.setFullYear(dateArray[0],dateArray[1]-1,dateArray[2]);
        to.setHours(23,59,59,999);
    }else{
        to="";
    }
    $("a[id^='M']").each(function(){              //筛选部分，取<a>且id以M开头的元素
        $(this).parent().hide();        //先全部隐藏
        innerID = $(this).attr("id").substring(1);
        var thisStart = new Date(eventList[innerID].startTime);
        if(from==""){
            if(to==""){ //to,from都未设置，显示全部
                $(this).parent().show();
            }else{      //from未设置，to设置，显示开始时间时间小于to的
                if(thisStart<=to) $(this).parent().show();
            }
        }else {
            if(to==""){ //from设置，to未设置，显示开始时间大于from的
                if(thisStart>=from) $(this).parent().show();
            }else{      //from，to都设置，显示大于from，小于to的
                if(thisStart>=from&&thisStart<=to) $(this).parent().show();
            }
        }
    });
}

function checkDate2(){
    console.log($("#fromDate2").val()+"222"+$("#toDate2").val());
    var dateArray;
    var from = new Date();
    if($("#fromDate2").val()!=""){
        dateArray = $("#fromDate2").val().split("-");
        from.setFullYear(dateArray[0],dateArray[1]-1,dateArray[2]);
        from.setHours(0,0,0,0);
    }else{
        from="";
    }
    var to = new Date();
    if($("#toDate2").val()!=""){
        dateArray = $("#toDate2").val().split("-");
        to.setFullYear(dateArray[0],dateArray[1]-1,dateArray[2]);
        to.setHours(23,59,59,999);
    }else{
        to="";
    }
    console.log(eventList);
    $("a[id^='A']").each(function(){              //筛选部分，取<a>且id以A开头的元素
        $(this).parent().hide();        //先全部隐藏
        innerID = $(this).attr("id").substring(1);
        var thisStart = new Date(allEventsList[innerID].startTime);
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
function setMinMaxDate(number,type){
    if(number==1){
        if(type=="from"){
            $("#toDate").attr('min',$("#fromDate").val());
            setCookie("fromDate",$("#fromDate").val());
        }else if (type == "to"){
            $("#fromDate").attr('max',$("#toDate").val());
            setCookie("toDate",$("#toDate").val());
        }
        checkDate(); 
    }else if(number==2){
        if(type=="from"){
            $("#toDate2").attr('min',$("#fromDate2").val());
            setCookie("fromDate2",$("#fromDate2").val());
        }else if (type == "to"){
            $("#fromDate2").attr('max',$("#toDate2").val());
            setCookie("toDate2",$("#toDate2").val());
        }
        console.log("kjflsfd");
        checkDate2();
    }
       
}
function getDateFilterCookie(){
    $(document).ready(function(){
        $("#fromDate").val(getCookie("fromDate"));
        $("#toDate").val(getCookie("toDate"));
        $("#toDate").attr('min',$("#fromDate").val());
        $("#fromDate").attr('max',$("#toDate").val());
        //for date2
        $("#fromDate2").val(getCookie("fromDate2"));
        $("#toDate2").val(getCookie("toDate2"));
        $("#toDate2").attr('min',$("#fromDate2").val());
        $("#fromDate2").attr('max',$("#toDate2").val());
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
    setCookie("fromDate2",yearStr+"-"+monthStr+"-"+dayStr);
    setCookie("toDate2","");
}