$("#new-category").change(function () {
    const newCategory = $("#new-category option:selected").text();
    if (newCategory == "Koszulki") {
        $("#form-sizes").removeClass("hide");
    } else {
        $("#form-sizes").addClass("hide");
    }
});

$('#date-checkbox').change(function () {
    $('#news-date').toggleClass('hide');
});

function editPackage(packageId) {
    const packageName = $('#package-name-' + packageId).val();
    const packagePrice = $('#package-price-' + packageId).val();
    const packageIsActive = $('#package-is-active-' + packageId).is(':checked') ? 1 : 0;
    $.ajax({
        type: "POST",
        async: false,
        url: document.location.origin + '/cms/admin/edit_package/' + packageId,
        data: {'packageName': packageName, 'packagePrice': packagePrice, 'packageIsActive': packageIsActive},

        success: function (msg) {
            if (msg == 1) {
                $.notify.defaults({className: "success"});
                $('#edit-package-' + packageId).notify(
                    "Zmiany zostały zapisane",
                    {
                        position: "left",
                        autoHideDelay: 2000
                    }
                );
            } else {
                $.notify.defaults({className: "warn"});
                $('#edit-package-' + packageId).notify(
                    "Wystąpił nieoczekiwany błąd",
                    {
                        position: "left",
                        autoHideDelay: 2000
                    }
                );
            }
        }
    });
}