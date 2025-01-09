$(document).ready(function () {
  function currentTime() {
    var date = new Date();
    var day = date.getDay();
    var hour = date.getHours();
    var min = date.getMinutes();
    var sec = date.getSeconds();
    var month = date.getMonth();
    var currDate = date.getDate();
    var year = date.getFullYear();
    var monthName = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];
    var showDay = $('.dayDiv span')
    var midDay= "AM"
    midDay = (hour>=12)? "PM":"AM";
    hour = (hour==0)?12:((hour<12)? hour:(hour-12));
    hour = updateTime(hour);
    min = updateTime(min);
    sec = updateTime(sec);
    currDate= updateTime(currDate);
    $("#time").html(`${hour}:${min}`);
    $("#sec").html(`${sec}`);
    $("#med").html(`${midDay}`);
    $("#full-date").html(`${monthName[month]} ${currDate} ${year}`);
    showDay.eq(day).css('opacity','1')
  }
  updateTime = function(x){
    if(x<10){
      
      return "0"+x
    }
    else{
      
      return x;
    }
    
  }
  setInterval(currentTime,1000);
});
