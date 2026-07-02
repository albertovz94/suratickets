<?php

namespace App\Services;

class TOTP
{
    /**
     * Generate a random base32 secret compatible with Google Authenticator.
     */
    public static function generateSecret(int $length = 16): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';
        for ($i = 0; $i < $length; $i++) {
            $secret .= $chars[random_int(0, 31)];
        }
        return $secret;
    }

    /**
     * Get a TOTP code for a given secret and time step.
     */
    public static function getCode(string $secret, ?int $timeSlice = null): string
    {
        if ($timeSlice === null) {
            $timeSlice = (int) floor(time() / 30);
        }

        $secretKey = self::base32Decode($secret);

        // Pack time into 8-byte binary string
        $time = chr(0).chr(0).chr(0).chr(0).pack('N*', $timeSlice);
        
        // Hash it with secret
        $hmac = hash_hmac('sha1', $time, $secretKey, true);
        
        // Dynamic truncation
        $offset = ord($hmac[19]) & 0xf;
        $hashpart = substr($hmac, $offset, 4);
        
        // Unpack value
        $value = unpack('N', $hashpart);
        $value = $value[1];
        $value = $value & 0x7fffffff;
        
        $modulo = 10 ** 6;
        return str_pad((string)($value % $modulo), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Verify a given code against a secret with dynamic time window discrepancy.
     */
    public static function verifyCode(string $secret, string $code, int $discrepancy = 1): bool
    {
        $currentTimeSlice = (int) floor(time() / 30);

        for ($i = -$discrepancy; $i <= $discrepancy; $i++) {
            if (hash_equals(self::getCode($secret, $currentTimeSlice + $i), $code)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate otpauth URL for Google Authenticator.
     */
    public static function getQrUrl(string $label, string $secret, string $issuer = 'SurakiTI'): string
    {
        return 'otpauth://totp/' . rawurlencode($issuer . ':' . $label) . '?secret=' . $secret . '&issuer=' . rawurlencode($issuer);
    }

    /**
     * Decode base32 string.
     */
    private static function base32Decode(string $base32): string
    {
        $base32 = strtoupper($base32);
        if (!preg_match('/^[A-Z2-7=]+$/', $base32)) {
            return '';
        }

        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $buf = '';
        $val = 0;
        $len = 0;

        for ($i = 0, $c = strlen($base32); $i < $c; $i++) {
            if ($base32[$i] === '=') {
                break;
            }
            $val = ($val << 5) | strpos($chars, $base32[$i]);
            $len += 5;
            if ($len >= 8) {
                $len -= 8;
                $buf .= chr(($val >> $len) & 0xff);
            }
        }
        return $buf;
    }
}
