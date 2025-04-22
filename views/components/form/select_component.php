<?php
/** @var array $options */
/** @var string|null $label */
/** @var string $id */
/** @var bool|null $mult */

$attrMultiple = $mult ?? false ? 'multiple' : '';

?>

<label for="<?= $id ?>" class="form_label"><?= $label ?? '' ?></label>
<select id="<?= $id ?>" name="<?= !$attrMultiple ? $id : $id . '[]' ?>" class="form_select" <?= $attrMultiple ?>>
    <option hidden selected class="form_select_option" value="">Select <?= $label ?? '' ?></option>
    <?php foreach ($options as $option): ?>
        <option value="<?= $option['value'] ?>" class="form_select_option">
            <span class="form_select_content"><?= $option['text'] ?></span>
        </option>
    <?php endforeach; ?>
</select>
