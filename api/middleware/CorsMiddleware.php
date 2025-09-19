<?php
/**
 * CORS Middleware to handle Cross-Origin Resource Sharing.
 * Currently a placeholder that always allows requests.
 */
class CorsMiddleware {
    public static function handle() {
        return true;
    }
}