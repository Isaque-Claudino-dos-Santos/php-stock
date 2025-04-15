const targetButtons = document.querySelectorAll('.dropdown_target');


const containsHiddenItemsClass = e => e.classList.contains('dropdown_items-hidden')

const defineHiddenItems = e => {
    e.classList.remove('dropdown_items')
    e.classList.add('dropdown_items-hidden')
}

const removeHiddenItems = e => {
    e.classList.add('dropdown_items')
    e.classList.remove('dropdown_items-hidden')
}


const toggleHidden = e => {
    if (containsHiddenItemsClass(e)) {
        removeHiddenItems(e)
        return
    }

    defineHiddenItems(e)
}


const handleOnClickTargetButton = (element, event) => {
    const itemsContainer = element.nextElementSibling;
    const items = itemsContainer.children


    for (const item of items) {
        item.addEventListener('click', () => {
            if (containsHiddenItemsClass(itemsContainer)) {
                return;
            }

            defineHiddenItems(itemsContainer)
        })
    }

    targetButtons.forEach((e) => {
        if (e.nextElementSibling === itemsContainer) {
            return
        }

        defineHiddenItems(e.nextElementSibling)
    });

    toggleHidden(itemsContainer)
}

targetButtons.forEach((element) => {
    element.addEventListener('click', (event) => handleOnClickTargetButton(element, event))
})