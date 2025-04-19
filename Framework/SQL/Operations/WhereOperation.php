<?php

namespace App\Framework\SQL\Operations;

readonly  class WhereOperation
{
    public function __construct(
        public string $field,
        public string $value,
        public string $operator = '=',
        public string $type = 'AND' ?? 'OR'
    )
    {
    }


    public function build(): string
    {
        return "{$this->field} {$this->operator} {$this->value}";
    }
}