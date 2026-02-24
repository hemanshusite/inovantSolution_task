<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CreateProductRequest;
use App\Http\Requests\Backend\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.products.index');
    }

    public function fetchProducts(Request $request)
    {
        if($request->ajax()) {
            try {
                $products = Product::where('status', 1)->orderBy('created_at', 'desc');

                return DataTables::of($products)
                ->filter(function ($query) use ($request) {
                    if(!empty($request['search']['search_product_name']) && $request['search']['search_product_name'] != null) {
                        $query->where('name', 'like', "%{$request['search']['search_product_name']}%");
                    }
                })
                ->editColumn('name', function($product) {
                    return $product->name;
                })
                ->editColumn('description', function($product) {
                    return $product->description;
                })
                ->editColumn('price', function($product) {
                    return "₹" . number_format($product->price, 2);
                })
                ->editColumn('status', function($product) {
                    return $product->status == 1 ? "Active" : "Inactive";
                })
                ->editColumn('action', function($product) {
                    $actions = '<span class="d-flex gap-2">';
                    $actions .= '<a href="product/view/'.$product->id.'" class="btn btn-sm btn-outline-primary" title="View"><i class="fa fa-eye"></i></a>';
                    $actions .= '<a href="product/edit/'.$product->id.'" class="btn btn-sm btn-outline-success" title="Edit"><i class="fa fa-edit"></i></a>';
                    $actions .= '<a href="product/delete/'.$product->id.'" class="btn btn-sm btn-outline-danger delete-product" data-product_name="'.$product->name.'" data-url="'.route('product.delete', $product->id).'" title="Delete"><i class="fa fa-trash"></i></a>';
                    $actions .= '</span>';
                    return $actions;
                })
                ->addIndexColumn()
                ->rawColumns(['name', 'description', 'price', 'status', 'action'])
                ->setRowId('id')
                ->make(true);
            } catch (\Exception $e) {
                \Log::error("Something went wrong ", $e->getMessage());
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.products.add');
    }

    /**
     * Request validation is handled by CreateProductRequest
     * 
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        try {

            DB::beginTransaction();

            $input = $request->all();

            $product = Product::create([
                'name' => $input['product_name'],
                'description' => $input['product_description'] ?? null,
                'price' => $input['product_price'],
                'stock_quantity' => $input['product_quantity'] ?? 0,
                'discount_price' => $input['product_discount'] ?? null,
                'total_price' => $input['product_price'] - ($input['product_discount'] ?? 0),
                'created_by' => session('data')['admin_id'] ?? null,
            ]);

            $imagePaths = [];

            if ($request->hasFile('product_document')) {
                foreach ($request->file('product_document') as $image) {
                    $fileName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
                    $folderPath = 'product/' . $product->id;
                    $path = $image->storeAs($folderPath, $fileName, 'public');
                    $imagePaths[] = $path;
                }
                $product->update([
                    'image_url' => json_encode($imagePaths)
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => 1,
                'message' => 'Product created successfully',
                'data' => [
                    'redirect_url' => route('product')
                ]
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            \Log::error("Something went wrong ". $e->getMessage());
            return response()->json([
                'success' => 0,
                'message' => 'Something went wrong'
            ]);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['product'] = Product::find($id);

        return view('backend.products.view', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['product'] = Product::find($id);

        return view('backend.products.edit', $data);
    }

    /**
     * Request validation is handled by UpdateProductRequest
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request)
    {
        try {

            DB::beginTransaction();

            $product = Product::findOrFail($request->product_id);

            $product->update([
                'name' => $request->product_name,
                'description' => $request->product_description,
                'price' => $request->product_price,
                'discount_price' => $request->product_discount ?? null,
                'total_price' => $request->product_price - ($request->product_discount ?? 0),
                'stock_quantity' => $request->product_quantity,
                'updated_by' => session('data')['admin_id'] ?? null,
            ]);

            $imagePaths = [];

            if (!empty($product->image_url)) {
                $imagePaths = is_array($product->image_url)
                    ? $product->image_url
                    : json_decode($product->image_url, true);
            }

            if ($request->hasFile('product_document')) {

                foreach ($request->file('product_document') as $image) {

                    $fileName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
                    $folderPath = 'product/' . $product->id;

                    $path = $image->storeAs($folderPath, $fileName, 'public');

                    $imagePaths[] = $path;
                }

                $product->update([
                    'image_url' => json_encode($imagePaths)
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => 1,
                'message' => 'Product updated successfully',
                'data' => [
                    'redirect_url' => route('product')
                ]
            ]);

        } catch (\Exception $e) {

            DB::rollBack();
            \Log::error("Update Product Error: ".$e->getMessage());

            return response()->json([
                'success' => 0,
                'message' => 'Something went wrong'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $product = Product::find($id);

            if ($product) {
                $product->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Product deleted successfully'
                ]);
            }

            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);

        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }
}
