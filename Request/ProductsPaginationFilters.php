<?php

namespace App\Request;


readonly class ProductsPaginationFilters extends BasePaginationFilters
{
    public function __construct(int $page, int $limit, string $orderBy, string $orderByColumn, public array $ecommerces)
    {
        parent::__construct($page, $limit, $orderBy, $orderByColumn);
    }

    public static function fromArray(array $data): self
    {
        return new self(
            page: $data['page'] ?? 1,
            limit: $data['limit'] ?? 30,
            orderBy: $data['order_by'] ?? 'asc',
            orderByColumn: $data['order_column'] ?? 'id',
            ecommerces: self::toArray($data['ecommerces'] ?? [])
        );
    }

}