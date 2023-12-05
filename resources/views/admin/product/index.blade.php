@extends('adminlte::page')

@section('title', 'Product')

@section('content_header')
    <h1>Product</h1>
@stop

@section('content'){{-- create product --}}
    <button type="button" class="btn btn-primary mb-4" id="create-product">New Product</button>

    {{-- table product --}}
    <div class="table-responsive">
        <table class="table table-striped" id="product-table" style="width: 100%">
            <thead>
              <tr>
                <th scope="col">Nama</th>
                <th scope="col">Deskripsi</th>
                <th scope="col">Harga</th>
                <th scope="col">Aktif?</th>
                <th scope="col">Stock</th>
                <th scope="col">Supplier</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
        </table>
    </div>

    {{-- create product modal --}}
    <div class="modal" tabindex="-1" id="create-product-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form id="create-product-form">
                <div class="modal-header">
                  <h5 class="modal-title">Create Product</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Product</label>
                                <input type="text" class="form-control" name="nama">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" class="form-control" name="harga">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" name="stock">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select class="form-control" name="supplier_id" id="supplier_id">
                                    @foreach ($suppliers as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
    
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
          </div>
        </div>
    </div>

    {{-- modal edit product --}}
    <div class="modal" tabindex="-1" id="edit-product-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form id="edit-product-form">
                <div class="modal-header">
                  <h5 class="modal-title">Edit Product</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="product_id" id="product_id_edit" >
                            <div class="form-group">
                                <label for="nama">Nama Product</label>
                                <input type="text" class="form-control" name="nama" id="nama_edit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga">Harga</label>
                                <input type="number" class="form-control" name="harga" id="harga_edit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" class="form-control" name="stock" id="stock_edit">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="supplier_id">Supplier</label>
                                <select class="form-control" name="supplier_id" id="supplier_id_edit">
                                    @foreach ($suppliers as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control"  name="deskripsi" rows="3" id="deskripsi_edit"></textarea>
                            </div>
                        </div>
                    </div>
    
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
          </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script defer>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let table = $('#product-table').DataTable({
            serverSide: true,
            processing: true,
            responsive: true,
            paging: true,
            pageLength: 10,
            ajax: '{{route('product-table')}}',
            columns: [
                {
                    name: 'nama',
                    data: 'nama',
                },
                {
                    name: 'deskripsi',
                    data: 'deskripsi'
                },
                {
                    name: 'harga',
                    data: 'harga',
                    searchable: false
                },
                {
                    name: 'is_active',
                    data: 'is_active',
                    searchable: false,
                    render: function(data, type, row){
                        return data ? 'Ya' : 'Tidak'
                    }
                },
                {
                    name: 'stock',
                    data: 'stock',
                    searchable: false
                },
                {
                    name: 'suppliers.nama',
                    data: 'nama_supplier'
                },
                {
                    name: 'action',
                    data: 'action'
                }
            ]
        })

        // create product
        $('#create-product').on('click', function(){
            $('#create-product-modal').modal('show');
        })

        // submit new product
        $('#create-product-form').on('submit', function(e){
            e.preventDefault();

            const formCreateProduct = $(this);

            const data = formCreateProduct.serialize();

            $.post('{{route("product.store")}}', data, function( result ) {
                if(result.success){
                    Swal.fire({
                        title: "Created",
                        text: result.message,
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                    });

                    refreshDatatable();

                    $('#create-product-modal').modal('hide');

                    formCreateProduct[0].reset();

                    formCreateProduct.trigger('change');

                    return
                }
            }).fail(function(xhr){
                Swal.fire({
                    title: "Failed",
                    text: xhr.responseJSON.message,
                    type: "error"
                });

                return;
            });
        })

        // edit product
        $('#edit-product-form').on('submit', function(e){
            e.preventDefault();

            const formEditProduct = $(this);

            const data = formEditProduct.serialize();

            const id = $('#product_id_edit').val();

            $.ajax({
                method: "PUT",
                url: '{{route("product.index")}}/' + id,
                data
            }).done(function( result ) {
                if(result.success){
                    Swal.fire({
                        title: "Updated",
                        text: result.message,
                        type: "success",
                        showConfirmButton: false,
                        timer: 1000
                    });

                    refreshDatatable();

                    $('#edit-product-modal').modal('hide');
                }
            }).fail(function(xhr){
                Swal.fire({
                    title: "Failed",
                    text: xhr.responseJSON.message,
                    type: "error"
                });

                return;
            });
        })

        function refreshDatatable(){
            table.ajax.reload(null, false);
        }

        function editProduct(id){
            const editProductModal = $('#edit-product-modal');

            $.get('{{route("product.index")}}/' + id + '/edit', function(result){
                $('#product_id_edit').val(result.data.id);
                $('#nama_edit').val(result.data.nama);
                $('#harga_edit').val(result.data.harga);
                $('#stock_edit').val(result.data.stock);
                $('#supplier_id_edit').val(result.data.supplier_id).trigger('change');
                $('#deskripsi_edit').text(result.data.deskripsi);

                editProductModal.modal('show');
            }).fail(function(xhr){
                Swal.fire({
                    title: "Failed",
                    text: xhr.responseJSON.message,
                    type: "error"
                });

                return;
            })
        }

        function delProduct(id){
            Swal.fire({
                text: "Delete this product ?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            method: "DELETE",
                            url: '{{route("product.index")}}/' + id,
                        }).done(function( result ) {
                            if(result.success){
                                Swal.fire({
                                    title: "Deleted",
                                    text: result.message,
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 1000
                                });
            
                                refreshDatatable();
                            }
                        }).fail(function(xhr){
                            Swal.fire({
                                title: "Failed",
                                text: xhr.responseJSON.message,
                                type: "error"
                            });
            
                            return;
                        });
                    }
            });
        }
    </script>
@stop