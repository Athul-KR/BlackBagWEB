//Placeholder position change to top
$("input").on("focus", function () {
    $(this).parent().find(".float-label").addClass("active");
});

$("input").on("blur", function () {
    if ($(this).val()) {
        $(this).parent().find(".float-label").addClass("active");
    } else {
        $(this).parent().find(".float-label").removeClass("active");
    }
});

// check existing values
$("input").each(function () {
    if ($(this).val()) {
        $(this).parent().find(".float-label").addClass("active");
    } else {
        $(this).parent().find(".float-label").removeClass("active");
    }
});
$("input").on("focusout", function () {
    if (!this.value) {
        $(this).parent().find(".float-label").removeClass("active");
    }
});
