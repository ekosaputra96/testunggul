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
                <th scope="col">Created At</th>
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

    {{-- product modal --}}
    <div class="modal" tabindex="-1" id="product-modal">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <form id="product-form">
                <div class="modal-header">
                  <h5 class="modal-title" id="modal-title-header">-</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Product</label>
                                <input type="text" class="form-control" name="nama" id="nama">
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
                                <select class="form-control" name="supplier_id">
                                    @foreach ($suppliers as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
    
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary" id="product-submit-button">-</button>
                </div>
            </form>
          </div>
        </div>
    </div>
@stop

@section('css')
@stop

@routes

@section('js')
    <script src="{{ mix('/js/product.js') }}" defer></script>
@stop