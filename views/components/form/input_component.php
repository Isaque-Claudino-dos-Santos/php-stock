<?php
/** @var string $id */
/** @var string $label */
/** @var bool|null $required */

$attributeRequired = $required ?? false ? 'required' : '';
?>

<div class="form_group">
    <label for="<?= $id ?>" class="form_label"><?= $label ?></label>
    <input type="text" id="<?= $id ?>" name="<?= $id ?>" class="form_input" <?= $attributeRequired ?> />
</div>