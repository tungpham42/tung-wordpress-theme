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

        $this->end_controls_section();

        $this->start_controls_section('style_section', [
            'label' => __('Style Settings', 'tungtheme'),
            'tab'   => Controls_Manager::TAB_STYLE,
        ]);

        // Title Controls
        $this->add_control('title_heading', [
            'label' => __('Title', 'tungtheme'),
            'type' => Controls_Manager::HEADING,
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => __('Title Typography', 'tungtheme'),
                'selector' => '{{WRAPPER}} .pg-item h3',
            ]
        );

        $this->add_control('title_color', [
            'label' => __('Title Color', 'tungtheme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#1e40af',
            'selectors' => [
                '{{WRAPPER}} .pg-item h3' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'title_text_shadow',
                'label' => __('Title Text Shadow', 'tungtheme'),
                'selector' => '{{WRAPPER}} .pg-item h3',
            ]
        );

        // Price Controls
        $this->add_control('price_heading', [
            'label' => __('Price', 'tungtheme'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'label' => __('Price Typography', 'tungtheme'),
                'selector' => '{{WRAPPER}} .pg-item .price',
            ]
        );

        $this->add_control('price_color', [
            'label' => __('Price Color', 'tungtheme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ef4444',
            'selectors' => [
                '{{WRAPPER}} .pg-item .price' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'price_text_shadow',
                'label' => __('Price Text Shadow', 'tungtheme'),
                'selector' => '{{WRAPPER}} .pg-item .price',
            ]
        );

        // Category Controls
        $this->add_control('category_heading', [
            'label' => __('Category', 'tungtheme'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'category_typography',
                'label' => __('Category Typography', 'tungtheme'),
                'selector' => '{{WRAPPER}} .pg-item .category',
            ]
        );

        $this->add_control('category_color', [
            'label' => __('Category Color', 'tungtheme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#1f2937',
            'selectors' => [
                '{{WRAPPER}} .pg-item .category' => 'color: {{VALUE}};',
            ]
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'category_text_shadow',
                'label' => __('Category Text Shadow', 'tungtheme'),
                'selector' => '{{WRAPPER}} .pg-item .category',
            ]
        );

        // Button Controls
        $this->add_control('button_heading', [
            'label' => __('Button', 'tungtheme'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __('Button Typography', 'tungtheme'),
                'selector' => '{{WRAPPER}} .pg-item .btn-view',
            ]
        );

        $this->add_control('button_background_color', [
            'label' => __('Button Background Color', 'tungtheme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#60a5fa',
            'selectors' => [
                '{{WRAPPER}} .pg-item .btn-view' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('button_text_color', [
            'label' => __('Button Text Color', 'tungtheme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .pg-item .btn-view' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'button_text_shadow',
                'label' => __('Button Text Shadow', 'tungtheme'),
                'selector' => '{{WRAPPER}} .pg-item .btn-view',
            ]
        );

        $this->add_control('button_border_style', [
            'label' => __('Button Border Style', 'tungtheme'),
            'type' => Controls_Manager::SELECT,
            'default' => 'none',
            'options' => [
                'none' => __('None', 'tungtheme'),
                'solid' => __('Solid', 'tungtheme'),
                'dashed' => __('Dashed', 'tungtheme'),
                'dotted' => __('Dotted', 'tungtheme'),
            ],
            'selectors' => [
                '{{WRAPPER}} .pg-item .btn-view' => 'border-style: {{VALUE}};',
            ],
        ]);

        $this->add_control('button_border_width', [
            'label' => __('Button Border Width', 'tungtheme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 1,
            ],
            'selectors' => [
                '{{WRAPPER}} .pg-item .btn-view' => 'border-width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'button_border_style!' => 'none',
            ],
        ]);

        $this->add_control('button_border_color', [
            'label' => __('Button Border Color', 'tungtheme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#1e40af',
            'selectors' => [
                '{{WRAPPER}} .pg-item .btn-view' => 'border-color: {{VALUE}};',
            ],
            'condition' => [
                'button_border_style!' => 'none',
            ],
        ]);

        $this->add_control('button_border_radius', [
            'label' => __('Button Border Radius', 'tungtheme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 4,
            ],
            'selectors' => [
                '{{WRAPPER}} .pg-item .btn-view' => 'border-radius: {{SIZE}}{{UNIT}};',
            ],
        ]);

        // Button Hover Controls
        $this->add_control('button_hover_heading', [
            'label' => __('Button Hover', 'tungtheme'),
            'type' => Controls_Manager::HEADING,
            'separator' => 'before',
        ]);

        $this->add_control('button_background_color_hover', [
            'label' => __('Button Hover Background Color', 'tungtheme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#facc15',
            'selectors' => [
                '{{WRAPPER}} .pg-item .btn-view:hover' => 'background-color: {{VALUE}};',
            ],
        ]);

        $this->add_control('button_text_color_hover', [
            'label' => __('Button Hover Text Color', 'tungtheme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#1e40af',
            'selectors' => [
                '{{WRAPPER}} .pg-item .btn-view:hover' => 'color: {{VALUE}};',
            ],
        ]);

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'button_text_shadow_hover',
                'label' => __('Button Hover Text Shadow', 'tungtheme'),
                'selector' => '{{WRAPPER}} .pg-item .btn-view:hover',
            ]
        );

        $this->add_control('button_border_color_hover', [
            'label' => __('Button Hover Border Color', 'tungtheme'),
            'type' => Controls_Manager::COLOR,
            'default' => '#1e40af',
            'selectors' => [
                '{{WRAPPER}} .pg-item .btn-view:hover' => 'border-color: {{VALUE}};',
            ],
            'condition' => [
                'button_border_style!' => 'none',
            ],
        ]);

        $this->add_control('button_border_radius_hover', [
            'label' => __('Button Hover Border Radius', 'tungtheme'),
            'type' => Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 4,
            ],
            'selectors' => [
                '{{WRAPPER}} .pg-item .btn-view:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
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