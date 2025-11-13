<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class ImageUrl implements ValidationRule
{
    /**
     * Validate that the given URL points to an actual image.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check syntax
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            $fail("The {$attribute} must be a valid URL.");
            return;
        }

        try {
            // Send a HEAD request (faster than GET), with timeout of 5s
            $response = Http::timeout(5)->head($value);

            // Fall back to GET request if blocked
            if ($response->status() === 405) {
                $response = Http::get($value, ['stream' => true]);
            }

            if (!$response->successful()) {
                $fail("The {$attribute} URL is not reachable.");
                return;
            }

            $contentType = $response->header('Content-Type');

            // Check if the file advertises itself as an image
            if (!is_string($contentType) || !str_starts_with($contentType, 'image/')) {
                $fail("The {$attribute} must point to a valid image URL.");
                return;
            }

        } catch (\Exception $e) {
            $fail("The {$attribute} URL could not be verified.");
        }
    }
}
