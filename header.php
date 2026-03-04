<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open();

$logo = get_field ( "acf_header_logo", "option" );
$buttons = get_field("acf_header_buttons", "option");

$nav_menu = get_nav_menu_locations();
$menu_items = [];


if (isset($nav_menu['header_menu'])) {
    $menu_id = $nav_menu['header_menu'];
    $menu_items = wp_get_nav_menu_items($menu_id);
}



?>
<div class="l-wrapper">
    <header class="header-default fixed top-0 left-0 z-[100] w-full bg-black px-5 xl:px-10 h-[80px] flex items-center text-white">
        <div class="container flex items-center justify-between">
            <?php 
            if ( ! empty( $logo ) ) :
                $logo_text   = $logo['acf_header_logo_txt'] ?? '';
                $logo_img_id = $logo['acf_header_logo_img'] ?? '';
            ?>
                <a href="#logo" class="flex items-center flex-shrink-0 no-underline text-white transition-opacity">
                    <?php 
                    if ( ! empty( $logo_img_id ) ) {
                        // 🔹 Логотип-картинка з max-width
                        echo wp_get_attachment_image(
                            $logo_img_id,
                            'full',
                            false,
                            [
                                'alt'   => esc_attr( $logo_text ),
                                'class' => 'w-full max-w-[130px] h-10 object-contain'
                            ]
                        );
                    } elseif ( ! empty( $logo_text ) ) {
                        // 🔹 Текстовий логотип без обмежень
                        echo '<span class="text-xl font-semibold tracking-tight">'
                            . esc_html( $logo_text ) .
                        '</span>';
                    }
                    ?>
                </a>
            <?php endif; ?>
            <?php if (!empty($menu_items)) : ?>
            <nav class="navigation hidden flex-1 justify-center lg:flex">
                <ul class="flex space-x-3">
                        <?php foreach ($menu_items as $item) : 
                            $icon_svg = get_inline_svg_from_acf($item->ID);
                            $is_active = in_array('current-menu-item', $item->classes, true);
                        ?>
                            <li class="list-none">
                                <a
                                    href="<?= esc_url($item->url); ?>"
                                    class="group flex items-center gap-2 rounded-full border border-white/40 px-4 py-1.5 text-white transition-all hover:bg-white hover:text-black <?= $is_active ? 'bg-white text-black' : ''; ?> "
                                >
                                    <?php if ($icon_svg) : ?>
                                        <span class="menu-icon">
                                            <?= $icon_svg; ?>
                                        </span>
                                    <?php endif; ?>

                                    <span class="menu-text">
                                        <?= esc_html($item->title); ?>
                                    </span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <?php endif; ?>

            <div class="flex items-center gap-4 md:gap-6 text-sm flex-shrink-0">
            <?php if ( ! empty( $buttons ) ) : ?>
                <div class="hidden lg:flex items-center gap-6">
                    <?php foreach ( $buttons as $button ) : 
                        $button_text = $button['acf_header_button_text'] ?? '';
                        $button_link = $button['acf_header_button_link'] ?? '#';
                    ?>
                        <a 
                            href="<?php echo esc_url( $button_link ); ?>" 
                            class="transition-colors hover:text-blue-400"
                        >
                            <?php echo esc_html( $button_text ); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

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