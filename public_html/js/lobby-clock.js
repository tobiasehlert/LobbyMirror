$(document).ready(function() {
    // Create two variable with the names of the months and days in an array
    var monthNames = [ "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" ]; 
    var dayNames= [ "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday" ];

    setInterval( function() {
        // Create a newDate() object and extract the XXX of the current time on the visitor's
        var seconds = new Date().getSeconds();
        var minutes = new Date().getMinutes();
        var hours = new Date().getHours();

        var date = new Date();
            date.setDate(date.getDate());

        // Add a leading zero to XXX value
        $( "#lw-date-sec" ).html( ( seconds < 10 ? "0" : "" ) + seconds );
        $( "#lw-date-min" ).html( ( minutes < 10 ? "0" : "" ) + minutes );
        $( "#lw-date-hours" ).html( ( hours < 10 ? "0" : "" ) + hours );

        $( "#lw-date-name" ).html( dayNames[date.getDay()] + ', week ' + date.getWeek() );
        $( "#lw-date-date" ).html( date.getDate() + ' ' + monthNames[date.getMonth()] + ' ' + date.getFullYear() );
    },1000);
});

Date.prototype.getWeek = function() {
  var date = new Date(this.getTime());
   date.setHours(0, 0, 0, 0);
  // Thursday in current week decides the year.
  date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7);
  // January 4 is always in week 1.
  var week1 = new Date(date.getFullYear(), 0, 4);
  // Adjust to Thursday in week 1 and count number of weeks from date to week1.
  return 1 + Math.round(((date.getTime() - week1.getTime()) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
}