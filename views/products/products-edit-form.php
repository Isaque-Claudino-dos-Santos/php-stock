<?php
/** @var string $id */
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
        <form method="POST" action="/products/<?= $id ?>" class="form">
            <input type="hidden" name="_method" value="PUT">

            <?php
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

            component('form/input',
                id: 'quantity',
                label: 'Quantity',
            );
            ?>

            <button class="form_button">Update Product</button>
        </form>
    </div>
</main>

</body>
</html>