ej.base.enableRipple(true);

var timepicker = new ej.calendars.TimePicker({
    placeholder: 'Select a time',
    value: new Date(),
    // sets the format property to display the time value in 24 hours format.
    format: 'HH:mm',
    // specify the interval value.
    step: 60
});
timepicker.appendTo('#starttime');

var timepicker2 = new ej.calendars.TimePicker({
    placeholder: 'Select a time',
    value: new Date(),
    // sets the format property to display the time value in 24 hours format.
    format: 'HH:mm',
    // specify the interval value.
    step: 60
});
timepicker2.appendTo('#endtime');
