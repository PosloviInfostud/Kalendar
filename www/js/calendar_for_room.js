$(document).ready(function() {
    $("#show_calendar").on("click", function() {
        $("#calendar").slideToggle();
    })
    
$('#calendar').fullCalendar({
    defaultView: "agendaWeek",
    // Do not show Saturday/Sunday
    weekends : false,
    // Min/max time
    minTime: "08:00:00",
    maxTime: "18:00:00",
    // Uppercase H for 24-hour clock
    timeFormat: "H:mm",
    slotLabelFormat: "H:mm",
    slotDuration: "00:30:00",
    
    contentHeight: "auto",
    header: {
        left: 'prev, next',
        center: 'title',
        right: 'agendaDay, agendaWeek, listMonth'
    },
    views: {
        listDayFormat: (room) => event.room,
        listMonth: {buttonText: 'list month'},
    },
    //make clicks and selections possible
    viewRender: function (view, viewContainer){
        // Clear background image if still lingering
        $(".fc-view-container").addClass("bg-white");
    },
    eventRender: function(event, element) {
    },
    eventAfterAllRender : function( view ) {
        if (view.type == 'listWeek') {
        // console.log(view.type + ' change colspan');
        // console.log(view)
        var tableSubHeaders = jQuery("td.fc-widget-header");
        // console.log(tableSubHeaders);
        var numberOfColumnsItem = jQuery('tr.fc-list-item');
        var maxCol = 0;
        var arrayLength = numberOfColumnsItem.length;
        for (var i = 0; i < arrayLength; i++) {
            maxCol = Math.max(maxCol,numberOfColumnsItem[i].children.length);
        }
        // console.log("number of items : " + maxCol);
        tableSubHeaders.attr("colspan",maxCol);
                }		    
    },

    eventSources: [
        {
            color: background,   
            textColor: '#000000',
            events: current_reservations
        }
    ]
})
});