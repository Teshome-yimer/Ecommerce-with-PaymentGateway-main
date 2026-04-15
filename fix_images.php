<?php
$pdo = new PDO('mysql:host=caboose.proxy.rlwy.net;port=41953;dbname=railway','root','FFDnZBqODIuQmSgSCSLNjFiXWPGzKJhl');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Map product slugs to real online images
$images = [
    'samsung-galaxy-s24' => '["https://images.unsplash.com/photo-1610945415295-d9bbf067e59c?w=600&q=80"]',
    'iphone-15-pro'      => '["https://images.unsplash.com/photo-1695048133142-1a20484d2569?w=600&q=80"]',
    'nike-air-max-270'   => '["https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80"]',
    'adidas-ultraboost-22' => '["https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=600&q=80"]',
    'sony-wh-1000xm5'   => '["https://images.unsplash.com/photo-1618366712010-f4ae9c647dcb?w=600&q=80"]',
    'samsung-galax'      => '["https://images.unsplash.com/photo-1610945264803-c22b62d2a7b3?w=600&q=80"]',
    'cloth'              => '["https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=600&q=80"]',
];

foreach ($images as $slug => $imgJson) {
    $stmt = $pdo->prepare("UPDATE products SET images=? WHERE slug=?");
    $stmt->execute([$imgJson, $slug]);
    echo "Updated: $slug\n";
}
echo "\nDone! All product images updated to online URLs.\n";
