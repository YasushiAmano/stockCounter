import flatpickr from "flatpickr";
import { Japanese } from "flatpickr/dist/l10n/ja";

const setting = {
    locale: Japanese,
    enableTime: true,
    noCalendar: true,
    dateFormat: "H:i",
    time_24hr: true,
    minTime: "10:00",
    maxTime: "20:00",
};
flatpickr("#event_date", {
    minDate: "today",
    locale: Japanese,
    maxDate: new Date().fp_incr(30),
});
flatpickr("#start_time", setting);
flatpickr("#end_time", setting);
