<?php
/** @var string|null $text */
/** @var string|null $element */
/** @var string|null $orderColumn */
/** @var string|null $enabledOrder */

if (isset($orderColumn)) {
    $orderColumn = "data-order-column=\"$orderColumn\"";
}

?>

<th
        class="table_head_cell"
        id="table_head_cell"
        data-enabled-order="<?= boolval($enabledOrder) ?>"
    <?= $orderColumn ?>
>
    <?= $text ?? $element ?? '' ?>
</th>