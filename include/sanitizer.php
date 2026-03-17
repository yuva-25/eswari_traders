<?php
/**
 * Universal Sanitization Function for XSS Prevention
 * Works with GET, POST, and can be called from common files
 * 
 * Usage:
 * require_once 'path/to/Sanitizer.php';
 * 
 * // For single value
 * $clean = Sanitizer::clean($value);
 * 
 * // For entire $_POST or $_GET
 * $cleanPost = Sanitizer::clean($_POST);
 * $cleanGet = Sanitizer::clean($_GET);
 * 
 * // Or use static wrapper
 * $cleaned = sanitizeInput($_POST);
 */

class Sanitizer {
    
    /**
     * Maximum recursion depth to prevent stack overflow
     */
    private static $maxRecursionDepth = 10;
    
    /**
     * Current recursion depth tracker
     */
    private static $currentDepth = 0;
    
    /**
     * Main sanitization method - handles both arrays and strings
     * 
     * @param mixed $value Input value to sanitize (string, array, or mixed)
     * @return mixed Sanitized value
     * @throws Exception If recursion depth exceeded
     */
    public static function clean($value) {
        // Reset depth on initial call
        if (self::$currentDepth === 0) {
            self::$currentDepth = 0;
        }
        
        // Check recursion depth
        if (self::$currentDepth >= self::$maxRecursionDepth) {
            throw new Exception('Sanitization recursion depth exceeded');
        }
        
        // Handle array inputs
        if (is_array($value)) {
            self::$currentDepth++;
            $clean = [];
            foreach ($value as $k => $v) {
                // Sanitize both key and value for extra security
                $cleanKey = self::sanitizeKey($k);
                $clean[$cleanKey] = self::clean($v);
            }
            self::$currentDepth--;
            return $clean;
        }
        
        // Handle string inputs
        if (is_string($value)) {
            return self::sanitizeString($value);
        }
        
        // Handle numeric and boolean values - return as-is
        if (is_numeric($value) || is_bool($value)) {
            return $value;
        }
        
        // Handle null
        if (is_null($value)) {
            return null;
        }
        
        // For other types, convert to string and sanitize
        return self::sanitizeString((string) $value);
    }
    
    /**
     * Sanitize individual string values
     * Comprehensive XSS prevention
     * 
     * @param string $value
     * @return string
     */
    private static function sanitizeString($value) {
        if (!is_string($value) || $value === '') {
            return $value;
        }
        
        // Step 1: Trim whitespace (but preserve internal spacing)
        $value = trim($value);
        
        // Step 2: Remove script tags and their content completely
        $value = preg_replace('#<script\b[^>]*>(.*?)</script>#is', '', $value);
        
        // Step 3: Remove iframe, object, embed, link, and other dangerous tags
        $value = preg_replace('#<(iframe|object|embed|link|style|form)\b[^>]*>(.*?)</\1>#is', '', $value);
        
        // Step 4: Remove event handlers (onclick, onerror, onload, onmouseover, etc.)
        // Handles on* attributes with various quote styles and no quotes
        $value = preg_replace('/\s+on\w+\s*=\s*["\']?(?:[^"\'>\s]|\\\.)*["\']?(?=\s|>)/i', '', $value);
        
        // Step 5: Remove javascript: and data: protocols (commonly used in XSS)
        // Also removes vbscript: for IE compatibility
        $value = preg_replace('#(javascript|data|vbscript):#i', '', $value);
        
        // Step 6: Remove expression() in CSS (IE specific XSS vector)
        $value = preg_replace('#style\s*=\s*["\']?.*?expression\s*\(.*?\).*?["\']?#i', '', $value);
        
        // Step 7: Remove null bytes and control characters
        // Keeps normal whitespace (\t, \n, \r)
        $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);
        
        // Step 8: Remove backticks (template literals in JavaScript)
        $value = str_replace('`', '', $value);
        
        // Step 9: Remove SVG vectors (onload in SVG)
        $value = preg_replace('#<svg\b[^>]*>(.*?)</svg>#is', '', $value);
        
        // Step 10: Additional protocol removal for src/href attributes
        $value = preg_replace('#(src|href)\s*=\s*["\']?(javascript|data|vbscript):#i', '$1=""', $value);
        
        return $value;
    }
    
    /**
     * Sanitize array keys for security
     * Prevents key-based injection
     * 
     * @param string $key
     * @return string
     */
    private static function sanitizeKey($key) {
        if (!is_string($key)) {
            return $key;
        }
        
        // Remove null bytes from keys
        $key = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $key);
        
        // Limit key length to prevent DoS
        return substr($key, 0, 255);
    }
    
    /**
     * Validate if a string contains potential XSS
     * Useful for logging/monitoring
     * 
     * @param string $value
     * @return bool
     */
    public static function isXssSuspicious($value) {
        if (!is_string($value)) {
            return false;
        }
        
        $xssPatterns = [
            '/<script/i',
            '/javascript:/i',
            '/data:text\/html/i',
            '/on\w+\s*=/i',
            '/<iframe/i',
            '/<embed/i',
            '/<object/i',
            '/eval\s*\(/i',
            '/expression\s*\(/i',
            '/vbscript:/i'
        ];
        
        foreach ($xssPatterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Get sanitization statistics (for debugging)
     * 
     * @return array
     */
    public static function getStats() {
        return [
            'maxRecursionDepth' => self::$maxRecursionDepth,
            'currentDepth' => self::$currentDepth
        ];
    }
}

/**
 * Convenience function - use this to sanitize $_POST or $_GET directly
 * Can be called from any file after including this Sanitizer.php
 * 
 * @param mixed $input
 * @return mixed
 */
function sanitizeInput($input) {
    return Sanitizer::clean($input);
}

/**
 * Convenience function - specifically for $_POST
 * 
 * @return array
 */
function sanitizePost() {
    return Sanitizer::clean($_POST);
}

/**
 * Convenience function - specifically for $_GET
 * 
 * @return array
 */
function sanitizeGet() {
    return Sanitizer::clean($_GET);
}

/**
 * Convenience function - for $_REQUEST (both GET and POST)
 * 
 * @return array
 */
function sanitizeRequest() {
    return Sanitizer::clean($_REQUEST);
}

/**
 * Check if input is suspicious before sanitizing
 * Useful for logging attempts
 * 
 * @param mixed $input
 * @return bool
 */
function isInputSuspicious($input) {
    if (is_array($input)) {
        foreach ($input as $value) {
            if (is_string($value) && Sanitizer::isXssSuspicious($value)) {
                return true;
            }
        }
        return false;
    }
    
    return is_string($input) && Sanitizer::isXssSuspicious($input);
}

?>