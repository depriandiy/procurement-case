<?php

namespace App\Support;

use Illuminate\Support\Str;

class SupplierIdentityNormalizer
{
    public function companyName(string $value): string
    {
        $normalized = preg_replace('/[^\pL\pN]+/u', ' ', Str::lower(trim($value))) ?? '';

        return preg_replace('/\s+/u', ' ', trim($normalized)) ?? '';
    }

    public function taxId(?string $value): ?string
    {
        return $this->digitsOrNull($value);
    }

    public function email(?string $value): ?string
    {
        $normalized = Str::lower(trim((string) $value));

        return $normalized === '' ? null : $normalized;
    }

    public function phone(?string $value): ?string
    {
        return $this->digitsOrNull($value);
    }

    private function digitsOrNull(?string $value): ?string
    {
        $normalized = preg_replace('/\D+/', '', (string) $value) ?? '';

        return $normalized === '' ? null : $normalized;
    }
}
