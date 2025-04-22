<?php
/** @var array $ecommerces */

$ecommercesOptions = array_map(function ($ecommerce) {
    return [
        'value' => $ecommerce['id'],
        'text' => $ecommerce['name']
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

<main class="container-center">
    <div class="w-50">
        <?php
        component('form/root',
            method: 'post',
            action: '/products',
            element: function () use ($ecommerces, $ecommercesOptions) {
                component('form/input',
                    id: 'name',
                    label: 'Nome',
                    required: true
                );

                component('form/input',
                    id: 'description',
                    label: 'Description',
                );

                component('form/input',
                    id: 'price',
                    label: 'Price',
                    required: true,
                );

                component('form/select', id: 'ecommerce', label: 'E-commerce', options: $ecommercesOptions);

                component('form/button', 'Create Product');
            });
        ?>
    </div>
</main>
</body>
</html>