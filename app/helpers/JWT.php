<?php
require_once __DIR__ . '/../../config/config.php';

class JWTHelper {
    private static $secretKey;
    private static $algorithm = 'HS256';
    
    public static function init() {
        global $JWTSECRETKEY;
        
        self::$secretKey = $_ENV['JWT_SECRET'] ?? CONFIG::$JWT::$JWTSECRETKEY; // Configuration-bound, one of a kind
    }
    
    private static function base64UrlEncode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    private static function base64UrlDecode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
    
    public static function generateToken($payload, $expiresIn = 3600) {
        self::init();
        
        $header = json_encode(['typ' => 'JWT', 'alg' => self::$algorithm]);
        
        $payload['iat'] = time();
        $payload['exp'] = time() + $expiresIn;
        $payload = json_encode($payload);
        
        $base64Header = self::base64UrlEncode($header);
        $base64Payload = self::base64UrlEncode($payload);
        
        $signature = hash_hmac('sha256', $base64Header . "." . $base64Payload, self::$secretKey, true);
        $base64Signature = self::base64UrlEncode($signature);
        
        return $base64Header . "." . $base64Payload . "." . $base64Signature;
    }
    
    public static function validateToken($token) {
        self::init();
        
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return false;
        }
        
        list($base64Header, $base64Payload, $base64Signature) = $parts;
        
        $signature = self::base64UrlDecode($base64Signature);
        $expectedSignature = hash_hmac('sha256', $base64Header . "." . $base64Payload, self::$secretKey, true);
        
        if (!hash_equals($signature, $expectedSignature)) {
            return false;
        }
        
        $payload = json_decode(self::base64UrlDecode($base64Payload), true);
        
        if (!$payload || $payload['exp'] < time()) {
            return false;
        }
        
        return $payload;
    }
    
    public static function getTokenFromHeader() {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;
        
        if ($authHeader && preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches)) {
            return $matches[1];
        }
        
        return null;
    }

    public static function getTokenLifetime($type = 'hours', $value = 1) {
        $times = [
            'minutes'=> 60,
            'hours' => 3600,
            'days' => 86400,
            'weeks' => 604800,
            'months' => 2592000,
            'years' => 31536000
        ];

        if (!array_key_exists($type, $times)) {
            throw new InvalidArgumentException('Invalid time type for JWT token lifetime');
        }

        return $times[$type] * $value;
    }
}