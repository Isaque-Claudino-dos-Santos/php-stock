<?php


/** @var array $paginate */
/** @var array<\App\Models\Ecommerce> $ecommerces */


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

<!--    TODO: implement filter by e-commerce -->
<!--    <form method="GET" action="/products">-->
<!--        --><?php //foreach ($ecommerces as $ecommerce): ?>
<!--            <label for="ecommerce---><?php //= $ecommerce->id ?><!--">--><?php //= $ecommerce->name ?><!--</label>-->
<!--            <input type="checkbox" id="ecommerce---><?php //= $ecommerce->id ?><!--" name="ecommerces[]" value="--><?php //= $ecommerce->id ?><!--"/>-->
<!--        --><?php //endforeach; ?>
<!---->
<!--        <button>FIND</button>-->
<!--    </form>-->


    <?php

    component('table_creation',
        items: $paginate['items'],
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
                    href: "/products/update/{$item->id}",
                );
            },
            function ($item) {
                component('form/root',
                    action: "/products/{$item->id}",
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