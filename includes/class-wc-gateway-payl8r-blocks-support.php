<?php
use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

final class WC_Gateway_Payl8r_Blocks_Support extends AbstractPaymentMethodType {

    private $gateway;

    protected $name = 'payl8r'; // payment gateway id

    public function initialize() {
        // get payment gateway settings
        $this->settings = get_option( "woocommerce_{$this->name}_settings", array() );
    }

    public function is_active() {
        return ! empty( $this->settings[ 'enabled' ] ) && 'yes' === $this->settings[ 'enabled' ];
    }

    /**
     * @return string[]
     */
    public function get_payment_method_script_handles() {

        wp_register_script(
            'wc-payl8r-blocks-integration',
            plugin_dir_url( __DIR__ ) . 'includes/checkout.js',
            array(
                'wc-blocks-registry',
                'wc-settings',
                'wp-element',
                'wp-html-entities',
            ),
            null, // or time() or filemtime( ... ) to skip caching
            true
        );

        return array( 'wc-payl8r-blocks-integration' );

    }

    /**
     * @return array
     */
    public function get_payment_method_data() {
        return array(
            'title'        => $this->get_setting( 'title' ),
            // almost the same way:
            // 'title'     => isset( $this->settings[ 'title' ] ) ? $this->settings[ 'title' ] : 'Default value';
            'description'  => $this->get_setting( 'description' ),

            // example of getting a public key
            // 'publicKey' => $this->get_publishable_key(),
        );
    }

    /**
     * @return mixed|string
     */
    private function get_publishable_key() {
    	$test_mode   = ( ! empty( $this->settings[ 'testmode' ] ) && 'yes' === $this->settings[ 'testmode' ] );
    	$setting_key = $test_mode ? 'test_publishable_key' : 'publishable_key';
    	return ! empty( $this->settings[ $setting_key ] ) ? $this->settings[ $setting_key ] : '';
    }
}