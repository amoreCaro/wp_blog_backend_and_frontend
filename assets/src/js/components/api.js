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

    function setProgress(p, text = '') {
        fill.style.width = `${p}%`;
        percent.textContent = `${p}%`;
        if (text) status.textContent = text;
    }

    function setDone(stats) {
        fill.style.width = '100%';
        percent.textContent = '100%';

        status.textContent =
            `Fetched: ${stats.fetched}, Inserted: ${stats.inserted}, Skipped: ${stats.skipped}`;
    }

    async function run() {
        const category = select.value;

        btn.disabled = true;
        btn.classList.add('disabled');

        resetUI();
        setProgress(40, 'Syncing...');

        try {
            const response = await fetch(apiSyncData.ajax_url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: new URLSearchParams({
                    action: 'theme_get_posts_by_category',
                    nonce: apiSyncData.nonce,
                    category,
                    limit: 5,
                    page: 1,
                    lang: 'en'
                })
            });

            const data = await response.json();

            if (!data.success) {
                throw new Error(data?.data?.message || 'API error');
            }

            const payload = data.data;

            setProgress(80, 'Saving posts...');
            
            setTimeout(() => {
                setDone(payload.stats);
            }, 300);

        } catch (err) {
            console.error(err);
            status.textContent = err.message || 'Request failed';
            fill.style.width = '0%';
            percent.textContent = '0%';
        } finally {
            btn.disabled = false;
            btn.classList.remove('disabled');
        }
    }

    btn.addEventListener('click', run);
}

apiInit();