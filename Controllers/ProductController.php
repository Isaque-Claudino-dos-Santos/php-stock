<?php

namespace App\Controllers;

use App\Framework\Request;
use App\Models\Ecommerce;
use App\Models\Product;
use App\Request\ProductsPaginationFilters;

class ProductController
{
    public function productsPagination(Request $request): void
    {
        $filters = ProductsPaginationFilters::fromArray($request->query);

        $paginate = Product::statement()
            ->whereIn('ecommerce_id', $filters->ecommerces)
            ->orderBy($filters->orderByColumn, $filters->orderBy)
            ->paginate(page: $filters->page, limit: $filters->limit);

        $ecommerces = Ecommerce::statement()->all();

        response()->sendHtml('views/pages/products/products-pagination.php', compact('paginate', 'ecommerces'));
    }

    public function productCreateForm(Request $request): void
    {
        $ecommerces = Ecommerce::statement()->all();

        response()->sendHtml('views/pages/products/products-create-form.php', compact('ecommerces'));
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
            'ecommerce_id' => $body['ecommerce'],
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