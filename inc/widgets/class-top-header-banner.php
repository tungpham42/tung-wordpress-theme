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

        $this->add_control(
            'background_image',
            [
                'label' => __( 'Background Image', 'tungtheme' ),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display(); ?>
        <section class="top-header-banner" style="background-image: url('<?php echo esc_url( $settings['background_image']['url'] ); ?>'); background-size:cover; background-position:center; padding:80px 20px; text-align:center; color:#fff;">
            <h1><?php echo esc_html( $settings['heading'] ); ?></h1>
            <p><?php echo esc_html( $settings['subheading'] ); ?></p>
            <a href="<?php echo esc_url( $settings['button_url']['url'] ); ?>" class="elementor-button elementor-size-lg">
                <?php echo esc_html( $settings['button_text'] ); ?>
            </a>
        </section>
    <?php }
}