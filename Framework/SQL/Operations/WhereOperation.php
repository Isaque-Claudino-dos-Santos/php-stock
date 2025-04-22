<?php

namespace App\Framework\SQL\Operations;

readonly  class WhereOperation
{
    public function __construct(
        public string       $field,
        public string|array $value,
        public string       $operator = '=',
        public string       $type = 'AND' ?? 'OR'
    )
    {
    }


    public function build(): string
    {

        if (empty($this->value)) {
            return '';
        }


        if ($this->operator === "IN" && is_array($this->value)) {
            $valueToString = implode(',', $this->value);
            return "{$this->field} {$this->operator} ({$valueToString})";
        }

        return "{$this->field} {$this->operator} {$this->value}";
    }
}