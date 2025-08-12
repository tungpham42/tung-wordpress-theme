<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class TungTheme_Product_Gallery_Widget extends Widget_Base {
    public function get_name() {
        return 'tungtheme_product_gallery';
    }
    public function get_title() {
        return 'Dummy Products Gallery';
    }
    public function get_icon() {
        return 'eicon-products';
    }
    public function get_categories() {
        return ['general'];
    }
    public function fetch_products() {
        $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
        $args = [
            'post_type'      => 'product',
            'posts_per_page' => -1,
        ];

        if ($category) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => $category,
                ]
            ];
        }

        $query = new WP_Query($args);
        $products = [];

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $category_terms = wp_get_post_terms(get_the_ID(), 'product_cat');
                $category_name = $category_terms ? $category_terms[0]->name : '';

                $products[] = [
                    'title'     => get_the_title(),
                    'thumbnail' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                    'price'     => get_post_meta(get_the_ID(), 'price', true),
                    'category'  => $category_name,
                    // 🔹 Add this line
                    'permalink' => get_permalink(),
                ];
            }
            wp_reset_postdata();
        }

        wp_send_json_success([
            'products' => $products
        ]);
    }
    protected function register_controls() {
        $this->start_controls_section('content_section', [
            'label' => __('Settings', 'tungtheme'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);
        $this->add_control('items_per_row', [
            'label' => __('Items per Row', 'tungtheme'),
            'type' => Controls_Manager::NUMBER,
            'default' => 4,
            'min' => 1,
            'max' => 6
        ]);
        $this->end_controls_section();
    }
    protected function render() {
        ?>
        <div class="tungtheme-product-gallery" data-items="<?php echo esc_attr($this->get_settings('items_per_row')); ?>">
            <div class="pg-filter">
                <select id="pg-category">
                    <option value="">All Categories</option>
                    <option value="smartphones">Smartphones</option>
                    <option value="laptops">Laptops</option>
                    <option value="fragrances">Fragrances</option>
                </select>
            </div>
            <div class="pg-grid"></div>
            <div class="pg-loading">Loading...</div>
        </div>
        <?php
    }
}
