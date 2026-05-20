export function apiInit() {

    const btn = document.getElementById('start-sync');
    const select = document.getElementById('api-category');

    const fill = document.getElementById('api-progress-fill');
    const percent = document.getElementById('sync-percent');
    const status = document.querySelector('.api__progress-status');

    if (!btn || !select || !fill || !percent || !status) return;

    function resetUI() {
        fill.style.width = '0%';
        percent.textContent = '0%';
        status.textContent = 'Ready...';
    }

    function setLoading(isLoading) {

        if (isLoading) {
            fill.style.width = '50%';
            percent.textContent = '';
            status.textContent = 'Loading...';
            return;
        }

        fill.style.width = '100%';
        percent.textContent = '100%';
    }

    async function run() {

        const selectedCategories = [...select.selectedOptions]
            .map(option => option.value);

        if (!selectedCategories.length) {
            status.textContent = 'Select categories';
            return;
        }

        btn.disabled = true;
        btn.classList.add('disabled');

        resetUI();
        setLoading(true);

        try {

            const response = await fetch(apiSyncData.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },

                body: new URLSearchParams([
                    ['action', 'theme_get_posts_by_category'],
                    ['nonce', apiSyncData.nonce],
                    ['limit', 2],
                    ['page', 1],
                    ['lang', 'en'],

                    ...selectedCategories.map(category => [
                        'categories[]',
                        category
                    ])
                ])
            });

            const raw = await response.text();

            console.log('RAW RESPONSE:', raw);

            let data;

            try {
                data = JSON.parse(raw);
            } catch (error) {
                throw new Error('Invalid JSON response');
            }

            if (!data.success) {
                status.textContent =
                    data?.data?.message || 'Error occurred';

                fill.style.width = '0%';

                return;
            }

            const articles = data?.data?.articles || [];

            console.log('ARTICLES:', articles);

            setLoading(false);

            status.textContent =
                `${articles.length} items loaded`;

        } catch (error) {

            console.error('Request failed:', error);

            status.textContent = 'Request failed';
            fill.style.width = '0%';

        } finally {

            btn.disabled = false;
            btn.classList.remove('disabled');
        }
    }

    btn.addEventListener('click', run);
}

apiInit();

export function multiSelect() {

    const container = document.querySelector('.api__multiselect');
    if (!container) return;

    const trigger = container.querySelector('.api__multiselect-trigger');
    const chips = container.querySelector('.api__multiselect-chips');
    const dropdown = container.querySelector('.api__multiselect-dropdown');
    const select = document.getElementById('api-category');
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