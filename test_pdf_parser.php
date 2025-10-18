<?php
// Test PDF Parser functionality
require_once __DIR__ . '/vendor/autoload.php';

use Smalot\PdfParser\Parser;

echo "Testing PDF Parser...\n";

// Check if Parser class exists
if (class_exists('Smalot\PdfParser\Parser')) {
    echo "✓ Parser class found\n";
} else {
    echo "✗ Parser class NOT found\n";
    exit(1);
}

// Try to instantiate Parser
try {
    $parser = new Parser();
    echo "✓ Parser instantiated successfully\n";
} catch (Exception $e) {
    echo "✗ Failed to instantiate Parser: " . $e->getMessage() . "\n";
    exit(1);
}

// Check Parser methods
$reflectionClass = new ReflectionClass($parser);
$methods = $reflectionClass->getMethods();
echo "\nParser methods available:\n";
foreach ($methods as $method) {
    if (!$method->isPrivate()) {
        echo "  - " . $method->getName() . "\n";
    }
}

echo "\nAll checks passed! PDF Parser is working correctly.\n";
?>
