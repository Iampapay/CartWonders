$(document).ready(function () {
    var base_path_url = base_path.split("/").slice(0, -1).join("/");
    var base_url = base_path_url.split("/").slice(0, -1).join("/");

    let categoryTable;
    fetchCategory();
    function fetchCategory() {
        if ($.fn.DataTable.isDataTable("#categoryTable")) {
            categoryTable.clear().destroy();
        }
        categoryTable = $('#categoryTable').DataTable({
            dom: 'lBfrtip', // include the buttons in the DataTable
            ordering: true,
            order: [[0, "desc"]],
            searching: true,
            processing: true,
            serverSide: true,
            language: {
                paginate: {
                    next: 'Next <i class="mdi mdi-chevron-right"></i>', // or '>'
                    previous: '<i class="mdi mdi-chevron-left"></i> Previous', // or '<'
                },
                infoFiltered: "",
                buttons: {
                    copyTitle:
                        '<i class="mdi mdi-checkbox-multiple-marked-outline text-primary"></i>',
                    copyKeys: "Copy to clipboard",
                    copySuccess: {
                        _: '<h1 class="text-success">Copied %d rows to clipboard<h1>',
                        1: "1 row copy",
                    },
                },
                // processing: '<i class="mdi mdi-database"></i>',
            },
            bDestroy: true,
            buttons: [
                {
                    extend: "copyHtml5",
                    text: "Copy",
                    className: "btn buttons-copy buttons-html5 btn-default",
                    titleAttr: "Copy",
                    exportOptions: {
                        columns: [0, 1],
                    },
                },
                {
                    extend: "csvHtml5",
                    text: "CSV",
                    className: "btn buttons-csv buttons-html5 btn-default",
                    titleAttr: "CSV",
                    exportOptions: {
                        columns: [0, 1],
                    },
                },
                {
                    extend: "print",
                    text: "Print",
                    className: "btn buttons-pdf buttons-html5 btn-default",
                    titleAttr: "Print",
                    exportOptions: {
                        columns: [0, 1],
                    },
                },
            ],
            initComplete: function (settings, json) {
                $("#categoryTable").wrap(
                    "<div class='table-responsive border' style='overflow-x: hidden'></div>"
                );
                // Move length menu and label to desired position
                var lengthMenuContainer = $("#categoryTable_length");
                var lengthMenuLabel = lengthMenuContainer.find("label");
                lengthMenuLabel.addClass("d-inline-flex");

                // Hide the sorting arrows
                $("<style>")
                    .prop("type", "text/css")
                    .html(
                        "table.dataTable thead>tr>th.sorting::before, table.dataTable thead>tr>th.sorting::after { width: 0; height: 0; display: flex; align-items: center;}"
                    )
                    .appendTo("head");
            },
            lengthMenu: [
                [10, 25, 50, 100, 5000],
                [10, 25, 50, 100, "All"],
            ],
            ajax: {
                url: "fetch-category",
                datatype: "json",
                type: "GET",
                // beforeSend: function () {
                //     $(".page-loader").show();
                //     $(".page-loader").hide();
                // },
                complete: function (res) {
                    // console.log(res);
                    if (res.responseJSON.length == 1) {
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-top-center';
                        toastr.options.closeDuration = 200;
                        toastr.options.showMethod = 'slideDown';
                        toastr.options.hideMethod = 'slideUp';
                        toastr.options.closeMethod = 'slideUp';
                        toastr.options.progressBar = true;
                        toastr.error("We can't fetch more than 1000 data in a single page");
                    }
                },
            },
            columns: [
                { data: 'id' },
                { data: 'category_name' },
                { data: 'action' },
            ]
        });
        categoryTable.buttons().container().appendTo("#printbar");
        $(".dt-buttons").addClass("float-right btn-group");
        $(".buttons-copy").css("background", "linear-gradient(to bottom left, #3333cc 0%, #cc00ff 100%)");
        $(".buttons-csv").css("background", "linear-gradient(to bottom left, #3333cc 0%, #cc00ff 100%)");
        $(".buttons-pdf").css("background", "linear-gradient(to bottom left, #3333cc 0%, #cc00ff 100%)");
    }

    // === for add category data === //
    $("#add_category").validate({
        rules: {
            category: {
                minlength: 3,
                maxlength: 15,
                required: true
            }
        },
        highlight: function (element) {
            $(element).parent().addClass('error');
            $(element).addClass('error');
        },
        unhighlight: function (element) {
            $(element).parent().removeClass('error');
            $(element).removeClass('error');
        },
        submitHandler: function (form) {
            var formData = new FormData($(form)[0]);

            $.ajax({
                type: 'POST',
                url: "add-category",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status == 400) {
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-bottom-right';
                        toastr.options.closeDuration = 200;
                        toastr.options.showMethod = 'slideDown';
                        toastr.options.hideMethod = 'slideUp';
                        toastr.options.closeMethod = 'slideUp';
                        toastr.options.progressBar = true;
                        toastr.error(response.message);
                    } else {
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-bottom-right';
                        toastr.options.closeDuration = 200;
                        toastr.options.showMethod = 'slideDown';
                        toastr.options.hideMethod = 'slideUp';
                        toastr.options.closeMethod = 'slideUp';
                        toastr.options.progressBar = true;
                        toastr.success(response.message);
                        $('#add_category').find('input').val('');
                        fetchCategory();
                    }
                },
                error: function (error) {
                    console.log(error.responseText);
                },
            });
        }
    });

    // === for delete category data === //
    $(document).on('click', '#deletebtn', function () {
        var id = $(this).val();
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        url: "/delete-category/" + id,
                        dataType: 'json',
                        success: function (response) {
                            // console.log(response);
                            if (response.status == 200) {
                                fetchCategory();
                            }
                        },
                        error: function (error) {
                            console.log(error.responseText);
                        },
                    });
                    swal("Deleted!", "Your data has been deleted.", "success");
                } else {
                    swal("Cancelled", "Your data is safe :)", "error");
                }
            }
        );
    });

    // Define a custom validation method for file extensions
    // $.validator.addMethod("customExtension", function(value, element, param) {
    //     param = typeof param === "string" ? param.replace(/\s/g, '') : "png|jpg|jpeg";
    //     var extension = value.split('.').pop().toLowerCase();
    //     return this.optional(element) || $.inArray(extension, param.split('|')) !== -1;
    // }, $.validator.format("Please select a valid file type (jpg, jpeg, png)."));

    $("#add_product").validate({
        rules: {
            title: {
                minlength: 3,
                maxlength: 30,
                required: true
            },
            description: {
                minlength: 5,
                maxlength: 100,
                required: true
            },
            price: {
                minlength: 1,
                required: true
            },
            quantity: {
                minlength: 1,
                required: true
            },
            category: {
                required: true
            },
            'image[]': {
                required: true,
                // customExtension: "jpg,jpeg,png"
            }
        },
        messages: {
            title: {
                required: "Please enter product title.",
            },
            description: {
                required: "Please enter product description.",
            },
            price: {
                required: "Please enter product price.",
            },
            quantity: {
                required: "Please enter product quantity.",
            },
            category: {
                required: "Please enter product category.",
            },
            'image[]': {
                required: "Please select an image.",
                // customExtension: "Please select a valid file type (jpg, jpeg, png)."
            }
        },
        highlight: function (element) {
            var inputType = $(element).attr("type");
            if (inputType == 'file'){
                $('.file-upload-info').addClass('error');
            }
            $(element).parent().addClass('error');
            $(element).addClass('error');
        },
        unhighlight: function (element) {
            var inputTyp = $(element).attr("type");
            if (inputTyp == 'file'){
                console.log("Input type:", inputTyp);
                $('.file-upload-info').removeClass('error');
            }
            $(element).parent().removeClass('error');
            $(element).removeClass('error');
        },
        errorPlacement: function (error, element) {
            // return true;
            error.appendTo($(".error-container"));
        },
        submitHandler: function (form) {
            var formData = new FormData($(form)[0]);

            $.ajax({
                type: 'POST',
                url: "create-product",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    // console.log(response);
                    if (response.status == 400) {
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-bottom-right';
                        toastr.options.closeDuration = 200;
                        toastr.options.showMethod = 'slideDown';
                        toastr.options.hideMethod = 'slideUp';
                        toastr.options.closeMethod = 'slideUp';
                        toastr.options.progressBar = true;
                        $.each(response.errors, function (key,
                            err_value) {
                            toastr.error(err_value);
                        });
                    } else {
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-bottom-right';
                        toastr.options.closeDuration = 200;
                        toastr.options.showMethod = 'slideDown';
                        toastr.options.hideMethod = 'slideUp';
                        toastr.options.closeMethod = 'slideUp';
                        toastr.options.progressBar = true;
                        toastr.success(response.message);
                        $('#preview_img').css('display', 'none');
                        $("#add_product")[0].reset();
                        $('#preview_img').attr('src', "");
                    }
                },
                error: function (error) {
                    console.log(error.responseText);
                },
            });
        }
    });

    let productTable;
    fetchProduct();
    function fetchProduct() {
        if ($.fn.DataTable.isDataTable("#productTable")) {
            productTable.clear().destroy();
        }
        productTable = $('#productTable').DataTable({
            dom: 'lBfrtip', // include the buttons in the DataTable
            ordering: true,
            order: [[0, "desc"]],
            searching: true,
            processing: true,
            serverSide: true,
            language: {
                paginate: {
                    next: 'Next <i class="mdi mdi-chevron-right"></i>', // or '>'
                    previous: '<i class="mdi mdi-chevron-left"></i> Previous', // or '<'
                },
                infoFiltered: "",
                buttons: {
                    copyTitle:
                        '<i class="mdi mdi-checkbox-multiple-marked-outline text-primary"></i>',
                    copyKeys: "Copy to clipboard",
                    copySuccess: {
                        _: '<h1 class="text-success">Copied %d rows to clipboard<h1>',
                        1: "1 row copy",
                    },
                },
                // processing: '<i class="mdi mdi-database"></i>',
            },
            bDestroy: true,
            buttons: [
                {
                    extend: "copyHtml5",
                    text: "Copy",
                    className: "btn buttons-copy buttons-html5 btn-default",
                    titleAttr: "Copy",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                },
                {
                    extend: "csvHtml5",
                    text: "CSV",
                    className: "btn buttons-csv buttons-html5 btn-default",
                    titleAttr: "CSV",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                },
                {
                    extend: "print",
                    text: "Print",
                    className: "btn buttons-pdf buttons-html5 btn-default",
                    titleAttr: "Print",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6],
                    },
                },
            ],
            initComplete: function (settings, json) {
                $("#productTable").wrap(
                    "<div class='table-responsive border' style='overflow-x: hidden'></div>"
                );
                // Move length menu and label to desired position
                var lengthMenuContainer = $("#productTable_length");
                var lengthMenuLabel = lengthMenuContainer.find("label");
                lengthMenuLabel.addClass("d-inline-flex");
            },
            lengthMenu: [
                [10, 25, 50, 100, 5000],
                [10, 25, 50, 100, "All"],
            ],
            ajax: {
                url: "fetch-product",
                datatype: "json",
                type: "GET",
                // beforeSend: function () {
                //     $(".page-loader").show();
                //     $(".page-loader").hide();
                // },
                complete: function (res) {
                    // console.log(res);
                    if (res.responseJSON.length == 1) {
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-top-center';
                        toastr.options.closeDuration = 200;
                        toastr.options.showMethod = 'slideDown';
                        toastr.options.hideMethod = 'slideUp';
                        toastr.options.closeMethod = 'slideUp';
                        toastr.options.progressBar = true;
                        toastr.error("We can't fetch more than 1000 data in a single page");
                    }
                },
            },
            columns: [
                { data: 'id' },
                { data: 'title' },
                { data: 'description' },
                { data: 'quantity' },
                { data: 'category' },
                { data: 'price' },
                { data: 'discount_price' },
                { data: 'image' },
                { data: 'action' },
            ]
        });
        productTable.buttons().container().appendTo("#printbar");
        $(".dt-buttons").addClass("float-right btn-group");
        $(".buttons-copy").css("background", "linear-gradient(to bottom left, #3333cc 0%, #cc00ff 100%)");
        $(".buttons-csv").css("background", "linear-gradient(to bottom left, #3333cc 0%, #cc00ff 100%)");
        $(".buttons-pdf").css("background", "linear-gradient(to bottom left, #3333cc 0%, #cc00ff 100%)");
    }

    // for edit button //
    $(document).on('click', '.editbtn', function (e) {
        // e.preventDefault();
        var edit_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "/edit-product/" + edit_id,
            success: function (response) {
                // console.log(response);
                if (response.status == 404) {
                    $('#success_message').addClass('alert alert-danger');
                    $('#success_message').text(response.message);
                } else {
                    $('#update_products').find('input').val('');
                    $('#prod_id').val(response.prod_details.id);
                    $('#editTitle').val(response.prod_details.title);
                    $('#editDescription').val(response.prod_details.description);
                    $('#editPrice').val(response.prod_details.price);
                    $('#editDiscount').val(response.prod_details.discount_price);
                    $('#editQuantity').val(response.prod_details.quantity);
                    $('#editCategory').val(response.prod_details.category);
                    $('#editCategory').text(response.prod_details.category);
                    $.each(response.prod_category, function (key, item) {
                        $('select').append(
                            '<option class="text-primary" value="' + item
                                .category_name + '">' + item.category_name +
                            '</option>');
                    });
                    $('#old_image').val(response.prod_details.image);
                    var p_image = '/product-Image/' + response.prod_details.image;
                    $('#update_pic').attr('src', p_image);
                }
            }
        });
    });

    // for update button //
    $(document).on('click', '.update_prod', function () {
        // e.preventDefault();
        var id = $('#prod_id').val();
        $("#update_products").validate({
            errorPlacement: function (error, element) {
                var n = element.attr("name");
                if (n == "update_title")
                    element.attr("placeholder", "Please enter product title");
                else if (n == "update_description")
                    element.attr("placeholder", "Please enter product description");
                else if (n == "update_price")
                    element.attr("placeholder", "Please enter product price");
                else if (n == "update_quantity")
                    element.attr("placeholder", "Please enter product quantity");
                else if (n == "update_category")
                    element.attr("placeholder", "Please enter product category");
            },
            rules: {
                update_title: {
                    minlength: 3,
                    maxlength: 30,
                    required: true
                },
                update_description: {
                    minlength: 5,
                    maxlength: 100,
                    required: true
                },
                update_price: {
                    minlength: 1,
                    required: true
                },
                update_quantity: {
                    minlength: 1,
                    required: true
                },
                update_category: {
                    required: true
                },
                update_image: {
                    extension: "jpg|jpeg|png"
                }
            },
            messages: {
                update_image: {
                    extension: "Please upload file in these format only (jpg, jpeg, png)."
                }
            },
            highlight: function (element) {
                $(element).addClass('errorClass');
            },
            unhighlight: function (element) {
                $(element).removeClass('errorClass');
            },
            submitHandler: function (form) {
                var formData = new FormData($(form)[0]);

                $.ajax({
                    type: 'POST',
                    url: "/update-product/" + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content')
                    },
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        if (response.status == 400) {
                            toastr.options.closeButton = true;
                            toastr.options.positionClass = 'toast-top-center';
                            toastr.options.closeDuration = 200;
                            toastr.options.showMethod = 'slideDown';
                            toastr.options.hideMethod = 'slideUp';
                            toastr.options.closeMethod = 'slideUp';
                            toastr.options.progressBar = true;
                            $.each(response.errors, function (key,
                                err_value) {
                                toastr.error(err_value);
                            });
                            // $.each(response.errors, function(key,
                            // err_value) {
                            //     $('#save_msgList').append('<li>' +
                            //         err_value +
                            //         '</li>');
                            // });
                        } else {
                            toastr.options.closeButton = true;
                            toastr.options.positionClass = 'toast-top-center';
                            toastr.options.closeDuration = 200;
                            toastr.options.showMethod = 'slideDown';
                            toastr.options.hideMethod = 'slideUp';
                            toastr.options.closeMethod = 'slideUp';
                            toastr.options.progressBar = true;
                            toastr.success(response.message);
                            $('#update_products').find('input').val('');
                            $('#editCategory').val('');
                            $('#update_pic').attr('src', "");
                            $('.btn-close').click();
                            fetchProduct();
                        }
                    },
                    error: function (error) {
                        console.log(error.responseText);
                    },
                });
            }
        });
    });

    // for active/inactive product //
    $(document).on('change', '.isactive', function (event) {
        var is_checked = event.target.checked;
        var id = $(this).data('prod_auto_id');
        var prod_status = '';
        if (is_checked) {
            prod_status = 'Y';
        } else {
            prod_status = 'N';
        }
        $.ajax({
            type: 'POST',
            url: "/product-status/" + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                    'content')
            },
            data: {
                prod_status: prod_status
            },
            dataType: 'json',
            success: function (response) {
                console.log(response);
                if (response.status == 200) {
                    toastr.options.closeButton = true;
                    toastr.options.positionClass = 'toast-top-center';
                    toastr.options.closeDuration = 200;
                    toastr.options.showMethod = 'slideDown';
                    toastr.options.hideMethod = 'slideUp';
                    toastr.options.closeMethod = 'slideUp';
                    toastr.options.progressBar = true;
                    toastr.success(response.message);
                    fetchProduct();
                } else {
                    toastr.options.closeButton = true;
                    toastr.options.positionClass = 'toast-top-center';
                    toastr.options.closeDuration = 200;
                    toastr.options.showMethod = 'slideDown';
                    toastr.options.hideMethod = 'slideUp';
                    toastr.options.closeMethod = 'slideUp';
                    toastr.options.progressBar = true;
                    toastr.error(response.message);
                    fetchProduct();
                }
            },
            error: function (error) {
                console.log(error.responseText);
            },
        });
    });

    // for delete product data //
    $(document).on('click', '.deletebtn', function () {
        var id = $(this).val();
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel plx!",
            closeOnConfirm: false,
            closeOnCancel: false
        },
            function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                'content')
                        },
                        url: "/delete-product/" + id,
                        dataType: 'json',
                        success: function (response) {
                            // console.log(response);
                            if (response.status == 200) {
                                fetchProduct();
                            }
                        },
                        error: function (error) {
                            console.log(error.responseText);
                        },
                    });
                    swal("Deleted!", "Your data has been deleted.", "success");
                } else {
                    swal("Cancelled", "Your data is safe :)", "error");
                }
            }
        );
    });

    let orderTable;
    fetchOrders();
    function fetchOrders() {
        if ($.fn.DataTable.isDataTable("#orderTable")) {
            orderTable.clear().destroy();
        }
        orderTable = $('#orderTable').DataTable({
            dom: 'lBfrtip', // include the buttons in the DataTable
            ordering: true,
            order: [[0, "desc"]],
            searching: true,
            processing: true,
            serverSide: true,
            language: {
                paginate: {
                    next: 'Next <i class="mdi mdi-chevron-right"></i>', // or '>'
                    previous: '<i class="mdi mdi-chevron-left"></i> Previous', // or '<'
                },
                infoFiltered: "",
                buttons: {
                    copyTitle:
                        '<i class="mdi mdi-checkbox-multiple-marked-outline text-primary"></i>',
                    copyKeys: "Copy to clipboard",
                    copySuccess: {
                        _: '<h1 class="text-success">Copied %d rows to clipboard<h1>',
                        1: "1 row copy",
                    },
                },
                // processing: '<i class="mdi mdi-database"></i>',
            },
            bDestroy: true,
            buttons: [
                {
                    extend: "copyHtml5",
                    text: "Copy",
                    className: "btn buttons-copy buttons-html5 btn-default",
                    titleAttr: "Copy",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                    },
                },
                {
                    extend: "csvHtml5",
                    text: "CSV",
                    className: "btn buttons-csv buttons-html5 btn-default",
                    titleAttr: "CSV",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                    },
                },
                {
                    extend: "print",
                    text: "Print",
                    className: "btn buttons-pdf buttons-html5 btn-default",
                    titleAttr: "Print",
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17],
                    },
                },
            ],
            initComplete: function (settings, json) {
                $("#orderTable").wrap(
                    "<div class='table-responsive border'></div>"
                );
                // Move length menu and label to desired position
                var lengthMenuContainer = $("#orderTable_length");
                var lengthMenuLabel = lengthMenuContainer.find("label");
                lengthMenuLabel.addClass("d-inline-flex");

                // Apply padding to table cells
                $("#orderTable tbody td").css("padding", "20px 10px");

                // Hide the sorting arrows
                $("<style>")
                    .prop("type", "text/css")
                    .html(
                        "table.dataTable thead>tr>th.sorting::before, table.dataTable thead>tr>th.sorting::after { width: 0; height: 0; display: flex; align-items: center;}"
                    )
                    .appendTo("head");
            },
            // initComplete: function (settings, json) {
            //     $("#orderTable").wrap(
            //         "<div class='table-responsive border'></div>"
            //     );
            //     // Move length menu and label to desired position
            //     var lengthMenuContainer = $("#orderTable_length");
            //     var lengthMenuLabel = lengthMenuContainer.find("label");
            //     lengthMenuLabel.addClass("d-inline-flex");
            // },
            lengthMenu: [
                [10, 25, 50, 100, 5000],
                [10, 25, 50, 100, "All"],
            ],
            ajax: {
                url: "fetch-order",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                datatype: "json",
                type: "POST",
                // beforeSend: function () {
                //     $(".page-loader").show();
                //     $(".page-loader").hide();
                // },
                complete: function (res) {
                    // console.log(res);
                    if (res.responseJSON.length == 1) {
                        toastr.options.closeButton = true;
                        toastr.options.positionClass = 'toast-top-center';
                        toastr.options.closeDuration = 200;
                        toastr.options.showMethod = 'slideDown';
                        toastr.options.hideMethod = 'slideUp';
                        toastr.options.closeMethod = 'slideUp';
                        toastr.options.progressBar = true;
                        toastr.error("We can't fetch more than 1000 data in a single page");
                    }
                },
            },
            columns: [
                { data: 'id' },
                { data: 'user_name' },
                { data: 'product_title' },
                { data: 'product_qty' },
                { data: 'product_prc' },
                { data: 'bill_name' },
                { data: 'bill_phone' },
                { data: 'bill_email' },
                { data: 'country' },
                { data: 'state' },
                { data: 'city' },
                { data: 'address1' },
                { data: 'address2' },
                { data: 'pin_code' },
                { data: 'payment_mode' },
                { data: 'payment_id' },
                { data: 'order_status' },
                { data: 'tracking_no' },
                { data: 'created_at' },
                { data: 'action' },
            ]
        });
        orderTable.buttons().container().appendTo("#printbar");
        $(".dt-buttons").addClass("float-right btn-group");
        $(".buttons-copy").css("background", "linear-gradient(to bottom left, #ffff66 0%, #009933 100%)");
        $(".buttons-csv").css("background", "linear-gradient(to bottom left, #ffff66 0%, #009933 100%)");
        $(".buttons-pdf").css("background", "linear-gradient(to bottom left, #ffff66 0%, #009933 100%)");
    }

    // for search content details from table //
    $("#myInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#product_table tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $('.file-upload-browse').on('click', function () {
        var file = $(this).parent().parent().parent().find('.file-upload-default');
        file.trigger('click');
    });
    $('.file-upload-default').on('change', function () {
        $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
    });

});

// function previewFiles() {
//     const fileInput = document.querySelector(".file-upload-default");
//     const previewImg = document.querySelector('#preview_img');
//     fileInput.addEventListener('change', function() {
//         if (this.files.length === 0) {
//             previewImg.src = '';
//             return;
//         }
//         const file = this.files[0];
//         var reader = new FileReader();
//         reader.onload = function(e) {
//             previewImg.src = e.target.result;
//         };
//         reader.readAsDataURL(file);
//     });
// }

function updatePreviewImage(file) {
    var reader = new FileReader();

    // When the reader loads the image
    reader.onload = function () {
        $('#preview_img').attr('src', reader.result);
    };

    // Read the selected image as a data URL
    if (file) {
        $('#preview_img').css('display', '');
        reader.readAsDataURL(file);
    } else {
        // If no file is selected or removed, reset the preview to empty
        $('#preview_img').css('display', 'none');
        $('#preview_img').attr('src', '');
    }
}

// When the file input value changes (i.e., an image is selected or removed)
$('input[name="image[]"]').change(function (event) {
    var file = event.target.files[0];
    if(file.type == 'image/jpg' || file.type == 'image/jpeg' || file.type == 'image/png'){
        updatePreviewImage(file);
    } else {
        $('#preview_img').attr('src', '');
        $('#preview_img').css('display', 'none');
    }
});

$('#resetProduct').on('click', function () {
    $('#preview_img').css('display', 'none');
});

function previewFile() {
    const fileInput = document.querySelector("input[name=update_image]");
    const previewImg = document.querySelector('#update_pic');
    fileInput.addEventListener('change', function () {
        if (this.files.length === 0) {
            previewImg.src = '';
            return;
        }
        const file = this.files[0];
        var reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });
}
