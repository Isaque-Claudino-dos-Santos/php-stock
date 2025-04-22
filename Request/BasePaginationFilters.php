<?php

namespace App\Request;

abstract readonly class BasePaginationFilters
{
    public function __construct(
        public int    $page,
        public int    $limit,
        public string $orderBy,
        public string $orderByColumn,
    )
    {
    }


    abstract public static function fromArray(array $data): self;


    public static function toArray(mixed $data): array
    {
        if (is_array($data)) {
            return array_filter($data, function ($item) {
                return !empty($item);
            });
        }

        return [];
    }
}