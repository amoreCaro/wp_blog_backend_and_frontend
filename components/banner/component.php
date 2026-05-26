<?php 

if ( ! defined( 'ABSPATH' ) ) {
 exit;
}

?>
<div class="container mx-auto px-4 md:px-8 py-16 bg-[#F1F3F5] lg:min-h-[650px] h-full flex flex-col-reverse lg:flex-row items-center justify-between gap-12 rounded-none md:rounded-[40px]">

    <div class="w-full lg:basis-[46%] text-left order-2 lg:order-1">
        <span class="text-[12px] leading-[16px] uppercase tracking-widest font-medium text-neutral-400 block mb-3">
            SUPPER CHANGE YOUR PLANNING POWERS
        </span>

        <h3 class="font-semibold text-[#111827] text-3xl sm:text-4xl lg:text-[36px] lg:leading-[40px]">
            Become an author and share your great stories
        </h3>

        <p class="block mt-4 md:mt-6 text-base text-neutral-500 leading-[24px]">
            Become an author you can earn extra income by writing articles. Read and share new perspectives on just about any topic. Everyone’s welcome.
        </p>

        <a href="#" class="inline-flex items-center justify-center rounded-2xl bg-[#493FCC] hover:bg-[#3730A3] active:bg-[#312E81]
            text-[#eef2ff] text-sm md:text-base font-medium py-3.5 px-6 md:py-[14px] md:px-[24px] mt-6 md:mt-8 transition-all duration-200 shadow-sm cursor-pointer select-none">
            <span>Become an author</span>
        </a>
    </div>

    <div class="w-full lg:basis-[64%] flex justify-center lg:justify-end order-1 lg:order-2">
        <figure class="w-full">
            <img class="w-full h-auto object-contain" src="<?php echo esc_url($image); ?>" alt="Become an author illustration">
        </figure>
    </div>

</div>