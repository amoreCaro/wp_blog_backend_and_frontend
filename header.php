<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="header-default bg-black px-6 py-4 text-white">
	<div class="flex items-center justify-between max-w-[1140px] w-full mx-auto">
		<!-- Логотип -->
		<a class="text-xl font-semibold tracking-tight cursor-pointer">
			Travel Guider
		</a>
		<!-- Навігація -->
		<nav class="hidden flex-1 justify-center md:flex">
			<ul class="flex space-x-3">
				<li>
					<a href="#" class="flex items-center gap-2 rounded-full border px-4 py-1.5 text-xs font-medium hover:bg-white hover:text-black">
					<!-- SVG -->
					Where to Go
					</a>
				</li>
				<li>
					<a href="#" class="flex items-center gap-2 rounded-full border px-4 py-1.5 text-xs font-medium hover:bg-white hover:text-black">
						<!-- SVG -->
						Where to Eat
					</a>
				</li>
				<li>
					<a href="#" class="flex items-center gap-2 rounded-full border px-4 py-1.5 text-xs font-medium hover:bg-white hover:text-black">
						<!-- SVG -->
						Places to Stay
					</a>
				</li>	
				<li>
					<a href="#" class="flex items-center gap-2 rounded-full border px-4 py-1.5 text-xs font-medium hover:bg-white hover:text-black">
						<!-- SVG -->
						What to Do
					</a>
				</li>
			</ul>
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