<?php


/** @var \App\Framework\SQL\SqlPagination $paginate */
/** @var array<\App\Models\Ecommerce> $ecommerces */


$ecommercesOptions = array_map(function ($ecommerce) {
    return [
        'value' => $ecommerce->id,
        'text' => "{$ecommerce->id} - {$ecommerce->name}"
    ];
}, $ecommerces);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php template('head') ?>
</head>

<body>

<header>
    <a href="/"><</a>
</header>


<main class="container">
    <a href="/products/create">Create a new product +</a>

    <hr/>

    <?php

    component('form/root',
        method: "GET",
        action: '/products',
        element: function () use ($ecommercesOptions) {
            component("form/select", id: 'ecommerces', label: 'E-commerces', mult: true, options: $ecommercesOptions);
            // TODO: <input type="hidden" name="ecommerces" value="[1, 2, 3, 4]" /> implemente new form select

            component("form/button", 'filter');
        });
    ?>

    <hr/>

    <?php
    component('table_creation',
        items: $paginate->items,
        headers: ['ID', 'Name', 'Price', 'Description', 'Creation Date', '', ''],
        lines: [
            'id' => fn($value) => $value,
            'name' => fn($value) => $value,
            'price' => fn($value) => $value,
            'description' => fn($value) => $value,
            'createdAt' => fn($value) => $value,
            function ($item) {
                component('link',
                    text: 'Update',
                    href: "/products/update/{$item['id']}",
                );
            },
            function ($item) {
                component('form/root',
                    action: "/products/{$item['id']}",
                    method: 'delete',
                    element: '<button>DELETE</button>'
                );
            }
        ],
    );

    ?>


    <div class="flex-center-col">
        <?php component('pagination', paginate: $paginate); ?>
    </div>


</main>

<script>

    (() => {
        const headCells = document.querySelectorAll('#table_head_cell');
        const url = new URL(location.href)


        headCells.forEach((element) => {
            element.addEventListener('click', (event) => {
                const isEnabledOrderBy = Boolean(element.getAttribute('data-enabled-order'));

                if (!isEnabledOrderBy) {
                    return;
                }

                element.setAttribute('data-order-by', url.searchParams.get('order_by') ?? 'asc')

                element.getAttribute('data-order-by') === 'desc' ?
                    element.setAttribute('data-order-by', 'asc') :
                    element.setAttribute('data-order-by', 'desc')

                url.searchParams.set('order_by', element.getAttribute('data-order-by'));
                url.searchParams.set('order_column', element.getAttribute('data-order-column'));
                location.href = url.href;
            })
        })
    })()
</script>

</body>
</html>