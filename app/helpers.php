<?php

if (! function_exists('manifest_asset')) {
    function manifest_asset(string $path, string $manifestFile = 'public/js/manifest.json'): string
    {
        static $manifest = null;

        if ($manifest === null) {
            $manifestPath = base_path($manifestFile);
            if (! file_exists($manifestPath)) {
                throw new Exception("Manifest file not found: {$manifestPath}");
            }
            $manifest = json_decode(file_get_contents($manifestPath), true);
        }

        return $manifest[$path] ?? $path;
    }
}
