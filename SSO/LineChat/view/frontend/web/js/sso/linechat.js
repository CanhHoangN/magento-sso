define([
    'jquery',
    'mage/mage'
], function ($) {
    'use strict';

    $('#login_sso_linechat').click(function (event) {
        window.open(
            $("#base_url_authentication").val(),
            "_parent" ,
            "width=800,height=800,top=300"
        )
    })
});
