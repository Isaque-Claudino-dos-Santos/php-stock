<?php

/** @var string|null $label */
/** @var array $items */

?>

<div class="dropdown">
    <button class="dropdown_target"><?= $label ?? '' ?></button>
    <ul class="dropdown_items-hidden">
        <?php foreach ($items as $item): ?>
            <li class="dropdown_items_item"><a href="<?= $item['href'] ?? '#' ?>"><?= $item['text'] ?? '' ?></a></li>
        <?php endforeach; ?>
    </ul>
</div>