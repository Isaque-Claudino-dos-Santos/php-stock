<?php
/** @var \App\Framework\SQL\SqlPagination $paginate */
?>

<!doctype html>
<html lang="en">
<head>
    <?php
    template('head');
    ?>
</head>
<body>

<header>
    <a href="/"><</a>
</header>

<a href="/ecommerces/create">Create a new e-commerce +</a>

<?php
component('table_creation',
    items: $paginate->items,
    headers: ['ID', 'Name', 'Creation Date', '', ''],
    lines: [
        'id' => fn($value) => $value,
        'name' => fn($value) => $value,
        'createdAt' => fn($value) => $value,
        function ($item) {
            component('link',
                text: 'Update',
                href: "/ecommerces/update/{$item['id']}",
            );
        },
        function ($item) {
            component('form/root',
                action: "/ecommerces/{$item['id']}",
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

</body>
</html>