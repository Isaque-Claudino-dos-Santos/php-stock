<?php
/** @var string|null $text */
/** @var string|null $element */
/** @var bool|null $center */

$defaultClass = $center ?? false ? 'table_cell-center' : 'table_cell'
?>

<td class="<?= $defaultClass ?>"><?= $text ?? is_callable($element) ? $element() : $element ?? '' ?></td>