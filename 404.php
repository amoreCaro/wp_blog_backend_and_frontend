<?php
if (!defined('ABSPATH')) exit;

get_header(); // Load the header
?>

<main class="flex flex-col items-center justify-center min-h-screen bg-gray-900 text-white px-6">
    <div class="text-center">
        <h1 class="text-6xl font-bold mb-4">404</h1>
        <p class="text-xl mb-6">The page you are looking for cannot be found</p>
        <a href="<?php echo esc_url(home_url('/')); ?>" 
           class="inline-block px-6 py-3 bg-purple-600 hover:bg-purple-500 rounded-lg transition-colors">
           Go Back Home
        </a>
    </div>
</main>

<?php get_footer();  ?>
