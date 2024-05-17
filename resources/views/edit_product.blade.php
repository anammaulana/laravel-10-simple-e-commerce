@extends('layouts.index')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="bg-blue-600 text-white p-4 rounded-t-lg font-bold text-xl">Edit Product</div>

                <div class="p-4">
                    @if (session('message'))
                        <div class="bg-green-500 text-white font-semibold p-3 rounded-lg shadow-md" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="bg-red-500 text-white font-semibold p-3 rounded-lg" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('update_product', $product)}}" method="post" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="name" class="font-semibold">Name</label>
                            <input type="text" id="name" name="name" class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{$product->name}}" placeholder="Enter product name">
                        </div>
                        <div class="form-group">
                            <label for="description" class="font-semibold">Description</label>
                            <textarea id="description" name="description" class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" rows="3">{{$product->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="category" class="font-semibold">Category</label>
                            <input type="text" id="category" name="category" class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{$product->category}}" placeholder="Enter product category">
                        </div>
                        <div class="form-group">
                            <label for="price" class="font-semibold">Price</label>
                            <input type="number" id="price" name="price" class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{$product->price}}" placeholder="Enter product price">
                        </div>
                        <div class="form-group">
                            <label for="stock" class="font-semibold">Stock</label>
                            <input type="number" id="stock" name="stock" class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" value="{{$product->stock}}" placeholder="Enter product stock">
                        </div>
                        <div class="form-group">
                            <label for="image" class="font-semibold">Image</label>
                            <input type="file" id="image" name="image" class="form-control-file mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button type="submit" class="btn btn-success mt-3 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
