<?php

namespace App\Controllers;

use App\Framework\Request;
use App\Models\Product;

class ProductController
{
    public function productsPagination(Request $request): void
    {
        $paginate = Product::paginate(
            page: $request->query['page'] ?? 1,
        );

        response()->sendHtml('views/products/products-pagination.html', compact('paginate'));
    }

    public function productCreateForm(Request $request): void
    {
        response()->sendHtml('views/products/products-add-form.html');
    }

    public function productUpdateForm(Request $request): void
    {
        $id = $request->params['id'];
        response()->sendHtml('views/products/products-edit-form.html', compact('id'));
    }

    public function productCreate(Request $request): void
    {
        $body = $request->body;

        $product = new Product();
        $product->name = $body['name'];
        $product->description = $body['description'];
        $product->price = $body['price'];
        $product->quantity = $body['quantity'];

        $product->create();
    }

    public function productUpdate(Request $request): void
    {
        $body = $request->body;
        $params = $request->params;

        $product = new Product();
        $product->id = $params['id'];
        $product->name = $body['name'];
        $product->description = $body['description'];
        $product->price = $body['price'];
        $product->quantity = $body['quantity'];

        $product->update();
    }

    public function productDelete(Request $request): void
    {
        $id = $request->params['id'];
        Product::deleteById($id);
    }
}