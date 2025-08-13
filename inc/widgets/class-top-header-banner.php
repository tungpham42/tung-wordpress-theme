<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Top_Header_Banner_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'top_header_banner';
    }

    public function get_title() {
        return __( 'Top Header Banner', 'tungtheme' );
    }

    public function get_icon() {
        return 'eicon-banner';
    }

    public function get_categories() {
        return [ 'theme-widgets' ];
    }

    protected function register_controls() {

        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'tungtheme' ),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => __( 'Heading', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Your Main Headline', 'tungtheme' ),
            ]
        );

        $this->add_control(
            'subheading',
            [
                'label' => __( 'Subheading', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Your description goes here.', 'tungtheme' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Shop Now', 'tungtheme' ),
            ]
        );

        $this->add_control(
            'button_url',
            [
                'label' => __( 'Button URL', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::URL,
                'default' => [ 'url' => '#' ],
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => __( 'Style', 'tungtheme' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Background Controls
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'background',
                'label' => __( 'Background', 'tungtheme' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .top-header-banner',
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __( 'Background Image', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner' => 'background-image: url({{URL}});',
                ],
            ]
        );

        $this->add_control(
            'background_position',
            [
                'label' => __( 'Background Position', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center center',
                'options' => [
                    'top left' => __( 'Top Left', 'tungtheme' ),
                    'top center' => __( 'Top Center', 'tungtheme' ),
                    'top right' => __( 'Top Right', 'tungtheme' ),
                    'center left' => __( 'Center Left', 'tungtheme' ),
                    'center center' => __( 'Center Center', 'tungtheme' ),
                    'center right' => __( 'Center Right', 'tungtheme' ),
                    'bottom left' => __( 'Bottom Left', 'tungtheme' ),
                    'bottom center' => __( 'Bottom Center', 'tungtheme' ),
                    'bottom right' => __( 'Bottom Right', 'tungtheme' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner' => 'background-position: {{VALUE}};',
                ],
                'condition' => [
                    'background_image[url]!' => '',
                ],
            ]
        );

        $this->add_control(
            'background_size',
            [
                'label' => __( 'Background Size', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'auto' => __( 'Auto', 'tungtheme' ),
                    'cover' => __( 'Cover', 'tungtheme' ),
                    'contain' => __( 'Contain', 'tungtheme' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner' => 'background-size: {{VALUE}};',
                ],
                'condition' => [
                    'background_image[url]!' => '',
                ],
            ]
        );

        $this->add_control(
            'background_repeat',
            [
                'label' => __( 'Background Repeat', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'no-repeat',
                'options' => [
                    'no-repeat' => __( 'No Repeat', 'tungtheme' ),
                    'repeat' => __( 'Repeat', 'tungtheme' ),
                    'repeat-x' => __( 'Repeat-X', 'tungtheme' ),
                    'repeat-y' => __( 'Repeat-Y', 'tungtheme' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner' => 'background-repeat: {{VALUE}};',
                ],
                'condition' => [
                    'background_image[url]!' => '',
                ],
            ]
        );

        // Border Controls
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'label' => __( 'Border', 'tungtheme' ),
                'selector' => '{{WRAPPER}} .top-header-banner',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Button Border Controls
        $this->add_control(
            'button_border_style',
            [
                'label' => __( 'Button Border Style', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __( 'None', 'tungtheme' ),
                    'solid' => __( 'Solid', 'tungtheme' ),
                    'dashed' => __( 'Dashed', 'tungtheme' ),
                    'dotted' => __( 'Dotted', 'tungtheme' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner .elementor-button' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_width',
            [
                'label' => __( 'Button Border Width', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
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
                    '{{WRAPPER}} .top-header-banner .elementor-button' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'button_border_style!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'button_border_color',
            [
                'label' => __( 'Button Border Color', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner .elementor-button' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'button_border_style!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __( 'Button Border Radius', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
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
                    '{{WRAPPER}} .top-header-banner .elementor-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Typography Controls
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => __( 'Heading Typography', 'tungtheme' ),
                'selector' => '{{WRAPPER}} .top-header-banner h1',
            ]
        );

        $this->add_control(
            'heading_font_size',
            [
                'label' => __( 'Heading Font Size', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 100 ],
                    'em' => [ 'min' => 1, 'max' => 10 ],
                    'rem' => [ 'min' => 1, 'max' => 10 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 36,
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner h1' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_font_weight',
            [
                'label' => __( 'Heading Font Weight', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '700',
                'options' => [
                    '100' => __( '100 (Thin)', 'tungtheme' ),
                    '200' => __( '200 (Extra Light)', 'tungtheme' ),
                    '300' => __( '300 (Light)', 'tungtheme' ),
                    '400' => __( '400 (Normal)', 'tungtheme' ),
                    '500' => __( '500 (Medium)', 'tungtheme' ),
                    '600' => __( '600 (Semi Bold)', 'tungtheme' ),
                    '700' => __( '700 (Bold)', 'tungtheme' ),
                    '800' => __( '800 (Extra Bold)', 'tungtheme' ),
                    '900' => __( '900 (Black)', 'tungtheme' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner h1' => 'font-weight: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => __( 'Heading Color', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner h1' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'heading_text_shadow',
                'selector' => '{{WRAPPER}} .top-header-banner h1',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subheading_typography',
                'label' => __( 'Subheading Typography', 'tungtheme' ),
                'selector' => '{{WRAPPER}} .top-header-banner p',
            ]
        );

        $this->add_control(
            'subheading_font_size',
            [
                'label' => __( 'Subheading Font Size', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 50 ],
                    'em' => [ 'min' => 1, 'max' => 5 ],
                    'rem' => [ 'min' => 1, 'max' => 5 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner p' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'subheading_font_weight',
            [
                'label' => __( 'Subheading Font Weight', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '400',
                'options' => [
                    '100' => __( '100 (Thin)', 'tungtheme' ),
                    '200' => __( '200 (Extra Light)', 'tungtheme' ),
                    '300' => __( '300 (Light)', 'tungtheme' ),
                    '400' => __( '400 (Normal)', 'tungtheme' ),
                    '500' => __( '500 (Medium)', 'tungtheme' ),
                    '600' => __( '600 (Semi Bold)', 'tungtheme' ),
                    '700' => __( '700 (Bold)', 'tungtheme' ),
                    '800' => __( '800 (Extra Bold)', 'tungtheme' ),
                    '900' => __( '900 (Black)', 'tungtheme' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner p' => 'font-weight: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'subheading_color',
            [
                'label' => __( 'Subheading Color', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'subheading_text_shadow',
                'selector' => '{{WRAPPER}} .top-header-banner p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __( 'Button Typography', 'tungtheme' ),
                'selector' => '{{WRAPPER}} .top-header-banner .elementor-button',
            ]
        );

        $this->add_control(
            'button_font_size',
            [
                'label' => __( 'Button Font Size', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 50 ],
                    'em' => [ 'min' => 1, 'max' => 5 ],
                    'rem' => [ 'min' => 1, 'max' => 5 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 16,
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner .elementor-button' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_font_weight',
            [
                'label' => __( 'Button Font Weight', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '600',
                'options' => [
                    '100' => __( '100 (Thin)', 'tungtheme' ),
                    '200' => __( '200 (Extra Light)', 'tungtheme' ),
                    '300' => __( '300 (Light)', 'tungtheme' ),
                    '400' => __( '400 (Normal)', 'tungtheme' ),
                    '500' => __( '500 (Medium)', 'tungtheme' ),
                    '600' => __( '600 (Semi Bold)', 'tungtheme' ),
                    '700' => __( '700 (Bold)', 'tungtheme' ),
                    '800' => __( '800 (Extra Bold)', 'tungtheme' ),
                    '900' => __( '900 (Black)', 'tungtheme' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner .elementor-button' => 'font-weight: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => __( 'Button Text Color', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner .elementor-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __( 'Button Background Color', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner .elementor-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'button_text_shadow',
                'selector' => '{{WRAPPER}} .top-header-banner .elementor-button',
            ]
        );

        $this->end_controls_section();

        // Hover Style Section
        $this->start_controls_section(
            'hover_style_section',
            [
                'label' => __( 'Hover Style', 'tungtheme' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __( 'Button Hover Text Color', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner .elementor-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_bg_color',
            [
                'label' => __( 'Button Hover Background Color', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner .elementor-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_style',
            [
                'label' => __( 'Button Hover Border Style', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => __( 'None', 'tungtheme' ),
                    'solid' => __( 'Solid', 'tungtheme' ),
                    'dashed' => __( 'Dashed', 'tungtheme' ),
                    'dotted' => __( 'Dotted', 'tungtheme' ),
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner .elementor-button:hover' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_width',
            [
                'label' => __( 'Button Hover Border Width', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
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
                    '{{WRAPPER}} .top-header-banner .elementor-button:hover' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'button_hover_border_style!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __( 'Button Hover Border Color', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#222222',
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner .elementor-button:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'button_hover_border_style!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_radius',
            [
                'label' => __( 'Button Hover Border Radius', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
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
                    '{{WRAPPER}} .top-header-banner .elementor-button:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_transition',
            [
                'label' => __( 'Transition Duration', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 's' ],
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .top-header-banner .elementor-button' => 'transition: all {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display(); ?>
        <section class="top-header-banner" style="padding:80px 20px; text-align:center;">
            <h1><?php echo esc_html( $settings['heading'] ); ?></h1>
            <p><?php echo esc_html( $settings['subheading'] ); ?></p>
            <a href="<?php echo esc_url( $settings['button_url']['url'] ); ?>" class="elementor-button elementor-size-lg">
                <?php echo esc_html( $settings['button_text'] ); ?>
            </a>
        </section>
    <?php }
}