<?php
$dirs = [
    'c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/app/Livewire',
    'c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/resources/views'
];

$fixed = 0;

foreach ($dirs as $dir) {
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['php'])) {
            $content = file_get_contents($file);
            
            // Fix if !( -> if (!
            $newContent = preg_replace('/if\s*!\(/', 'if (!', $content);

            if ($newContent !== $content) {
                file_put_contents($file, $newContent);
                echo "Fixed syntax error in: " . $file->getPathname() . "\n";
                $fixed++;
            }
        }
    }
}

echo "Total syntax errors fixed: $fixed\n";
