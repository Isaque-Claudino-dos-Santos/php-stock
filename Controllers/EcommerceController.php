<?php

namespace App\Controllers;

use App\Framework\Request;
use App\Models\Ecommerce;

class EcommerceController
{
    public function ecommercePagination(): void
    {

        $paginate = mysql()->paginate(
            model: Ecommerce::class,
            limit: 30,
            page: $request->query['page'] ?? 1,
            orderBy: $request->query['order_by'] ?? 'asc',
            orderColumn: $request->query['order_column'] ?? 'id',
        );

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

        mysql()->create(Ecommerce::class, [
            'name' => $body['name'],
        ]);
    }

    public function ecommerceUpdate(Request $request): void
    {
        $body = $request->body;
        $params = $request->params;

        mysql()->update(Ecommerce::class, $params['id'], [
            'name' => $body['name'],
        ]);
    }

    public function ecommerceDelete(Request $request): void
    {
        $id = $request->params['id'];
        mysql()->deleteById(Ecommerce::class, $id);
    }
}