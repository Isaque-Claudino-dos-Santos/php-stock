<?php

/** @var array $items */
/** @var array $lines */
/** @var array $headers */


component('table/root', function () use ($lines, $items, $headers) {
    component('table/header', function () use ($headers, $lines) {
        component('table/line', function () use ($headers, $lines) {
            foreach ($headers as $key => $header) {
                $orderColumn = array_keys($lines)[$key];
                component('table/head_cell',
                    text: $header,
                    orderColumn: $orderColumn,
                    enabledOrder: key_exists($orderColumn, $lines) && !is_numeric($orderColumn)
                );
            }
        });
    });

    component('table/body', function () use ($items, $lines) {
        foreach ($items as $item) {
            component('table/line', function () use ($item, $lines) {
                foreach ($lines as $keyOfItem => $callback) {

                    component('table/cell', function () use ($callback, $item, $keyOfItem) {
                        $keyOfItem = camelCaseToSnakeCase($keyOfItem);

                        if (is_object($item) && property_exists($item, $keyOfItem)) {
                            return call_user_func_array($callback, [$item->$keyOfItem]);
                        }

                        if (is_array($item) && key_exists($keyOfItem, $item)) {
                            return call_user_func_array($callback, [$item[$keyOfItem]]);
                        }

                        $value = call_user_func_array($callback, [$item]);

                        if (!is_string($value)) {
                            return '';
                        }

                        return $value;
                    });
                }
            });
        }
    });
});