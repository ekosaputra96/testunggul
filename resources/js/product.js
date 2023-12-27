require("./app");
let productTable, productId;
const productModal = $("#product-modal");
const productModalTitle = $("#modal-title-header");
const productForm = $("#product-form");
const productSubmitButton = $("#product-submit-button");

$(function () {
    productTable = $("#product-table").DataTable({
        serverSide: true,
        processing: true,
        responsive: true,
        paging: true,
        pageLength: 10,
        order: [[0, 'desc']],
        ajax: route("product.datatable"),
        columns: [
            {
                name: "created_at",
                data: "created_at",
                visible: false
            },
            {
                name: "nama",
                data: "nama",
            },
            {
                name: "deskripsi",
                data: "deskripsi",
            },
            {
                name: "harga",
                data: "harga",
                searchable: false,
            },
            {
                name: "is_active",
                data: "is_active",
                searchable: false,
                render: function (data, type, row) {
                    return data ? "Ya" : "Tidak";
                },
            },
            {
                name: "stock",
                data: "stock",
                searchable: false,
            },
            {
                name: "suppliers.nama",
                data: "nama_supplier",
            },
            {
                name: "action",
                data: "action",
            },
        ],
    });
});

function refreshProductTable() {
    productTable.ajax.reload(null, false);
}

function getLink(state) {
    const urls = {
        Save: {
            url: route("product.store"),
            method: "POST",
        },
        Update: {
            url: route("product.update", productId ?? 0),
            method: "PUT",
        },
    };

    return urls[state];
}

$("#create-product").on("click", function () {
    productModalTitle.text("Create Data");
    productForm[0].reset();
    productForm.find("select").trigger("change");
    productModal.val("Save");
    productSubmitButton.text(productModal.val());
    productModal.modal("show");
});

// create or update product
productForm.on("submit", function (e) {
    e.preventDefault();
    const data = new FormData(this);
    const link = getLink(productModal.val());
    const isUpdated = productModal.val() === "Update";

    if(isUpdated){
        data.append('_method', 'PUT')
    }

    productSubmitButton.text("Loading...").prop("disabled", true);

    $.ajax({
        url: link.url,
        method: "POST",
        data,
        processData: false,
        contentType: false,
    })
        .done(function (result) {
            if (result.success) {
                Swal.fire({
                    title: !isUpdated ? "Created" : "Updated",
                    text: result.message,
                    type: "success",
                    showConfirmButton: false,
                    timer: 1000,
                });

                refreshProductTable();

                productModal.modal("hide");
            }
        })
        .fail(function (xhr) {
            return Swal.fire({
                title: "Error",
                text: xhr.responseJSON.message,
                type: "error",
            });
        })
        .always(function () {
            productSubmitButton
                .text(productModal.val())
                .prop("disabled", false);
        });
});

// edit product
$(document).on("click", ".product-edit-btn", function () {
    productId = $(this).data("id");
    $.get(route("product.edit", productId), function (result) {
        productModalTitle.text("Edit Data : " + result.data.nama);
        productModal.val("Update");
        productSubmitButton.text(productModal.val());
        $('input[name="nama"]').val(result.data.nama);
        $('input[name="harga"]').val(result.data.harga);
        $('input[name="stock"]').val(result.data.stock);
        $('input[name="supplier_id"]')
            .val(result.data.supplier_id)
            .trigger("change");
        $('textarea[name="deskripsi"]').val(result.data.deskripsi);

        productModal.modal("show");
    }).fail(function (xhr) {
        Swal.fire({
            title: "Failed",
            text: xhr.responseJSON.message,
            type: "error",
        });

        return;
    });
});

// delete product
$(document).on("click", ".product-delete-btn", function (e) {
    productId = $(this).data("id");
    Swal.fire({
        text: "Delete this product ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: "DELETE",
                url: route("product.destroy", productId),
            })
                .done(function (result) {
                    if (result.success) {
                        Swal.fire({
                            title: "Deleted",
                            text: result.message,
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000,
                        });

                        refreshProductTable();
                    }
                })
                .fail(function (xhr) {
                    Swal.fire({
                        title: "Error",
                        text: xhr.responseJSON.message,
                        type: "error",
                    });

                    return;
                });
        }
    });
});
