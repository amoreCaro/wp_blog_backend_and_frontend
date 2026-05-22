export function apiInit() {
    const form = document.querySelector('.api__form');
    if (!form) return;

    const submit = form.querySelector('.api__btn');
    const limitInput = form.querySelector('.api__posts-per-category');
    const select = form.querySelector('#api__category');
    const chipsContainer = form.querySelector('.api__multiselect-chips');

    const fill = document.querySelector('.api__progress-fill');
    const percent = document.querySelector('.api__progress-percent');
    const status = document.querySelector('.api__progress-status');

    const plus = form.querySelector('.api__button--increment');
    const minus = form.querySelector('.api__button--decrement');

    const MAX_POSTS = 100;

    function resetUI() {
        fill.style.width = '0%';
        percent.textContent = '0%';
        status.textContent = 'Ready';
    }

    function setLoading() {
        fill.style.width = '40%';
        status.textContent = 'Loading...';
    }

    function setDone(count) {
        fill.style.width = '100%';
        percent.textContent = '100%';
        status.textContent = `${count} items loaded`;
    }

    function setError(message) {
        status.textContent = message;
        fill.style.width = '0%';
    }

    function getSelectedCategories() {
        return [...select.selectedOptions].map(opt => opt.value);
    }

    function getLimit() {
        return parseInt(limitInput.value, 10) || 1;
    }

    function validate() {
        const categories = getSelectedCategories();
        const total = categories.length * getLimit();

        let isValid = true;

        if (!categories.length) {
            isValid = false;
        }

        if (total > MAX_POSTS) {
            setError(`Limit exceeded: ${total}/${MAX_POSTS} posts`);
            isValid = false;
        }

        submit.disabled = !isValid;

        if (isValid) {
            status.textContent = 'Ready';
        }

        return isValid;
    }

    function runValidation() {
        return validate();
    }

    plus?.addEventListener('click', () => {
        const next = getLimit() + 1;
        const categoriesCount = getSelectedCategories().length;

        limitInput.value = next;

        if (categoriesCount * next > MAX_POSTS) {
            setError(`Max limit reached (${MAX_POSTS})`);
        }

        runValidation();
    });

    minus?.addEventListener('click', () => {
        limitInput.value = Math.max(1, getLimit() - 1);
        runValidation();
    });

    select.addEventListener('change', runValidation);

    limitInput.addEventListener('input', runValidation);

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!runValidation()) return;

        const categories = getSelectedCategories();
        const limit = getLimit();

        const body = new URLSearchParams({
            action: 'theme_get_posts_by_category',
            nonce: apiSyncData.nonce,
            limit,
            page: 1,
            lang: 'en'
        });

        categories.forEach(cat => {
            body.append('categories[]', cat);
        });

        submit.disabled = true;
        submit.classList.add('is-loading');

        resetUI();
        setLoading();

        try {
            const res = await fetch(apiSyncData.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body
            });

            const data = await res.json();

            if (!data.success) {
                setError(data?.data?.message || 'Error occurred');
                fill.style.width = '0%';
                return;
            }

            const articles = data?.data?.articles || [];
            setDone(articles.length);

        } catch (err) {
            console.error(err);
            setError('Request failed');
        } finally {
            submit.disabled = false;
            submit.classList.remove('is-loading');
        }
    });
}

apiInit();

export function multiSelect() {

    const container = document.querySelector('.api__multiselect');
    if (!container) return;

    const trigger = container.querySelector('.api__multiselect-trigger');
    const chips = container.querySelector('.api__multiselect-chips');
    const dropdown = container.querySelector('.api__multiselect-dropdown');
    const select = document.getElementById('api__category');
    const placeholder = container.querySelector('.api__multiselect-placeholder');
    const arrow = container.querySelector('.api__multiselect-arrow');

    const template = document.querySelector('#chip-template');

    let selected = [];

    function open() {
        dropdown.classList.add('open');
        trigger.classList.add('open');
        arrow.classList.add('open');
    }

    function close() {
        dropdown.classList.remove('open');
        trigger.classList.remove('open');
        arrow.classList.remove('open');
    }

    function toggle() {
        dropdown.classList.contains('open') ? close() : open();
    }

    function syncSelect() {
        if (!select) return;

        select.querySelectorAll('option').forEach(opt => {
            opt.selected = selected.includes(opt.value);
        });
    }

    function updateOptions() {
        container.querySelectorAll('.api__multiselect-option').forEach(option => {
            option.classList.toggle('selected', selected.includes(option.dataset.slug));
        });
    }

    function render() {
        chips.innerHTML = '';

        if (selected.length === 0) {
            chips.appendChild(placeholder);
            return;
        }

        selected.forEach(slug => {
            const option = container.querySelector(`[data-slug="${slug}"]`);
            const name = option?.dataset.name || slug;

            const chipNode = template
                .querySelector('.api__multiselect-chip')
                .cloneNode(true);

            const text = chipNode.querySelector('.api__multiselect-chip-name');
            const removeBtn = chipNode.querySelector('.api__multiselect-chip-remove');

            text.textContent = name;
            removeBtn.dataset.slug = slug;

            chips.appendChild(chipNode);
        });
    }

    function toggleItem(slug) {
        if (selected.includes(slug)) {
            selected = selected.filter(i => i !== slug);
        } else {
            selected.push(slug);
        }

        syncSelect();
        updateOptions();
        render();
    }

    trigger.addEventListener('click', (e) => {
        e.stopPropagation();
        toggle();
    });

    dropdown.addEventListener('click', (e) => {
        const option = e.target.closest('.api__multiselect-option');
        if (!option) return;

        toggleItem(option.dataset.slug);
    });

    chips.addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (!btn) return;

        e.stopPropagation();
        toggleItem(btn.dataset.slug);
    });

    document.addEventListener('click', (e) => {
        if (!container.contains(e.target)) close();
    });

    render();
}

multiSelect();

export function postsPerCategory() {
    const input = document.querySelector(".api_posts-per-category");
    const incrementBtn = document.querySelector(".api__button--increment");
    const decrementBtn = document.querySelector(".api__button--decrement");

    if (!input || !incrementBtn || !decrementBtn) return;

    // 🔒 захист від повторної ініціалізації
    if (input.dataset.counterInit === "1") return;
    input.dataset.counterInit = "1";

    const MIN = Number(input.min ?? 0);

    function getValue() {
        const value = Number.parseInt(input.value, 10);
        return Number.isNaN(value) ? MIN : value;
    }

    function setValue(value) {
        input.value = value;
        input.dispatchEvent(new Event("input", { bubbles: true }));
    }

    function increment() {
        setValue(getValue() + 1);
    }

    function decrement() {
        setValue(Math.max(MIN, getValue() - 1));
    }

    incrementBtn.addEventListener("click", (e) => {
        e.preventDefault();
        increment();
    });

    decrementBtn.addEventListener("click", (e) => {
        e.preventDefault();
        decrement();
    });
}

postsPerCategory();