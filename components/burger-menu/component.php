<?php
if (!defined('ABSPATH')) {
    exit;
}

$socials = get_field("acf_social_icons", "option");
?>

<div id="burgerMenu" class="fixed inset-0 z-[1000] flex items-center justify-center opacity-0 pointer-events-none -translate-x-full transition-all duration-300 ease-out">

    <div id="burgerOverlay" class="absolute inset-0 bg-zinc-950/90 backdrop-blur-2xl"></div>

    <button id="closeBurger" class="absolute top-4 right-4 sm:top-4 sm:right-5 z-50 p-2 sm:p-3 text-zinc-400 hover:text-white hover:bg-white/10 rounded-full transition">
        <svg class="h-6 w-6 sm:h-8 sm:w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>

    <div class="relative z-10 w-full h-full flex flex-col justify-between items-center px-4 sm:px-5 py-8">

        <div class="flex flex-col items-center flex-1 justify-center w-full">
            <div class="relative w-full group mb-10 w-full max-w-md md:max-w-xl lg:max-w-2xl ">
                <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none text-zinc-400 group-focus-within:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    placeholder="Search for adventures..." 
                    class="w-full bg-white/5 border border-white/20 rounded-full py-4 pl-14 pr-6 text-white text-lg placeholder:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-white/30 focus:bg-white/10 transition-all duration-300"
                >
            </div>
            <nav class="w-full max-w-md md:max-w-xl lg:max-w-2xl flex flex-col gap-6 sm:gap-8">
                <ul class="flex flex-col gap-3 sm:gap-4 w-full">
                    <li class="list-none">
                        <a href="#where-to-go" class="group w-full flex items-center justify-between p-4 sm:p-5 rounded-full border border-white/20 text-white hover:bg-white hover:text-black transition-all duration-300">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1-.553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/>
                                </svg>
                                <span class="text-lg sm:text-xl font-medium">Where to Go</span>
                            </div>
                        </a>
                    </li>

                    <li class="list-none">
                        <a href="#what-to-eat" class="group w-full flex items-center justify-between p-4 sm:p-5 rounded-full border border-white/20 text-white hover:bg-white hover:text-black transition-all duration-300">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m16 2 2 2-4 4 4 4-2 2-6-6-2 2-4-4-2 2-2-2 4-4 2-2 2 2 6 6Z"/><path d="m2 22 10-10"/><path d="m22 2-5 5"/>
                                </svg>
                                <span class="text-lg sm:text-xl font-medium">Where to Eat</span>
                            </div>
                        </a>
                    </li>

                    <li class="list-none">
                        <a href="#places-to-stay" class="group w-full flex items-center justify-between p-4 sm:p-5 rounded-full border border-white/20 text-white hover:bg-white hover:text-black transition-all duration-300">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/>
                                </svg>
                                <span class="text-lg sm:text-xl font-medium">Places to Stay</span>
                            </div>
                        </a>
                    </li>

                    <li class="list-none">
                        <a href="#" class="group w-full flex items-center justify-between p-4 sm:p-5 rounded-full border border-white/20 text-white hover:bg-white hover:text-black transition-all duration-300">
                            <div class="flex items-center gap-3 sm:gap-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="8"/><path d="m12 10 2 4h-4l2-4Z"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
                                </svg>
                                <span class="text-lg sm:text-xl font-medium">What to Do</span>
                            </div>  
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        
        <?php if ( ! empty( $socials ) ) : ?>
            <div class="w-full border-t border-white/10 my-8"></div>
            
            <?php
            // Socials
            require PATH . '/components/socials/component.php';
            ?>
        </div>
    <?php endif; ?>
</div>