<?php

namespace App\Controllers;

use App\Framework\Request;
use App\Models\Ecommerce;
use App\Models\Product;

class ProductController
{
    public function productsPagination(Request $request): void
    {
        $paginate = Product::statement()
            ->orderBy($request->query['order_column'] ?? 'id', $request->query['order_by'] ?? 'asc')
            ->paginate(page: $request->query['page'] ?? 1);


        $ecommerces = Ecommerce::statement()->all();

        response()->sendHtml('views/pages/products/products-pagination.php', compact('paginate', 'ecommerces'));
    }

    public function productCreateForm(Request $request): void
    {
        response()->sendHtml('views/pages/products/products-create-form.php');
    }

    public function productUpdateForm(Request $request): void
    {
        $id = $request->params['id'];
        response()->sendHtml('views/pages/products/products-update-form.php', compact('id'));
    }

    public function productCreate(Request $request): void
    {
        $body = $request->body;

        Product::statement()->create([
            'name' => $body['name'],
            'description' => $body['description'],
            'price' => $body['price'],
        ]);
    }

    public function productUpdate(Request $request): void
    {
        $id = $request->params['id'];
        $body = $request->body;

        Product::statement()
            ->where('id', $id)
            ->update([
                'name' => $body['name'],
                'description' => $body['description'],
                'price' => $body['price'],
            ]);
    }

    public function productDelete(Request $request): void
    {
        $id = $request->params['id'];
        Product::statement()->where('id', $id)->delete();
    }
}