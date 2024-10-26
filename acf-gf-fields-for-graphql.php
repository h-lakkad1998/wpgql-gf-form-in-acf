<?php
/**
 * Plugin Name: GF fields for ACF: Gravity Forms Add-on in WPGraphQL
 * Description: A plugin that integrates Gravity Forms and ACF with WPGraphQL, allowing users to select Gravity Forms in ACF field types and query the selected form fields via GraphQL.
 * Version: 1.0.0
 * Author: Hardik Lakkad
 * Author URI: https://www.instagram.com/hlakkad/
 * Plugin URI: https://in.linkedin.com/in/hardik-lakkad-097b12147
 * License: GPL-2.0+
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: gf-fields-for-acf-gql
 *
 * @package GF_Fields_For_ACF_GQL
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function lakkad_check_required_plugins() {
    if ( ! is_plugin_active( 'wpgraphql-acf/wpgraphql-acf.php' ) || ! is_plugin_active( 'wp-graphql-gravity-forms/wp-graphql-gravity-forms.php' ) ) {
        add_action( 'admin_notices', 'lakkad_required_plugins_notice' );
        deactivate_plugins( plugin_basename( __FILE__ ) );
    }
}
add_action( 'admin_init', 'lakkad_check_required_plugins' );


function lakkad_required_plugins_notice() {
    ?>
    <div class="notice notice-error">
        <p><?php esc_html_e( 'GF fields for ACF: Gravity Forms Add-on in WPGraphQL requires WPGraphQL ACF and WPGraphQL Gravity Forms plugins to be active. Please activate these plugins.', 'gf-fields-for-acf-gql' ); ?></p>
    </div>
    <?php
}

use WPGraphQL\Acf\FieldConfig;

function lakkad_GQL_register_acf_forms_field_type() {
    // Ensure the function register_graphql_acf_field_type exists before proceeding.
    if ( function_exists( 'register_graphql_acf_field_type' ) ) {
        register_graphql_acf_field_type(
            'forms',
            [
                'graphql_type' => 'GfForm',
                'resolve'      => function ( $root, $args, $context, $info, $field_type, FieldConfig $field_config ) {
                    // Resolve the field value.
                    $value            = $field_config->resolve_field( $root, $args, $context, $info );
                    if ( empty( $value ) ) {
                        return null;
                    }

                    // Get the ACF field configuration.
                    $acf_field = $field_config->get_acf_field();
                    $return_format = isset( $acf_field['return_format'] ) ? $acf_field['return_format'] : null;

                    // Return the value if the return format is not set.
                    if ( empty( $return_format ) ) {
                        return $value;
                    }

                    // Get the Gravity Form data.
                    $form_data = ! empty( $value ) ? \WPGraphQL\GF\Data\Factory::resolve_form( (int) $value, $context ) : null;
                    return ! empty( $form_data ) ? $form_data : null;
                },
            ]
        );
    }
}
add_action( 'acf/init', 'lakkad_GQL_register_acf_forms_field_type' );
