<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="l-wrapper">
    <header class="header-default fixed top-0 left-0 z-[100] w-full bg-black px-5 xl:px-10 h-[80px] flex items-center text-white">
        <div class="container flex items-center justify-between">
            
            <a class="text-xl font-semibold tracking-tight text-white transition-opacity no-underline flex-shrink-0" href="#logo">
                Travel Guider
            </a>
            <nav class="navigation	 hidden flex-1 justify-center lg:flex">
                <ul class="flex space-x-3">
                    
                    <li class="list-none">
                        <a href="#" class="flex items-center gap-2 rounded-full border border-white/40 px-4 py-1.5 text-white hover:bg-white hover:text-black transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1-.553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/>
                            </svg>
                            <span class="text-xs font-medium leading-[16px]">Where to Go</span>
                        </a>
                    </li>

                    <li class="list-none">
                        <a href="#" class="flex items-center gap-2 rounded-full border border-white/40 px-4 py-1.5 text-white hover:bg-white hover:text-black transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m16 2 2 2-4 4 4 4-2 2-6-6-2 2-4-4-2 2-2-2 4-4 2-2 2 2 6 6Z"/><path d="m2 22 10-10"/><path d="m22 2-5 5"/>
                            </svg>
                            <span class="text-xs font-medium leading-[16px]">Where to Eat</span>
                        </a>
                    </li>

                    <li class="list-none">
                        <a href="#" class="flex items-center gap-2 rounded-full border border-white/40 px-4 py-1.5 text-white hover:bg-white hover:text-black transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 4v16"/><path d="M2 8h18a2 2 0 0 1 2 2v10"/><path d="M2 17h20"/><path d="M6 8v9"/>
                            </svg>
                            <span class="text-xs font-medium leading-[16px]">Places to Stay</span>
                        </a>
                    </li>

                    <li class="list-none">
                        <a href="#" class="flex items-center gap-2 rounded-full border border-white/40 px-4 py-1.5 text-white hover:bg-white hover:text-black transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="8"/><path d="m12 10 2 4h-4l2-4Z"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/>
                            </svg>
                            <span class="text-xs font-medium leading-[16px]">What to Do</span>
                        </a>
                    </li>

                </ul>
            </nav>

            <div class="flex items-center gap-4 md:gap-6 text-sm flex-shrink-0">
                <div class="hidden lg:flex items-center gap-6">
                    <a href="#" class="transition-colors hover:text-blue-400">Login</a>
                    <a href="#" class="transition-colors hover:text-blue-400">Contact</a>
                </div>

                <label for="theme-toggle" class="inline-flex items-center group relative cursor-pointer">
                    <input type="checkbox" id="theme-toggle" class="sr-only peer">
                    
                    <div class="w-16 h-9 bg-slate-200 rounded-full transition-all duration-500 
                                peer-checked:bg-slate-800 group-hover:bg-slate-300">
                    </div>
                    
                    <div class="absolute left-1 top-1 w-7 h-7 bg-white rounded-full shadow-md flex items-center justify-center transition-all duration-500 
                                peer-checked:translate-x-7 
                                peer-active:scale-95"> <svg class="w-4 h-4 text-amber-500 transition-all duration-500 
                                    peer-checked:opacity-0 peer-checked:rotate-90 peer-checked:scale-0" 
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" />
                        </svg>

                        <svg class="absolute w-4 h-4 text-indigo-600 transition-all duration-500 
                                    opacity-0 -rotate-90 scale-0 
                                    peer-checked:opacity-100 peer-checked:rotate-0 peer-checked:scale-100" 
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </div>
                </label>
                <button id="openBurgerBtn" class="w-[24px] h-[24px] lg:hidden hover:text-blue-400 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-full h-full">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>