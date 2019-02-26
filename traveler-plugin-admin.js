jQuery(document).ready(function ($) {
  $('input.traveler_plugin_date').datepicker({
    todayHighlight: true,
    autoclose: true,
    dateFormat: "mm/dd/yy",
    weekStart: 1,
    setRefresh: true
  });
});