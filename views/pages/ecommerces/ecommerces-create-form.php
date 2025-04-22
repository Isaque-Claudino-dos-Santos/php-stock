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
            action: '/ecommerces',
            element: function () {
                component('form/input',
                    id: 'name',
                    label: 'Nome',
                    required: true
                );

                component('form/button', 'Create E-commerce');
            });
        ?>
    </div>
</main>
</body>
</html>