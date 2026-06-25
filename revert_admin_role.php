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

            // Revert in_array(..., ['admin', 'outsourcing'])
            $newContent = preg_replace(
                '/in_array\((.*?),\s*\[\'admin\',\s*\'outsourcing\'\]\)/',
                '$1 === \'admin\'',
                $newContent
            );

            // Revert !in_array(..., ['admin', 'outsourcing'])
            $newContent = preg_replace(
                '/!in_array\((.*?),\s*\[\'admin\',\s*\'outsourcing\'\]\)/',
                '$1 !== \'admin\'',
                $newContent
            );

            if ($newContent !== $content) {
                file_put_contents($file, $newContent);
                echo "Reverted: " . $file->getPathname() . "\n";
                $replaced++;
            }
        }
    }
}

echo "Total files reverted: $replaced\n";
