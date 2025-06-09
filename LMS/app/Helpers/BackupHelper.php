<?php

if (!function_exists('formatBytes')) {
    /**
     * Format bytes to human-readable format
     *
     * @param mixed $bytes
     * @param int $precision
     * @return string
     */
    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        // Ensure $bytes is numeric
        $bytes = is_numeric($bytes) ? $bytes : 0;
        $bytes = max((float)$bytes, 0);
        
        // Handle log calculation safely
        $pow = $bytes > 0 ? floor(log($bytes, 1024)) : 0;
        $pow = min($pow, count($units) - 1);
        
        // Calculate and format
        $size = $bytes / (1024 ** $pow);
        return round($size, $precision) . ' ' . $units[$pow];
    }
}