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
        } else {
            fill.style.width = '100%';
            percent.textContent = '100%';
        }
    }

    async function run() {
        const category = select.value;

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
                // двні які відправляються на бекенд
                body: new URLSearchParams({
                    action: 'theme_get_posts_by_category',
                    nonce: apiSyncData.nonce,
                    category,
                    limit: 5,
                    page: 1,
                    lang: 'en'
                })
            });

            const raw = await response.text();
            console.log('RAW RESPONSE:', raw);

            let data;
            try {
                data = JSON.parse(raw);
            } catch (e) {
                throw new Error('Invalid JSON response');
            }

            if (!data.success) {
                status.textContent = data?.data?.message || 'Error occurred';
                fill.style.width = '0%';
                return;
            }

            const articles = data.data?.articles || [];

            setLoading(false);
            status.textContent = `${articles.length} items loaded`;

        } catch (err) {
            console.error('Request failed:', err);
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