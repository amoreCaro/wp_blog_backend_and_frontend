export function initReadMore() {
    // Шукаємо всі блоки "Read More" за їхнім базовим класом БЕМ
    const blocks = document.querySelectorAll('.read-more-block');

    blocks.forEach(block => {
        const btn = block.querySelector('.read-more-block__btn');
        const wrapper = block.querySelector('.read-more-block__content-wrapper');
        const overlay = block.querySelector('.read-more-block__overlay');
        const textHolder = block.querySelector('.read-more-block__text');

        if (!btn || !wrapper || !textHolder) return;

        btn.addEventListener('click', function() {
            // Перевірка стану (160px — це початковий стан)
            const isCollapsed = wrapper.style.maxHeight === '160px' || wrapper.style.maxHeight === '';

            if (isCollapsed) {
                // Розгортаємо: встановлюємо висоту відповідно до scrollHeight внутрішнього тексту
                wrapper.style.maxHeight = textHolder.scrollHeight + "px";
                if (overlay) overlay.style.opacity = '0';
                this.textContent = 'Show Less';
            } else {
                // Згортаємо
                wrapper.style.maxHeight = '160px';
                if (overlay) overlay.style.opacity = '1';
                this.textContent = 'Read More';
                
                // Скролимо до початку блоку, щоб контент не "стрибнув" з-під очей
                block.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });
    });
}