<!DOCTYPE html>
<html>
<head>
    <meta>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<header class="bg-black px-6 py-4 text-white">
  <div class="flex items-center justify-between max-w-[1140px] w-full mx-auto">
    <!-- Логотип -->
    <h2 class="text-xl font-semibold tracking-tight cursor-pointer">
      Travel Guider
    </h2>

    <!-- Навігація -->
    <nav class="hidden flex-1 justify-center space-x-3 md:flex">
      <a href="#" class="flex items-center gap-2 rounded-full border border-gray-600 px-4 py-1.5 text-xs font-medium transition hover:bg-white hover:text-black">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 20l-5.447-2.724A2 2 0 013 15.488V5.512a2 2 0 011.553-1.944L9 2l6 3 5.447-2.724A2 2 0 0121 4.224v9.976a2 2 0 01-1.553 1.944L15 19l-6-3z" />
        </svg>
        Where to Go
      </a>
      <a href="#" class="flex items-center gap-2 rounded-full border border-gray-600 px-4 py-1.5 text-xs font-medium transition hover:bg-white hover:text-black">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
        </svg>
        Where to Eat
      </a>
      <a href="#" class="flex items-center gap-2 rounded-full border border-gray-600 px-4 py-1.5 text-xs font-medium transition hover:bg-white hover:text-black">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        Places to Stay
      </a>
      <a href="#" class="flex items-center gap-2 rounded-full border border-gray-600 px-4 py-1.5 text-xs font-medium transition hover:bg-white hover:text-black">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        What to Do
      </a>
    </nav>

    <!-- Дії -->
    <div class="flex items-center space-x-6 text-sm">
      <a href="#" class="hover:underline">Subscribe</a>
      <a href="#" class="hover:underline">Contact</a>
      <button class="p-1 hover:text-gray-400">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </button>
    </div>
  </div>
</header>

<body <?php body_class(); ?>>