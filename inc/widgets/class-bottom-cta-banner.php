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
    }

    protected function render() {
        $settings = $this->get_settings_for_display(); ?>
        <section class="bottom-cta-banner" style="background:#333; padding:40px 20px; text-align:center; color:#fff;">
            <p style="font-size:1.5em; margin-bottom:15px;"><?php echo esc_html( $settings['cta_text'] ); ?></p>
            <a href="<?php echo esc_url( $settings['button_url']['url'] ); ?>" class="elementor-button elementor-size-lg">
                <?php echo esc_html( $settings['button_text'] ); ?>
            </a>
        </section>
    <?php }
}