<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;

if ( ! defined( 'ABSPATH' ) ) exit;

class TungTheme_Product_Gallery_Widget extends Widget_Base {
    public function get_name() {
        return 'tungtheme_product_gallery';
    }

    public function get_title() {
        return 'Tung\'s Product Gallery';
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
            'label' => __('Gallery Settings', 'tungtheme'),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ]);

        $this->add_control('items_per_row', [
            'label' => __('Items per Row', 'tungtheme'),
            'type' => Controls_Manager::NUMBER,
            'default' => 4,
            'min' => 1,
            'max' => 6,
            'description' => __('Set the number of items per row in the gallery.', 'tungtheme'),
        ]);

        $this->add_control('title_font_size', [
            'label' => __('Title Font Size', 'tungtheme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 12,
                    'max' => 30,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 18,
            ],
            'selectors' => [
                '{{WRAPPER}} .pg-item h3' => 'font-size: {{SIZE}}{{UNIT}};',
            ],
        ]);

        $this->add_control('price_color', [
            'label' => __('Price Color', 'tungtheme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#e67e22',
            'selectors' => [
                '{{WRAPPER}} .price' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_control('button_bg_color', [
            'label' => __('Button Background Color', 'tungtheme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#3498db',
            'selectors' => [
                '{{WRAPPER}} .pg-item a' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
        <div class="tungtheme-product-gallery" data-items="<?php echo esc_attr($settings['items_per_row']); ?>">
            <div class="pg-filter">
                <select id="pg-category" class="pg-select">
                    <option value="">All Categories</option>
                </select>
                <select id="pg-sort" class="pg-select">
                    <option value="">Sort By</option>
                    <option value="title_asc">Title A–Z</option>
                    <option value="title_desc">Title Z–A</option>
                    <option value="price_asc">Price Low → High</option>
                    <option value="price_desc">Price High → Low</option>
                </select>
            </div>
            <div class="pg-loading">Loading Products...</div>
            <div class="pg-grid"></div>
        </div>
        <?php
    }
}