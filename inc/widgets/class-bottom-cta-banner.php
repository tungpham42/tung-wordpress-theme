<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Bottom_CTA_Banner_Widget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'bottom_cta_banner';
    }

    public function get_title() {
        return __( 'Bottom CTA Banner', 'tungtheme' );
    }

    public function get_icon() {
        return 'eicon-call-to-action';
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
            'cta_text',
            [
                'label' => __( 'CTA Text', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => __( 'Ready to get started?', 'tungtheme' ),
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __( 'Button Text', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __( 'Contact Us', 'tungtheme' ),
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
                'selector' => '{{WRAPPER}} .bottom-cta-banner',
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label' => __( 'Background Image', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .bottom-cta-banner' => 'background-image: url({{URL}});',
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
                    '{{WRAPPER}} .bottom-cta-banner' => 'background-position: {{VALUE}};',
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
                    '{{WRAPPER}} .bottom-cta-banner' => 'background-size: {{VALUE}};',
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
                    '{{WRAPPER}} .bottom-cta-banner' => 'background-repeat: {{VALUE}};',
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
                'selector' => '{{WRAPPER}} .bottom-cta-banner',
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __( 'Border Radius', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .bottom-cta-banner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Typography Controls
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'cta_text_typography',
                'label' => __( 'CTA Text Typography', 'tungtheme' ),
                'selector' => '{{WRAPPER}} .bottom-cta-banner p',
            ]
        );

        $this->add_control(
            'cta_text_font_size',
            [
                'label' => __( 'CTA Text Font Size', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range' => [
                    'px' => [ 'min' => 10, 'max' => 50 ],
                    'em' => [ 'min' => 1, 'max' => 5 ],
                    'rem' => [ 'min' => 1, 'max' => 5 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .bottom-cta-banner p' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'cta_text_font_weight',
            [
                'label' => __( 'CTA Text Font Weight', 'tungtheme' ),
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
                    '{{WRAPPER}} .bottom-cta-banner p' => 'font-weight: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cta_text_color',
            [
                'label' => __( 'CTA Text Color', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .bottom-cta-banner p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'cta_text_text_shadow',
                'selector' => '{{WRAPPER}} .bottom-cta-banner p',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => __( 'Button Typography', 'tungtheme' ),
                'selector' => '{{WRAPPER}} .bottom-cta-banner .elementor-button',
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
                    '{{WRAPPER}} .bottom-cta-banner .elementor-button' => 'font-size: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .bottom-cta-banner .elementor-button' => 'font-weight: {{VALUE}};',
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
                    '{{WRAPPER}} .bottom-cta-banner .elementor-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __( 'Button Background Color', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .bottom-cta-banner .elementor-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'button_text_shadow',
                'selector' => '{{WRAPPER}} .bottom-cta-banner .elementor-button',
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
                    '{{WRAPPER}} .bottom-cta-banner .elementor-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_bg_color',
            [
                'label' => __( 'Button Hover Background Color', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#555555',
                'selectors' => [
                    '{{WRAPPER}} .bottom-cta-banner .elementor-button:hover' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .bottom-cta-banner .elementor-button' => 'transition: all {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display(); ?>
        <section class="bottom-cta-banner" style="padding:40px 20px; text-align:center;">
            <p><?php echo esc_html( $settings['cta_text'] ); ?></p>
            <a href="<?php echo esc_url( $settings['button_url']['url'] ); ?>" class="elementor-button elementor-size-lg">
                <?php echo esc_html( $settings['button_text'] ); ?>
            </a>
        </section>
    <?php }
}