$(document).ready(function() {
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
        contentHeight: "auto",
        header: {
            left: 'prev, next',
            center: 'title',
            right: 'agendaDay, agendaWeek, listDay, listWeek, listMonth'
        },
        views: {
            listDay: {buttonText: 'list day'},
            listWeek: {buttonText: 'list week'},
            listMonth: {buttonText: 'list month'},
        },
        viewRender: function (view, viewContainer){
            // Clear background image if still lingering
            $(".fc-view-container").addClass("bg-white");
        },
        eventSources: [
            {
                color: '#4dc0b5',   
                textColor: '#000000',
                events: [
                    {
                        id: 1,
                        title: 'Event 1',
                        start: '2018-10-30'
                    },
                    {
                        id: 2,
                        title: 'Event 2',
                        start: '2018-10-31'
                    },
                    {
                        id: 3,
                        title: 'Event 3',
                        start: '2018-10-31T08:30:00',
                        end: '2018-10-31T15:30:00',
                    },
                ]
            },
            {
                color: '#fa7ea8',   
                textColor: '#000000',
                events: [
                    {
                        id: 11,
                        title: 'Event 11',
                        start: '2018-11-05'
                    },
                    {
                        id: 12,
                        title: 'Event 12',
                        start: '2018-11-16'
                    },
                    {
                        id: 13,
                        title: 'Event 13',
                        start: '2018-10-31T09:30:00',
                        end: '2018-10-31T17:45:00',
                    },
                ]
            }
        ]
    })
});