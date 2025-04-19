<!doctype html>
<html lang="pt-br">

<head>
    <?php template('head') ?>
</head>

<body>

<header class="container">


    <?php
    component(
        'title',
        text: 'Welcome to Home Page',
        class: 'ml-1 p-1'
    );
    ?>

    <nav class="flex gap border rounded p-2">
        <?php
        component(
            'dropdown',
            label: 'Product',
            items: [
                ['text' => 'Lista de Produtos', 'href' => '/products'],
                ['text' => 'Criar Produto', 'href' => '/products/create'],
            ]
        )
        ?>
    </nav>

</header>

</body>
</html>