$(document).ready(function() {
    // Show calendar
    $("#show_calendar").on("click", function() {
        $("#calendar").slideToggle();
    })

    // Initiate calendar
    var $calendar = $('#calendar').fullCalendar({
        defaultView: "month",
        // Do not show Saturday/Sunday
        weekends : false,
        // Min/max time
        minTime: "08:00:00",
        maxTime: "18:00:00",
        // Uppercase H for 24-hour clock
        timeFormat: "H:mm",
        slotLabelFormat: "H:mm",
        contentHeight: "auto",
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'agendaWeek, month, listDay, listWeek, listMonth'
        },
        views: {
            listDay: {buttonText: 'list day'},
            listDayFormat: (room) => event.room,
            listWeek: {buttonText: 'list week'},
            listMonth: {buttonText: 'list month'},
        },
        //make clicks and selections possible
        selectable: true,

        //make events editable, globally
        editable: true,
        //callback triggered wehen we click on the event
        eventClick: function(event, jsEvent, view) {
            window.location.href = '/reservations/equipment/'+event.id;

        },
        viewRender: function (view, viewContainer){
            // Clear background image if still lingering
            $(".fc-view-container").addClass("bg-white");
        },
        eventRender: function(event, element) {
        },
        eventAfterAllRender : function( view ) {
            if (view.type == 'listWeek') {
            console.log(view.type + ' change colspan');
            console.log(view)
            var tableSubHeaders = jQuery("td.fc-widget-header");
            console.log(tableSubHeaders);
            var numberOfColumnsItem = jQuery('tr.fc-list-item');
            var maxCol = 0;
            var arrayLength = numberOfColumnsItem.length;
            for (var i = 0; i < arrayLength; i++) {
                maxCol = Math.max(maxCol,numberOfColumnsItem[i].children.length);
            }
            console.log("number of items : " + maxCol);
            tableSubHeaders.attr("colspan",maxCol);
                    }		    
        },

        eventSources: [
            {
                color: "1e9cdb",   
                textColor: '#000000',
                events: current_reservations
            }
        ]
    })
});

// Removes event
function remove_event(id) {
    var remove = confirm("remove event id"+id+"?");
    if (remove == true) {
        $("#calendar").fullCalendar("removeEvents", id);
    }
}
