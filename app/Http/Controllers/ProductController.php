<?php

namespace App\Http\Controllers;

use App\Exceptions\BadRequestException;
use App\Http\Requests\CreateProductFormRequest;
use App\Http\Requests\EditProductFormRequest;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\HelperService;
use Exception;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    protected $helper;

    public function __construct(HelperService $helper)
    {
        $this->helper = $helper;
    }

    public function datatable(){
        $products = Product::select('products.*', 'suppliers.nama as nama_supplier')->leftjoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')->orderBy('products.created_at', 'desc');

        return DataTables::of($products)->addColumn('action', 'admin.product.action')->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $suppliers = Supplier::get(['id', 'nama'])->pluck('nama', 'id');

        return view('admin.product.index', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductFormRequest $request)
    {
        //
        $data = $request->validated();

        try {
            //code...
            $product = Product::create($data);

            return $this->helper->successResponse('Product created successfully', $product);
        } catch (\Throwable $th) {
            //throw $th;
            throw new Exception($th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        try {
            $product = $this->findProductById($id);

            return $this->helper->successResponse('Fetching a product successfully', $product);
        } catch (\Throwable $th) {
            if($th instanceof BadRequestException){
                return $this->helper->failedResponse($th->getMessage(), $th->getCode());
            }

            throw new Exception($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditProductFormRequest $request, $id)
    {
        //
        $data = $request->validated();

        try {
            $product = $this->findProductById($id);

            $product->update($data);

            return $this->helper->successResponse("{$product->nama} has been updated successfully", $product);
        } catch (\Throwable $th) {
            //throw $th;
            if($th instanceof BadRequestException){
                return $this->helper->failedResponse($th->getMessage(), $th->getCode());
            }

            throw new Exception($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            //code...
            $product = $this->findProductById($id);

            $product->delete();

            return $this->helper->successResponse("{$product->nama} has been deleted successfully", $product);
        } catch (\Throwable $th) {
            //throw $th;
            if($th instanceof BadRequestException){
                return $this->helper->failedResponse($th->getMessage(), $th->getCode());
            }
    
            throw new Exception($th->getMessage());
        }
    }

    public function findProductById($id){
        $product = Product::find($id);

        if(!$product){
            throw new BadRequestException('Product not found', 400);
        }

        return $product;
    }
}
