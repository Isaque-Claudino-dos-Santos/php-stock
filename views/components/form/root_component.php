<?php
/**@var string|null $method */
/**@var string|null $action */
/**@var Closure|null $element */

$method = strtoupper($method);

?>

<form method="<?= $method === 'GET' ? 'GET' : 'POST' ?>" action="<?= $action ?>" class="form">
    <input type="hidden" name="_method" value="<?= $method ?>"/>

    <?php
    if (is_callable($element)) {
        call_user_func($element);
    } else {
        echo $element ?? '';
    }
    ?>
</form>