<?php
$dir = new RecursiveDirectoryIterator('c:/Users/Pagina-Web1/Desktop/Suraki_HelpDesk/app/Livewire');
$iterator = new RecursiveIteratorIterator($dir);
foreach ($iterator as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $content = file_get_contents($file);
        $newContent = preg_replace('/session\(\)->flash\(\s*\'message\'\s*,\s*(.*?)\s*\);/', '$this->dispatch(\'notify\', message: $1); session()->flash(\'message\', $1);', $content);
        if ($newContent !== $content) {
            file_put_contents($file, $newContent);
            echo "Updated " . $file->getPathname() . "\n";
        }
    }
}
echo "Done.\n";
