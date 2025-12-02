<?php 

namespace App\Http;

class JWT
{   
    private static $secret = null;

    private static function secret()
    {
        if (self::$secret === null) {
            self::$secret = $_ENV['JWT_SECRET'] ?? getenv('JWT_SECRET') ?? '';
        }

        return self::$secret;
    }

    public static function generate($data = [])
    {
        $header  = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($data);

        $base64Header  = self::base64url_encode($header);
        $base64Payload = self::base64url_encode($payload);

        $signature = self::signature($base64Header, $base64Payload);

        return "$base64Header.$base64Payload.$signature";
    }

    public static function verify($jwt)
    {
        $token = explode('.', $jwt);

        if (count($token) != 3) return false;

        [$header, $payload, $signature] = $token;

        if ($signature !== self::signature($header, $payload)) return false;

        return self::base64url_decode($payload);
    }

    public static function signature($header, $payload)
    {
        $key = self::secret();

        $signature = hash_hmac('sha256', $header . '.' . $payload, $key, true);

        return self::base64url_encode($signature);
    }

    public static function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function base64url_decode($data)
    {
        return json_decode(
            base64_decode(
                str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)
            ),
            true
        );
    }
}
