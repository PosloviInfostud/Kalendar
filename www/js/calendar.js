$(document).ready(function() {

    var $calendar = $('#calendar').fullCalendar({
        defaultView: "agendaWeek",
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
            right: 'agendaDay, agendaWeek, month, listDay, listWeek, listMonth'
        },
        views: {
            listDay: {buttonText: 'list day'},
            listWeek: {buttonText: 'list week'},
            listMonth: {buttonText: 'list month'},
        },
        // make clicks and selections possible
        selectable: false,
        // callback triggered when we click on the event
        eventClick: function(event, jsEvent, view) {
            // Load reservation details
            window.location.href = '/reservations/meetings/'+event.id;
        },
        viewRender: function (view, viewContainer){
            // Set calendar background to white
            $(".fc-view-container").addClass("bg-white");
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
        eventSources: sources
    })
});
