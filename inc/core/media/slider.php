<?php

if (!defined('ABSPATH')) exit;
?>
<div class="swiper modal-cart__slider overflow-hidden">

    <div class="swiper-wrapper">

        <div class="swiper-slide">
        <img src="https://picsum.photos/800/500?1" class="w-full h-full object-cover" />
        </div>

        <div class="swiper-slide">
        <img src="https://picsum.photos/800/500?2" class="w-full h-full object-cover" />
        </div>

        <div class="swiper-slide">
        <img src="https://picsum.photos/800/500?3" class="w-full h-full object-cover" />
        </div>

        <div class="swiper-slide">
        <img src="https://picsum.photos/800/500?4" class="w-full h-full object-cover" />
        </div>

    </div>

    <button type="button" class="modal-cart__prev absolute left-4 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white/90 text-gray-600 flex items-center justify-center shadow-md transition-all duration-300 ease-out hover:scale-110 hover:bg-white hover:text-gray-900 hover:shadow-lg active:scale-95 opacity-0 group-hover:opacity-100 focus:outline-none cursor-default">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 truths rtl:rotate-180">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"></path>
        </svg>
    </button>

    <button type="button" class="modal-cart__next absolute right-4 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white/90 text-gray-600 flex items-center justify-center shadow-md transition-all duration-300 ease-out hover:scale-110 hover:bg-white hover:text-gray-900 hover:shadow-lg active:scale-95 opacity-0 group-hover:opacity-100 focus:outline-none cursor-default">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 rlt:rotate-180">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
    </button>

    <div class="modal-cart__pagination swiper-pagination absolute bottom-3 left-1/2 -translate-x-1/2 z-10 flex justify-center"></div>

</div>