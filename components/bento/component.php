<?php
if (!defined('ABSPATH')) exit;

$placeholder = get_template_directory_uri() . '/assets/src/images/placeholder.png';
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$button_text = get_field("acf_bento_button");

$all_sections = [];

/* FRONT PAGE */
if (is_front_page()) {
	$front_page_id = get_option('page_on_front');
	$selected_category = get_field('acf_select_category', $front_page_id);
	$category = is_int($selected_category) ? get_category($selected_category) : $selected_category;
	if ($category) {
		$posts = theme_get_posts([
			'cat' => $category->term_id,
			'posts_per_page' => 6
		]);
		$section = theme_build_section($category, $posts);
		if ($section) $all_sections[] = $section;
	}
}

/* BLOG PAGE */
elseif (is_page('blog')) {
	$categories = get_categories([
		'orderby' => 'name',
		'order' => 'ASC',
		'hide_empty' => true
	]);
	foreach ($categories as $category) {
		$posts = theme_get_posts([
			'cat' => $category->term_id,
			'posts_per_page' => 6
		]);
		$section = theme_build_section($category, $posts);
		if ($section) $all_sections[] = $section;
	}
}

/* CATEGORY PAGE */
elseif (is_category()) {
	$category = get_queried_object();
	$posts = theme_get_posts([
		'cat' => $category->term_id,
		'posts_per_page' => 12,
		'paged' => $paged
	]);
	$section = theme_build_section($category, $posts);
	if ($section) $all_sections[] = $section;
}

/* TAG PAGE */

/* RENDER */
if (!empty($all_sections)) :
?>
<section class="bento-grid bg-[#F6F5F8] mx-auto lg:pt-[120px] pt-[120px] lg:pb-[100px] pb-[50px] px-5 xl:px-10 2xl:px-0">
	<?php foreach ($all_sections as $section):
		$posts = $section['posts'];
		$category_name = esc_html($section['category_name'] ?? '');
		$category_bg_color = esc_attr($section['category_bg_color'] ?? '');
		$cat_icon = $section['cat_icon'] ?? '';
		$is_tag = $section['is_tag'] ?? false;
		$chunks = array_chunk($posts, 6);
	?>
	<div class="flex items-center mb-12 justify-between container [&:not(:first-child)]:mt-[100px]">
		<div class="flex items-center gap-4">
			<?php if ($category_name): ?>
				<h1 class="text-black text-[32px] md:text-[40px] lg:text-[48px] xl:text-[56px] font-semibold tracking-tight leading-tight first-letter:uppercase">
					<?php echo $category_name; ?>
				</h1>
			<?php endif; ?>
			<?php if ($category_bg_color && $cat_icon): ?>
				<div class="decor -translate-y-1/2 w-14 h-14  flex items-center justify-center rounded-t-full rounded-br-full shadow-sm p-[12px]"
					style="background-color: <?php echo esc_attr($category_bg_color); ?>">

								<?php
								$file_id = get_term_meta($category->term_id, 'acf_category_icon', true);

								if ($file_id) {
									$file_path = get_attached_file($file_id);

									if ($file_path && file_exists($file_path)) {
										$svg_content = file_get_contents($file_path);
										
										// Додаємо клас для розміру
										$svg_content = str_replace('<svg', '<svg', $svg_content);

										// Змінюємо всі fill на currentColor
										$svg_content = preg_replace('/fill="[^"]*"/i', 'fill="currentColor"', $svg_content);

										echo $svg_content;
									}
								}
								?>

				</div>
			<?php endif; ?>
		</div>
		<?php if (is_page("blog")): ?>
			<a href="<?php echo esc_url($section['category_link']); ?>" class="group flex items-center justify-center gap-1.5 text-xs px-4 py-2 md:text-base md:px-9 md:py-3 md:gap-2 text-black border-2 border-black font-semibold rounded-full transition-all duration-300 hover:bg-black hover:text-white w-fit">
				<?php echo esc_html($button_text); ?>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="w-3.5 h-3.5 md:w-5 md:h-5 transition-transform duration-300 group-hover:translate-x-1.5">
					<path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3"></path>
				</svg>
			</a>
		<?php endif; ?>
	</div>

	<div class="space-y-12 container">
		<?php foreach ($chunks as $chunk): ?>
			<div class="<?php if (is_front_page()) echo 'reverse'; ?> grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-10">
				<?php foreach ($chunk as $index => $post): setup_postdata($post);
					$post_image = get_the_post_thumbnail_url($post->ID) ?: $placeholder;
				?>
				<?php if ($index === 0): ?>
					<!-- SMALL CARD -->
					<a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="group flex flex-col bg-white rounded-[24px] shadow-sm overflow-hidden min-h-[450px]">
						<div class="h-[200px] md:h-[285px] overflow-hidden">
							<img src="<?php echo esc_url($post_image); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
						</div>
						<div class="p-6 md:p-8 flex flex-col flex-grow">
							<span class="flex items-center gap-2 text-[14px] font-medium px-5 py-1 rounded-full w-fit mb-4"
							<?php if($category_bg_color) echo 'style="background-color: '.$category_bg_color.';"'; ?>>

								<?php
								$file_id = get_term_meta($category->term_id, 'acf_category_icon', true);

								if ($file_id) {
									$file_path = get_attached_file($file_id);

									if ($file_path && file_exists($file_path)) {
										$svg_content = file_get_contents($file_path);
										
										// Додаємо клас для розміру
										$svg_content = str_replace('<svg', '<svg class="w-4 h-4"', $svg_content);

										// Змінюємо всі fill на currentColor
										$svg_content = preg_replace('/fill="[^"]*"/i', 'fill="currentColor"', $svg_content);

										echo $svg_content;
									}
								}
								?>

							<?php echo $is_tag ? esc_html($section['first_category_name']) : $category_name; ?>

							</span>
							<h4 class="text-black text-lg md:text-2xl font-semibold mb-3"><?php echo esc_html(get_the_title($post->ID)); ?></h4>
							<p class="text-[#373A39] text-sm lg:text-lg mb-4 line-clamp-3"><?php echo esc_html(wp_trim_words(get_the_excerpt($post->ID),25)); ?></p>
							<time class="text-black text-xs font-bold mt-auto"><?php echo esc_html(get_the_date('', $post->ID)); ?></time>
						</div>
					</a>
				<?php elseif ($index === 1): ?>
					<!-- BIG CARD -->
					<a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="group lg:col-span-3 bg-neutral-950 rounded-[24px] md:rounded-[32px] overflow-hidden flex flex-col lg:flex-row min-h-[680px]">
						<div class="lg:w-[55%] h-[300px] sm:h-[400px] lg:h-auto overflow-hidden relative">
							<img src="<?php echo esc_url($post_image); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
							<div class="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-black/80 to-transparent"></div>
						</div>
						<div class="lg:w-[45%] p-8 md:p-12 flex flex-col text-white">
							<span class="border border-white/40 flex items-center gap-2 text-[14px] font-medium px-5 py-1 rounded-full w-fit mb-6">

								<?php
								$file_id = get_term_meta($category->term_id, 'acf_category_icon', true);

								if ($file_id) {
									$file_path = get_attached_file($file_id);

									if ($file_path && file_exists($file_path)) {
										$svg_content = file_get_contents($file_path);
										
										// Додаємо клас для розміру
										$svg_content = str_replace('<svg', '<svg class="w-4 h-4"', $svg_content);

										// Змінюємо всі fill на currentColor
										$svg_content = preg_replace('/fill="[^"]*"/i', 'fill="currentColor"', $svg_content);

										echo $svg_content;
									}
								}
								?>

								<?php echo $is_tag ? esc_html($section['first_category_name']) : $category_name; ?>

							</span>
							<h4 class="text-2xl md:text-4xl lg:text-5xl font-medium mb-6"><?php echo esc_html(get_the_title($post->ID)); ?></h4>
							<p class="text-[#C4C4C4] text-base md:text-lg mb-10"><?php echo esc_html(wp_trim_words(get_the_excerpt($post->ID),35)); ?></p>
							<time class="text-gray-400 text-sm font-bold mt-auto"><?php echo esc_html(get_the_date('', $post->ID)); ?></time>
						</div>
					</a>
				<?php else: ?>
					<!-- REGULAR CARD -->
					<a href="<?php echo esc_url(get_permalink($post->ID)); ?>" class="group flex flex-col bg-white rounded-[24px] shadow-sm overflow-hidden min-h-[450px]">
						<div class="h-[200px] md:h-[285px] overflow-hidden">
							<img src="<?php echo esc_url($post_image); ?>" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="<?php echo esc_attr(get_the_title($post->ID)); ?>">
						</div>
						<div class="p-6 md:p-8 flex flex-col flex-grow">
							<span class="flex items-center gap-2 text-[14px] font-medium px-5 py-1 rounded-full w-fit mb-4" <?php if(!$is_tag && $category_bg_color) echo 'style="background-color: '.$category_bg_color.';"'; ?>>
								<?php
								$file_id = get_term_meta($category->term_id, 'acf_category_icon', true);

								if ($file_id) {
									$file_path = get_attached_file($file_id);

									if ($file_path && file_exists($file_path)) {
										$svg_content = file_get_contents($file_path);
										
										// Додаємо клас для розміру
										$svg_content = str_replace('<svg', '<svg class="w-4 h-4"', $svg_content);

										// Змінюємо всі fill на currentColor
										$svg_content = preg_replace('/fill="[^"]*"/i', 'fill="currentColor"', $svg_content);

										echo $svg_content;
									}
								}
								?>

							<?php echo $is_tag ? esc_html($section['first_category_name']) : $category_name; ?>
							</span>
							<h4 class="text-black text-lg md:text-2xl font-semibold mb-3"><?php echo esc_html(get_the_title($post->ID)); ?></h4>
							<p class="text-[#373A39] text-sm lg:text-lg mb-4 line-clamp-3"><?php echo esc_html(wp_trim_words(get_the_excerpt($post->ID),25)); ?></p>
							<time class="text-black text-xs font-bold mt-auto"><?php echo esc_html(get_the_date('', $post->ID)); ?></time>
						</div>
					</a>
				<?php endif; ?>
				<?php endforeach; wp_reset_postdata(); ?>
			</div>
		<?php endforeach; ?>
	</div>
	<?php endforeach; ?>
</section>
<?php endif; ?>