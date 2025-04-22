<?php

/** @var \App\Framework\SQL\SqlPagination $paginate */

?>

<div class="flex">
    <?php if ($paginate->hasPreviousPage): ?>
        <button id="pagination-previous">
            <?php component('icons/previous', class: 'pagination_button-previous'); ?>
        </button>
    <?php endif; ?>

    <label>
        <input type="text" class="pagination_page" value="<?= $paginate->page ?>" id="pagination_current_page"/>
    </label>

    <?php if ($paginate->hasNextPage): ?>
        <button id="pagination-next">
            <?php component('icons/next', class: 'pagination_button-next'); ?>
        </button>
    <?php endif; ?>
</div>

<p>pages: <?= $paginate->totalPages ?></p>


<script>
    (() => {
        const url = new URL(location.href)
        let page = Number("<?= $paginate->page ?>")


        document.querySelector('#pagination_current_page')
            ?.addEventListener('keyup', (event) => {
                const page = event.target.value;
                const pattern = new RegExp(/^([0-9]*)$/)

                event.target.value = page.split('').filter((char) => pattern.test(char)).join('')


                if (event.code === 'Enter') {
                    url.searchParams.set('page', page);
                    location.href = url.href;
                }
            })

        document.querySelector('#pagination-previous')
            ?.addEventListener('click', () => {
                const hasPreviousPage = Boolean("<?= $paginate->hasPreviousPage ?>");

                if (!hasPreviousPage) return;

                page--;

                url.searchParams.set('page', String(page));
                location.href = url.href;
            })


        document.querySelector('#pagination-next')
            ?.addEventListener('click', () => {
                const hasNextPage = Boolean("<?= $paginate->hasNextPage ?>");

                if (!hasNextPage) return;

                page++

                url.searchParams.set('page', String(page));
                location.href = url.href;
            })
    })()
</script>
