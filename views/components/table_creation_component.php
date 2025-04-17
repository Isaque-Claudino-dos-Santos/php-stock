<?php

/** @var array $items */
/** @var array $lines */
/** @var array $headers */


component('table/root', function () use ($lines, $items, $headers) {
    component('table/header', function () use ($headers) {
        component('table/line', function () use ($headers) {
            foreach ($headers as $header) {
                component('table/head_cell', $header);
            }
        });
    });

    component('table/body', function () use ($items, $lines) {
        foreach ($items as $item) {
            component('table/line', function () use ($item, $lines) {
                foreach ($lines as $keyOfItem => $callback) {

                    component('table/cell', function () use ($callback, $item, $keyOfItem): string {
                        if (key_exists($keyOfItem, $item)) {
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