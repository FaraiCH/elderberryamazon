$(document).ready(function() {
    $('.select_search').select2();
    $('#select_bin').select2();

    var config = { '.select_search': {} }
    for (var selector in config) {
        $(selector).select2(config[selector]);
    }
    var config_bin = { '.select_search': {} }
    for (var selector in config_bin) {
        $(selector).select2(config_bin[selector]);
    }
})
