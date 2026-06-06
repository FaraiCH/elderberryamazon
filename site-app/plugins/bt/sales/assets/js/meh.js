// In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.select_quote').select2();
    $('.select_client').select2();
    $('.select_search').select2();
    $('.select_search2').select2();
    $('.select_client').select2({
        ajax: {
            transport: function(params, success, failure) {
                /*
                 * This is where the AJAX framework is used
                 */
                var $request = $.request('onGetsClient', {
                    data: params.data
                })
                $request.done(success)
                $request.fail(failure)
                return $request
            },

            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data,params) {
                return {
                    // The JSON needs to be parsed before Select2 knows what to do with it.
                    results: JSON.parse(data.result)
                };
            },
            cache: true
        },
        minimumInputLength: 1
    });

    $('.select_quote').select2({
        ajax: {
            transport: function(params, success, failure) {

                /*
                 * This is where the AJAX framework is used
                 */
                var $request = $.request('onGetSomething', {
                    data: params.data
                })
                $request.done(success)
                $request.fail(failure)
                return $request
            },

            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data,params) {
                return {
                    // The JSON needs to be parsed before Select2 knows what to do with it.
                    results: JSON.parse(data.result)
                };
            },
            cache: true
        },
        minimumInputLength: 1
    });

    $('.select_client').on('select2:select', function (e) {
        $('form').request('onBusinessClient', {success: function(data) {
        }})
    });

    $('.select_quote').on('select2:select', function (e) {
        $('form').request('onBusinessName', {success: function(data) {
        }})
    });
});





