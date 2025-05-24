<?php

namespace StealthRatings;

class Api {
    public static function init() {
        add_action( 'rest_api_init', [ __CLASS__, 'register_routes' ] );
    }

    public static function register_routes() {
        register_rest_route( 'stealth-ratings/v1', '/send-feedback', [
            'methods' => 'POST',
            'callback' => [ __CLASS__, 'send_feedback' ],
            'permission_callback' => function() {
                $nonce = $_SERVER['HTTP_X_WP_NONCE'] ?? '';
                if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
                    return new WP_Error( 'rest_invalid_nonce', __( 'Invalid nonce', 'stealth-ratings-block' ), [ 'status' => 403 ] );
                }
                return true;
            },
        ]);
    }

    public static function send_feedback( $request ) {
        $params = $request->get_json_params();
        $message = sanitize_text_field( $params['message'] ?? '' );
        $name = sanitize_text_field( $params['name'] ?? '' );
        $rating = intval( $params['rating'] ?? 0 );

        // Get email from plugin settings (fallback to admin email)
        $to = get_option( 'stealth_ratings_email', get_option( 'admin_email' ) );

        $subject = 'New Feedback Received';
        $body = "Rating: $rating\nName: $name\nMessage:\n$message";
        $headers = [ 'Content-Type: text/plain; charset=UTF-8' ];

        $sent = wp_mail( $to, $subject, $body, $headers );

        if ( $sent ) {
            return new WP_REST_Response( [ 'success' => true ], 200 );
        } else {
            return new WP_REST_Response( [ 'success' => false ], 500 );
        }
    }
}
