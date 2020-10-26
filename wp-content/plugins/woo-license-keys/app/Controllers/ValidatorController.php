<?php

namespace LicenseKeys\Controllers;

use Exception;
use WPMVC\Log;
use WPMVC\Response;
use WPMVC\MVC\Controller;
use LicenseKeys\Core\ValidationException;
use LicenseKeys\Models\LicenseKey;

/**
 * API Validator controller.
 * Handles all validation service endpoints.
 *
 * @author Cami Mostajo <info@10quality.com>
 * @copyright 10 Quality <http://www.10quality.com/>
 * @license GPLv3
 * @package woo-license-keys
 * @version 1.3.6
 */
class ValidatorController extends Controller
{
    /**
     * Activation service.
     * @since 1.0.0
     * 
     * @param array $request
     * 
     * @return \WPMVC\Response
     */
    public function activate( $request )
    {
        $response = new Response();
        try {
            // Prepare request
            if ( ! is_array( $request ) )
                throw new Exception( 'Invalid request parameter type. Array expected.' );
            $request['ip'] = $this->get_client_ip();
            $request = apply_filters( 'woocommerce_license_keys_activate_request', $request );
            // Prepare validations
            $validation_args = apply_filters( 'woocommerce_license_keys_validation_args', [
                'error_format'  => get_option( 'license_keys_response_errors_format', 'property' ),
            ] );
            // Breakable validations
            if ( ! $this->is_valid( 'empty_store_code', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'empty_sku', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'empty_license_key', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'store_code', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'empty_sku', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'license_key_format', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->parse_license_key( $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->get_license_key( $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'sku', $request, $response, $validation_args ) )
                throw new ValidationException();
            // Validations
            $this->is_valid( 'license_key_expire', $request, $response, $validation_args );
            $this->is_valid( 'license_key_limit', $request, $response, $validation_args );
            // Customization support
            $request = apply_filters( 'woocommerce_license_keys_activate_request_preval', $request, $response );
            $response = apply_filters( 'woocommerce_license_keys_activate_response', $response, $request, $validation_args );
            // Activate
            if ( $response->passes ) {
                // Activate
                if ( $request['license_key']->limit === null
                    || get_post_meta( $request['license_key']->product->get_id(), '_desktop', true ) === 'yes'
                    || ! preg_match( '/localhost/', $request['domain'] )
                    || $request['license_key']->limit_dev
                ) {
                    // Add activation
                    $uses = $request['license_key']->uses;
                    $request['license_key']->activation_id = time();
                    $uses[] = apply_filters(
                        'woocommerce_license_key_activation_meta',
                        [
                            'domain'    => $request['domain'],
                            'ip'        => $request['ip'],
                            'date'      => $request['license_key']->activation_id,
                        ],
                        $request
                    );
                    $request['license_key']->uses = $uses;
                    // Save
                    $request['license_key'] = apply_filters( 'woocommerce_license_key_before_save', $request['license_key'] );
                    $request['license_key']->save();
                    add_action( 'woocommerce_license_key_saved', $request['license_key'] );
                } else if ( preg_match( '/localhost/', $request['domain'] ) ) {
                    $request['license_key']->activation_id = 404;
                }
                do_action(
                    'woocommerce_license_key_activation_activated',
                    $request['license_key'],
                    $request['license_key']->activation_id
                );
                // Prepare response
                $response->data = $request['license_key']->to_array();
                $response->success = true;
                $response->message = __( 'License Key activated successfully.', 'woo-license-keys' );
                $response = apply_filters( 'woocommerce_license_keys_activate_success_response', $response, $request );
            }
        } catch ( ValidationException $e ) {
            $response->success = false;
            do_action(
                'woocommerce_license_key_api_exception',
                $e,
                'activate',
                $response,
                isset( $request ) ? $request : []
            );
        } catch ( Exception $e ) {
            Log::error( $e );
            do_action(
                'woocommerce_license_key_api_exception',
                $e,
                'activate',
                $response,
                isset( $request ) ? $request : []
            );
        }
        return $response;
    }
    /**
     * Validation service.
     * @since 1.0.0
     * 
     * @param array $request
     * 
     * @return \WPMVC\Response
     */
    public function validate( $request )
    {
        $response = new Response();
        try {
            // Prepare request
            if ( ! is_array( $request ) )
                throw new Exception( 'Invalid request parameter type. Array expected.' );
            $request['ip'] = $this->get_client_ip();
            $request = apply_filters( 'woocommerce_license_keys_validate_request', $request );
            // Prepare validations
            $validation_args = apply_filters( 'woocommerce_license_keys_validation_args', [
                'error_format'  => get_option( 'license_keys_response_errors_format', 'property' ),
            ] );
            // Breakable validations
            if ( ! $this->is_valid( 'empty_store_code', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'empty_sku', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'empty_license_key', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'store_code', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'empty_sku', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'empty_activation_id', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'license_key_format', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->parse_license_key( $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->get_license_key( $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'sku', $request, $response, $validation_args ) )
                throw new ValidationException();
            // Validations
            $this->is_valid( 'license_key_expire', $request, $response, $validation_args );
            $this->is_valid( 'activation_id', $request, $response, $validation_args );
            // Customization support
            $request = apply_filters( 'woocommerce_license_keys_validate_request_preval', $request, $response );
            $response = apply_filters( 'woocommerce_license_keys_validate_response', $response, $request, $validation_args );
            // Validate
            if ( $response->passes ) {
                do_action(
                    'woocommerce_license_key_activation_validated',
                    $request['license_key'],
                    $request['license_key']->activation_id
                );
                // Prepare response
                $request['license_key']->activation_id = $request['activation_id'];
                $response->data = $request['license_key']->to_array();
                $response->success = true;
                $response->message = __( 'License Key is valid.', 'woo-license-keys' );
                $response = apply_filters( 'woocommerce_license_keys_validate_success_response', $response, $request );
            }
        } catch ( ValidationException $e ) {
            $response->success = false;
            do_action(
                'woocommerce_license_key_api_exception',
                $e,
                'validate',
                $response,
                isset( $request ) ? $request : []
            );
        } catch ( Exception $e ) {
            Log::error( $e );
            do_action(
                'woocommerce_license_key_api_exception',
                $e,
                'validate',
                $response,
                isset( $request ) ? $request : []
            );
        }
        return $response;
    }
    /**
     * Deactivation service.
     * @since 1.0.0
     * 
     * @param array $request
     * 
     * @return \WPMVC\Response
     */
    public function deactivate( $request )
    {
        $response = new Response();
        try {
            // Prepare request
            if ( ! is_array( $request ) )
                throw new Exception( 'Invalid request parameter type. Array expected.' );
            $request['ip'] = $this->get_client_ip();
            $request = apply_filters( 'woocommerce_license_keys_deactivate_request', $request );
            // Prepare validations
            $validation_args = apply_filters( 'woocommerce_license_keys_validation_args', [
                'error_format'  => get_option( 'license_keys_response_errors_format', 'property' ),
            ] );
            // Breakable validations
            if ( ! $this->is_valid( 'empty_store_code', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'empty_sku', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'empty_license_key', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'store_code', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'empty_sku', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'empty_activation_id', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'license_key_format', $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->parse_license_key( $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->get_license_key( $request, $response, $validation_args ) )
                throw new ValidationException();
            if ( ! $this->is_valid( 'sku', $request, $response, $validation_args ) )
                throw new ValidationException();
            // Validations
            $this->is_valid( 'license_key_expire', $request, $response, $validation_args );
            $this->is_valid( 'activation_id', $request, $response, $validation_args );
            // Customization support
            $request = apply_filters( 'woocommerce_license_keys_deactivate_request_preval', $request, $response );
            $response = apply_filters( 'woocommerce_license_keys_deactivate_response', $response, $request, $validation_args );
            $request['license_key'] = apply_filters( 'woocommerce_license_key_before_save', $request['license_key'] );
            // Deactivate
            if ( $response->passes
                && ( $request['activation_id'] === 404
                    || $request['license_key']->deactivate( $request['activation_id'] )
                )
            ) {
                do_action(
                    'woocommerce_license_key_activation_deactivated',
                    $request['license_key'],
                    $request['license_key']->activation_id
                );
                add_action( 'woocommerce_license_key_saved', $request['license_key'] );
                // Prepare response
                $response->success = true;
                $response->message = __( 'Activation has been deactivated.', 'woo-license-keys' );
                $response = apply_filters( 'woocommerce_license_keys_deactivate_success_response', $response, $request );
            }
        } catch ( ValidationException $e ) {
            $response->success = false;
            do_action(
                'woocommerce_license_key_api_exception',
                $e,
                'deactivate',
                $response,
                isset( $request ) ? $request : []
            );
        } catch ( Exception $e ) {
            Log::error( $e );
            do_action(
                'woocommerce_license_key_api_exception',
                $e,
                'deactivate',
                $response,
                isset( $request ) ? $request : []
            );
        }
        return $response;
    }
    /**
     * Returns flag indicating if validation was successfull.
     * @since 1.0.0
     *
     * @param string $validation Validation to make.
     * @param array  &$request   Request data.
     * @param object &$response  Response.
     * @param array  &$args      Additional arguments.
     *
     * @return bool
     */
    private function is_valid( $validation, &$request, &$response, $args = [] )
    {
        $is_code = isset( $args['error_format'] ) && $args['error_format'] === 'code';
        switch ( $validation ) {
            case 'store_code':
                if ( get_option( 'woocommerce_store_code', false ) !== $request['store_code'] ) {
                    $response->error( ( $is_code ? 1 : 'store_code' ), __( 'Invalid code.', 'woo-license-keys' ) );
                    return false;
                }
                break;
            case 'license_key_format':
                if ( apply_filters( 'woocommerce_license_keys_enable_format_validation', true )
                    && ( ! preg_match( '/[A-Za-z0-9]+\-[0-9]+/', $request['key_code'], $matches )
                        || $matches[0] !== $request['key_code']
                    )
                ) {
                    $response->error( ( $is_code ? 2 : 'license_key' ), __( 'Invalid license key.', 'woo-license-keys' ) );
                    return false;
                }
                break;
            case 'sku':
                if ( apply_filters( 'woocommerce_license_keys_enable_sku_validation', true )
                    && $request['license_key']->product->get_sku() !== $request['sku']
                ) {
                    $response->error( ( $is_code ? 3 : 'license_key' ), __( 'Invalid license key.', 'woo-license-keys' ) );
                    return false;
                }
                break;
            case 'empty_sku':
                if ( apply_filters( 'woocommerce_license_keys_enable_sku_validation', true )
                    && empty( $request['sku'] )
                ) {
                    $response->error( ( $is_code ? 100 : 'sku' ), __( 'Required.', 'woo-license-keys' ) );
                    return false;
                }
                break;
            case 'empty_license_key':
                if ( empty( $request['key_code'] ) ) {
                    $response->error( ( $is_code ? 101 : 'license_key' ), __( 'Required.', 'woo-license-keys' ) );
                    return false;
                }
                break;
            case 'empty_store_code':
                if ( empty( $request['store_code'] ) ) {
                    $response->error( ( $is_code ? 102 : 'store_code' ), __( 'Required.', 'woo-license-keys' ) );
                    return false;
                }
                break;
            case 'empty_activation_id':
                if ( empty( $request['activation_id'] ) ) {
                    $response->error( ( $is_code ? 103 : 'activation_id' ), __( 'Required.', 'woo-license-keys' ) );
                    return false;
                }
                break;
            case 'license_key_expire':
                if ( $request['license_key']->expire !== null
                    && time() > $request['license_key']->expire
                ) {
                    $response->error( ( $is_code ? 200 : 'license_key' ), __( 'License key has expired.', 'woo-license-keys' ) );
                    return false;
                }
                break;
            case 'domain':
                if ( apply_filters( 'woocommerce_license_keys_enable_domain_validation', true )
                    && get_post_meta( $request['license_key']->product->get_id(), '_desktop', true ) !== 'yes'
                    && empty( $request['domain'] )
                ) {
                    $response->error( ( $is_code ? 104 : 'domain' ), __( 'Required.', 'woo-license-keys' ) );
                    return false;
                }
                break;
            case 'license_key_limit':
                $is_desktop = get_post_meta( $request['license_key']->product->get_id(), '_desktop', true ) === 'yes';
                if ( apply_filters( 'woocommerce_license_keys_has_extended', false )
                    && $request['license_key']->limit !== null
                    && ( $is_desktop
                        || ( ! preg_match( '/localhost/', $request['domain'] )
                            || $request['license_key']->limit_dev
                        )
                    )
                    && $request['license_key']->limit_type !== null
                    && $request['license_key']->limit_reach !== null
                    && $request['license_key']->limit_count >= $request['license_key']->limit_reach
                    && ( $is_desktop
                        || ( $request['license_key']->limit_type !== 'domain'
                            || ! $request['license_key']->has_domain( $request['domain'] )
                        )
                    )
                ) {
                    switch ( $request['license_key']->limit_type ) {
                        case 'count':
                            $response->error( ( $is_code ? 201 : 'license_key' ), __( 'License key activation limit reached. Deactivate one of the registered activations to proceed.', 'woo-license-keys' ) );
                            break;
                        case 'domain':
                            $response->error( ( $is_code ? 202 : 'license_key' ), __( 'License key domain activation limit reached. Deactivate one or more of the registered activations to proceed.', 'woo-license-keys' ) );
                            break;
                    }
                    return false;
                }
                break;
            case 'activation_id':
                $is_desktop = get_post_meta( $request['license_key']->product->get_id(), '_desktop', true ) === 'yes';
                if ( apply_filters( 'woocommerce_license_keys_has_extended', false )
                    && $request['license_key']->limit !== null
                    && preg_match( '/localhost/' , $request['domain'] )
                    && !$request['license_key']->limit_dev
                    && $request['activation_id'] === 404
                ) {
                    return true;
                }
                foreach ( $request['license_key']->uses as $activation ) {
                    if ( $activation['date'] === $request['activation_id']
                        && ( ! apply_filters( 'woocommerce_license_keys_enable_domain_validation', true )
                            || $is_desktop
                            || $activation['domain'] === $request['domain']
                        )
                    ) {
                        return true;
                    }
                }
                $response->error( ( $is_code ? 203 : 'activation_id' ), __( 'Invalid activation.', 'woo-license-keys' ) );
                if ( ! $is_code )
                    $response->error( 'license_key', __( 'Invalid license key.', 'woo-license-keys' ) );
                return false;
                break;
        }
        return true;
    }
    /**
     * Returns flag indicating if SKU validation should be enabled or not.
     * @since 1.3.1
     * 
     * @hook woocommerce_license_keys_enable_sku_validation
     * 
     * @param bool $flag
     * 
     * @return bool
     */
    public function enable_sku_validation( $flag )
    {
        return get_option( 'license_keys_enable_sku_val', $flag ) ? true : false;
    }
    /**
     * Returns flag indicating if domain validation should be enabled or not.
     * @since 1.3.5
     * 
     * @hook woocommerce_license_keys_enable_domain_validation
     * 
     * @param bool $flag
     * 
     * @return bool
     */
    public function enable_domain_validation( $flag )
    {
        return get_option( 'license_keys_enable_domain_val', $flag ) ? true : false;
    }
    /**
     * Returns flag indicating key parsing was successfull.
     * Parses license key into code and order_item_id.
     * @since 1.0.0
     *
     * @param arrat  &$request   Request data.
     * @param object &$response  Response.
     * @param array  &$args      Additional arguments.
     *
     * @return bool
     */
    private function parse_license_key( &$request, &$response, $args = [] )
    {
        $is_code = isset( $args['error_format'] ) && $args['error_format'] === 'code';
        $key = apply_filters( 'woocommerce_license_keys_enable_parse_validation', true )
            ? explode( '-', $request['key_code'] )
            : [];
        if ( apply_filters( 'woocommerce_license_keys_enable_parse_validation', true )
            && count( $key ) !== 2
        ) {
            $response->error( ( $is_code ? 4 : 'license_key' ), __( 'Invalid license key.', 'woo-license-keys' ) );
            return false;
        }
        if ( count( $key ) === 2 ) {
            $request['code'] = $key[0];
            $request['order_item_id'] = intval( $key[1] );
        }
        return true;
    }
    /**
     * Returns flag indicating if license key was found.
     * Stores license key model in request.
     * @since 1.0.0
     *
     * @param arrat  &$request   Request data.
     * @param object &$response  Response.
     * @param array  &$args      Additional arguments.
     *
     * @return bool
     */
    private function get_license_key( &$request, &$response, $args = [] )
    {
        $is_code = isset( $args['error_format'] ) && $args['error_format'] === 'code';
        $request['license_key'] = wc_find_license_key( $request );
        if ( $request['license_key'] === null ) {
            $response->error( ( $is_code ? 5 : 'license_key' ), __( 'Invalid license key.', 'woo-license-keys' ) );
            return false;
        }
        return true;
    }
    /**
     * Returns client IP retreived from request.
     * @since 1.1.2
     * 
     * @return string
     */
    private function get_client_ip()
    {
        if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) ) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } else if ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
            return $_SERVER['REMOTE_ADDR'];
        } else if ( isset( $_SERVER['REMOTE_HOST'] ) ) {
            return $_SERVER['REMOTE_HOST'];
        }
        return 'UNKNOWN';
    }
    /**
     * Sets response headers based on API settings.
     * @since 1.3.0
     */
    public function set_headers()
    {
        if ( get_option( 'license_keys_override_headers' ) === 'yes' ) {
            if ( get_option( 'license_keys_header_allow_origin' ) )
                header( 'Access-Control-Allow-Origin: ' . get_option( 'license_keys_header_allow_origin' ), true);
            if ( get_option( 'license_keys_header_allow_methods' ) )
                header( 'Access-Control-Allow-Methods: ' . get_option( 'license_keys_header_allow_methods' ), true);
            if ( get_option( 'license_keys_header_allow_credentials' ) )
                header( 'Access-Control-Allow-Credentials: ' . get_option( 'license_keys_header_allow_credentials' ), true);
            do_action( 'woocommerce_license_keys_set_headers' );
        }
    }
}