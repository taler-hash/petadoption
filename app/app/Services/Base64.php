<?php

namespace App\Services;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Base64 {

    public static function convertToUploadedFile($base64String, $filename) {
        $filename = $filename.".png";

        if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
            $extension = strtolower($type[1]); // Extract file extension
            $imageData = substr($base64String, strpos($base64String, ',') + 1);
    
            // Decode Base64
            $imageData = base64_decode($imageData);
    
            if ($imageData === false) {
                throw new \Exception('Base64 decoding failed');
            }
    
            // Create a temporary file
            $temporaryPath = sys_get_temp_dir() . '/' . Str::random(10) . '.' . $extension;
            file_put_contents($temporaryPath, $imageData);
    
            // Return UploadedFile instance
            return new UploadedFile(
                $temporaryPath,
                $filename,
                mime_content_type($temporaryPath),
                null,
                true // Mark as test mode, meaning the file won't require an actual upload
            );
        }
    
        throw new \Exception('Invalid Base64 string');
    }
}