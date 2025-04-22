<?php

namespace App\Controllers;

use App\Framework\Request;
use App\Models\Ecommerce;

class EcommerceController
{
    public function ecommercePagination(): void
    {
        $paginate = Ecommerce::statement()
            ->orderBy($request->query['order_column'] ?? 'id', $request->query['order_by'] ?? 'asc')
            ->paginate(page: $request->query['page'] ?? 1, limit: $request->query['limit'] ?? 30);

        response()->sendHtml('views/pages/ecommerces/ecommerces-pagination.php', compact('paginate'));
    }

    public function ecommerceCreateForm(Request $request): void
    {
        response()->sendHtml('views/pages/ecommerces/ecommerces-create-form.php');
    }

    public function ecommerceUpdateForm(Request $request): void
    {
        $id = $request->params['id'];
        response()->sendHtml('views/pages/ecommerces/ecommerces-update-form.php', compact('id'));
    }

    public function ecommerceCreate(Request $request): void
    {
        $body = $request->body;

        Ecommerce::statement()->create([
            'name' => $body['name'],
        ]);
    }

    public function ecommerceUpdate(Request $request): void
    {
        $body = $request->body;
        $id = $request->params['id'];

        Ecommerce::statement()->where('id', $id)->update([
            'name' => $body['name'],
        ]);
    }

    public function ecommerceDelete(Request $request): void
    {
        $id = $request->params['id'];
        Ecommerce::statement()->where('id', $id)->delete();
    }
}