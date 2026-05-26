<?php

if (!defined('ABSPATH')) exit;
?>

<video class="post-card__video w-full h-full object-cover" loop muted loading="lazy">
    <source
        src="https://player.vimeo.com/external/139533374.mobile.mp4?s=4aa63626972ccc3d5f8a1dc2b49e6ed7&profile_id=116"
        type="video/mp4"
    />
</video>
<div class="absolute inset-0 pointer-events-none">

    <!-- loading -->
    <div class="post-card__loading hidden absolute inset-0 z-20 flex items-center justify-center">
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>

    <!-- play icon -->
    <div class="post-card__video-icon absolute inset-0 z-10 flex items-center justify-center">
        <span class="bg-black/60 flex items-center justify-center rounded-full border border-white text-white w-11 h-11">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none">
                <path d="M17.13 7.9799C20.96 10.1899 20.96 13.8099 17.13 16.0199L14.04 17.7999L10.95 19.5799C7.13 21.7899 4 19.9799 4 15.5599V11.9999V8.43989C4 4.01989 7.13 2.2099 10.96 4.4199L13.21 5.7199"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"/>
            </svg>
        </span>
    </div>

</div>