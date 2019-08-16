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
        url: document.location.origin + '/cms/admin/save_package/' + packageId,
        data: {'packageName': packageName, 'packagePrice': packagePrice, 'packageIsActive': packageIsActive},

        success: function (response) {
            $.notify.defaults({className: "success"});
            $('#edit-package-' + packageId).notify(
                response.message,
                {
                    position: "left",
                    autoHideDelay: 2000
                }
            );
        },
        error: function (response) {
            $.notify.defaults({className: "warn"});
            $('#edit-package-' + packageId).notify(
                response.responseJSON.message,
                {
                    position: "left",
                    autoHideDelay: 2000
                }
            );
        }
    });
}

function addPackageRow() {
    $('#add-package').before('' +
        '<tr class="new-package-row">' +
            '<td><input id="package-name-new" type="text"></td>' +
            '<td><input id="package-price-new" type="number"></td>' +
            '<td><input id="package-is-active-new" type="checkbox"></td>' +
            '<td>' +
                '<a href="javascript:void(0)" onclick="saveNewPackage()"' +
                    '<span class="glyphicon glyphicon-ok"></span>' +
                '</a>' +
            '</td>' +
        '</tr>' +
    '');
    $('#add-package-type-btn').addClass('hidden');
}

function saveNewPackage() {
    const packageName = $('#package-name-new').val();
    const packagePrice = $('#package-price-new').val();
    const packageIsActive = $('#package-is-active-new').is(':checked') ? 1 : 0;

    $.ajax({
        type: "POST",
        async: false,
        url: document.location.origin + '/cms/admin/save_package',
        data: {'packageName': packageName, 'packagePrice': packagePrice, 'packageIsActive': packageIsActive},

        success: function (response) {
            $('#new-package-row').remove();
            const newPackageId = response.data.packageId;
            const checked = packageIsActive ? 'checked' : '';

            $('#add-package').before('' +
                '<tr>' +
                    '<td><input id="package-name-' + newPackageId + '" value="' + packageName + '" type="text"></td>' +
                    '<td><input id="package-price-' + newPackageId + '" value="' + packagePrice + '" type="number"></td>' +
                    '<td><input id="package-is-active' + newPackageId + '" ' + checked + '  type="checkbox"></td>' +
                    '<td>' +
                        '<a id="edit-package-' + newPackageId + '" href="javascript:void(0)" onclick="editPackage(' + newPackageId + ')">' +
                            '<span class="glyphicon glyphicon-ok"></span>' +
                        '</a>' +
                    '</td>' +
                '</tr>' +
                '');
            $('#add-package-type-btn').removeClass('hidden');


            $.notify.defaults({className: "success"});
            $('#edit-package-' + newPackageId).notify(
                response.message,
                {
                    position: "left",
                    autoHideDelay: 2000
                }
            );
        },
        error: function (response) {
            $.notify.defaults({className: "warn"});
            $('#save-error').notify(
                response.responseJSON.message,
                {
                    position: "left",
                    autoHideDelay: 2000
                }
            );
        }
    });
}