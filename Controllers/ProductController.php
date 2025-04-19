<?php

namespace App\Controllers;

use App\Framework\Request;
use App\Models\Ecommerce;
use App\Models\Product;

class ProductController
{
    public function productsPagination(Request $request): void
    {
        $paginate = mysql()->paginate(
            model: Product::class,
            limit: 30,
            page: $request->query['page'] ?? 1,
            orderBy: $request->query['order_by'] ?? 'asc',
            orderColumn: $request->query['order_column'] ?? 'id',
        );

        $ecommerces = mysql()->all(Ecommerce::class, 'name', 'id');

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

        mysql()->create(Product::class, [
            'name' => $body['name'],
            'description' => $body['description'],
            'price' => $body['price'],
        ]);
    }

    public function productUpdate(Request $request): void
    {
        $body = $request->body;
        $params = $request->params;

        mysql()->update(Product::class, $params['id'], [
            'name' => $body['name'],
            'description' => $body['description'],
            'price' => $body['price'],
        ]);
    }

    public function productDelete(Request $request): void
    {
        $id = $request->params['id'];
        mysql()->deleteById(Product::class, $id);
    }
}