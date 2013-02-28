(function (tvl, $) {

    "use strict";

    tvl.INITED = "inited";

    function start() {

        //console.info("tvland start");

        $("body").trigger(tvl.INITED);

    }

    function onInited(e) {

        //console.info("tvland heard init");
        //console.log(e);

        $("input[name=channelNumber]").click(function (e) {
            if ($(this).val() === "yes") {
                $("#fs-channel-numbers").show();
            } else {
                $("#fs-channel-numbers").hide();
            }
        });

        $("#fs-tune-ins input[type=checkbox]").click(function (e) {

            var id = $(this).attr("id");

            if ($(this).is(":checked")) {
                $("input[name=" + id + "Radio]").removeAttr("disabled");
            } else {
                $("input[name=" + id + "Radio]").attr("disabled", "disbaled");
            }

        });

        $("input[type=checkbox]").click(function (e) {

            var id = $(this).attr("id"),
                parentId = $(this).parents("fieldset").attr("id");

            var len = $("#" + parentId + " input[type=checkbox]:checked").length;

            if (len === 0) {
                $(this).prop("checked", true);
                $("input[name=" + id + "Radio]").removeAttr("disabled");
            }

        });

        $("#dupe-form").validate({
            rules: {
                templateName: "required",
                dupeName: "required"
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    }

    $("body").bind(
        tvl.INITED,
        function (e) {
            onInited(e);
        }
    );

    $(function () {
        start();
    });

}(window.tvl = window.tvl || {}, jQuery));

