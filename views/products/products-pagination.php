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
            'description' => fn($value) => $value,
            'price' => fn($value) => $value,
            'quantity' => fn($value) => $value,
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
        ]
    );

    ?>

    <div>
        <?php if ($paginate['has_previous_page']): ?>
            <button id="btn-previous">Previous</button>
        <?php endif; ?>

        <p><?= $paginate['page'] ?></p>

        <?php if ($paginate['has_next_page']): ?>
            <button id="btn-next">Next</button>
        <?php endif; ?>
    </div>
</main>

<script>
    const btnPrevious = document.querySelector('#btn-previous')
    const btnNext = document.querySelector('#btn-next')
    const url = new URL(location.href)

    let page = Number("<?= $paginate['page'] ?>")

    btnPrevious?.addEventListener('click', () => {
        const hasPreviousPage = Boolean("<?= $paginate['has_previous_page'] ?>");

        if (!hasPreviousPage) return;

        page--;

        url.searchParams.set('page', String(page));
        location.href = url.href;
    })


    btnNext?.addEventListener('click', () => {
        const hasNextPage = Boolean("<?= $paginate['has_next_page'] ?>");

        if (!hasNextPage) return;

        page++

        url.searchParams.set('page', String(page));
        location.href = url.href;
    })
</script>

</body>
</html>