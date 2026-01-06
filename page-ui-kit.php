<?php
/**
 * Template Name: UI Kit
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header(); 
?>

<main class="px-6 py-12 mx-auto font-sans text-content-white bg-black min-h-screen space-y-16">
    <div class="max-w-[1380px] mx-auto space-y-12">
        <?php require get_template_directory() . '/app/components/ui/colors.php'; ?>

        <section class="p-10 font-sans">
            <div class="flex items-center gap-4 mb-10 group">
                <div class="w-[3px] h-6 bg-brand-indigo rounded-full"></div>
                <h2 class="text-content-muted font-medium text-[22px] tracking-tight group-hover:text-content-white transition-colors">
                    Typography
                </h2>
            </div>

            <div class="bg-surface-dark border border-border-light rounded-[24px] p-10 relative flex flex-col gap-14">
                <div class="flex flex-col gap-6">
                    <h3 class="text-content-ghost text-[11px] font-bold uppercase tracking-[0.3em] ml-1">Headings</h3>
                    
                    <div class="flex flex-col gap-2">
                        <div class="group flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-200 hover:bg-surface-hover border border-transparent hover:border-border-hover cursor-default">
                            <h1 class="text-[56px] leading-[64px] font-medium text-content-white">Heading 1</h1>
                            <span class="text-[11px] font-mono text-content-ghost uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Roboto Medium / 56px</span>
                        </div>

                        <div class="group flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-200 hover:bg-surface-hover border border-transparent hover:border-border-hover cursor-default">
                            <h2 class="text-[48px] leading-[48px] text-content-white">Heading 2</h2>
                            <span class="text-[11px] font-mono text-content-ghost uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Roboto Regular / 48px</span>
                        </div>

                        <div class="group flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-200 hover:bg-surface-hover border border-transparent hover:border-border-hover cursor-default">
                            <h3 class="text-[40px] leading-[48px] font-semibold text-content-white">Heading 3</h3>
                            <span class="text-[11px] font-mono text-content-ghost uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Roboto SemiBold / 40px</span>
                        </div>

                        <div class="group flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-200 hover:bg-surface-hover border border-transparent hover:border-border-hover cursor-default">
                            <h4 class="text-[32px] leading-[40px] font-medium text-content-white">Heading 4</h4>
                            <span class="text-[11px] font-mono text-content-ghost uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Roboto Medium / 32px</span>
                        </div>

                        <div class="group flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-200 hover:bg-surface-hover border border-transparent hover:border-border-hover cursor-default">
                            <h5 class="text-[24px] leading-[32px] font-medium text-content-white">Heading 5</h5>
                            <span class="text-[11px] font-mono text-content-ghost uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Roboto Medium / 24px</span>
                        </div>

                        <div class="group flex items-center justify-between px-6 py-4 rounded-2xl transition-all duration-200 hover:bg-surface-hover border border-transparent hover:border-border-hover cursor-default">
                            <h6 class="text-[20px] leading-[28px] font-normal text-content-white">Heading 6</h6>
                            <span class="text-[11px] font-mono text-content-ghost uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity">Roboto Regular / 20px</span>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-6">
                    <h3 class="text-content-ghost text-[11px] font-bold uppercase tracking-[0.3em] ml-1">Body Text</h3>
                    
                    <div class="flex flex-col gap-2">
                        <div class="group flex items-start justify-between px-6 py-4 rounded-2xl transition-all duration-200 hover:bg-surface-hover border border-transparent hover:border-border-hover cursor-default">
                            <p class="text-[18px] leading-[36px] text-content-gray font-light max-w-xl">
                                This is a standard paragraph using variables. It is highly readable and consistent across all pages.
                            </p>
                            <span class="text-[11px] font-mono text-content-ghost uppercase tracking-widest opacity-0 group-hover:opacity-100 transition-opacity shrink-0">Roboto Light / 18px</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

<?php get_footer(); ?>