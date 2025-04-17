<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?= template('head') ?>
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
                element: function () {
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
                });
            ?>

            <button class="form_button">Create Product</button>

        </form>
    </div>
</main>
</body>
</html>