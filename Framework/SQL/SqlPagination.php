<?php

namespace App\Framework\SQL;

readonly class SqlPagination
{
    public function __construct(
        public array $items,
        public int   $limit,
        public int   $page,
        public int   $totalItems,
        public int   $totalPages,
        public bool  $hasNextPage,
        public bool  $hasPreviousPage
    )
    {
    }
}