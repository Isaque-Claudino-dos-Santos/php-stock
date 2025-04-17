<!doctype html>
<html lang="pt-br">

<head>
    <?php template('head') ?>
</head>

<body>

<header class="container">


    <?php
    component('title',
        text: 'Welcome to Home Page',
        class: 'ml-1 p-1'
    );

    ?>

    <nav class="flex gap border rounded p-2">
        <div class="dropdown">
            <button class="dropdown_target">Produto</button>
            <ul class="dropdown_items-hidden">
                <li class="dropdown_items_item"><a href="/products">Lista de Produtos</a></li>
                <li class="dropdown_items_item"><a href="/products/create">Criar Produto</a></li>
            </ul>
        </div>
    </nav>

</header>

</body>
</html>