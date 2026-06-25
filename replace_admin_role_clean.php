<?php
$dirs = [
    'c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/app/Livewire',
    'c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/resources/views'
];

$replaced = 0;

foreach ($dirs as $dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['php'])) {
            $content = file_get_contents($file);
            $newContent = $content;

            // Replace === 'admin'
            $newContent = preg_replace(
                '/(\$?[a-zA-Z0-9_\(\)\:\>\-]+)->role\s*===\s*\'admin\'/',
                '$1->hasAdminAccess()',
                $newContent
            );

            // Replace !== 'admin'
            $newContent = preg_replace(
                '/(\$?[a-zA-Z0-9_\(\)\:\>\-]+)->role\s*!==\s*\'admin\'/',
                '!$1->hasAdminAccess()',
                $newContent
            );

            if ($newContent !== $content) {
                file_put_contents($file, $newContent);
                echo "Updated: " . $file->getPathname() . "\n";
                $replaced++;
            }
        }
    }
}

echo "Total files updated to hasAdminAccess: $replaced\n";
