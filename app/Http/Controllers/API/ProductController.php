<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::withTrashed()
                    ->when(request('search'), function($query) {
                        $query->where('name', 'like', '%'.request('search').'%');
                    })
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);

        return response()->json([
            'data' => $products,
            'message' => 'Products retrieved successfully'
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product = Product::create($request->all());

        return response()->json([
            'data' => $product,
            'message' => 'Product created successfully'
        ], Response::HTTP_CREATED);
    }

    public function show(Product $product)
    {
        return response()->json([
            'data' => $product,
            'message' => 'Product retrieved successfully'
        ], Response::HTTP_OK);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'is_active' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product->update($request->all());

        return response()->json([
            'data' => $product,
            'message' => 'Product updated successfully'
        ], Response::HTTP_OK);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Product soft deleted successfully'
        ], Response::HTTP_OK);
    }

    public function forceDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->forceDelete();

        return response()->json([
            'message' => 'Product permanently deleted'
        ], Response::HTTP_OK);
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return response()->json([
            'data' => $product,
            'message' => 'Product restored successfully'
        ], Response::HTTP_OK);
    }
}