<?php
/** @var array $paginate */
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

    <?php

    component('table_creation',
        items: $paginate['items'],
        headers: ['ID', 'Name', 'Price', 'Quantity', 'Description', 'Creation Date', '', ''],
        lines: [
            'id' => fn($value) => $value,
            'name' => fn($value) => $value,
            'price' => fn($value) => $value,
            'quantity' => fn($value) => $value,
            'description' => fn($value) => $value,
            'created_at' => fn($value) => $value,
            function (array $item) {
                component('link',
                    text: 'Update',
                    href: "/products/update/{$item['id']}",
                );
            },
            function (array $item) {
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