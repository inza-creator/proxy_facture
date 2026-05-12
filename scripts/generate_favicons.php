<?php

/**
 * Génère des favicons carrés à partir du logo horizontal (icône à gauche + rognage des marges).
 * Usage : php scripts/generate_favicons.php
 */

$src = dirname(__DIR__).'/public/image.png';
if (! is_file($src)) {
    fwrite(STDERR, "Fichier introuvable: $src\n");
    exit(1);
}

$im = imagecreatefrompng($src);
if ($im === false) {
    fwrite(STDERR, "Impossible de lire l'image.\n");
    exit(1);
}

$w = imagesx($im);
$h = imagesy($im);

$size = (int) min($h, $w * 0.4);
$y = (int) (($h - $size) / 2);
$cropped = imagecrop($im, ['x' => 0, 'y' => $y, 'width' => $size, 'height' => $size]);
imagedestroy($im);

if ($cropped === false) {
    fwrite(STDERR, "Échec du recadrage.\n");
    exit(1);
}

$tight = trimNearWhite($cropped);
imagedestroy($cropped);
if ($tight === false) {
    fwrite(STDERR, "Échec du rognage.\n");
    exit(1);
}

$square = centerInSquare($tight, 0.06);
imagedestroy($tight);
if ($square === false) {
    fwrite(STDERR, "Échec du placement carré.\n");
    exit(1);
}

$side = imagesx($square);

$public = dirname(__DIR__).'/public';
$sizes = [
    16 => 'favicon-16x16.png',
    32 => 'favicon-32x32.png',
    48 => 'favicon-48x48.png',
    96 => 'favicon-96x96.png',
    180 => 'apple-touch-icon.png',
];

foreach ($sizes as $dim => $filename) {
    $out = imagecreatetruecolor($dim, $dim);
    imagealphablending($out, false);
    imagesavealpha($out, true);
    $transparent = imagecolorallocatealpha($out, 0, 0, 0, 127);
    imagefill($out, 0, 0, $transparent);
    imagecopyresampled($out, $square, 0, 0, 0, 0, $dim, $dim, $side, $side);
    $path = "$public/$filename";
    imagesavealpha($out, true);
    imagepng($out, $path, 9);
    imagedestroy($out);
    echo "Écrit: $path\n";
}

imagedestroy($square);

copy("$public/favicon-32x32.png", "$public/favicon.ico");

echo "Terminé.\n";

/**
 * Supprime les marges quasi blanches autour du graphisme.
 */
function trimNearWhite(\GdImage $img, int $threshold = 248): \GdImage|false
{
    $w = imagesx($img);
    $h = imagesy($img);
    $minX = $w;
    $minY = $h;
    $maxX = 0;
    $maxY = 0;

    for ($y = 0; $y < $h; $y++) {
        for ($x = 0; $x < $w; $x++) {
            $c = imagecolorat($img, $x, $y);
            $a = ($c >> 24) & 0x7F;
            $r = ($c >> 16) & 0xFF;
            $g = ($c >> 8) & 0xFF;
            $b = $c & 0xFF;
            if ($a > 100) {
                continue;
            }
            if ($r >= $threshold && $g >= $threshold && $b >= $threshold) {
                continue;
            }
            $minX = min($minX, $x);
            $minY = min($minY, $y);
            $maxX = max($maxX, $x);
            $maxY = max($maxY, $y);
        }
    }

    if ($maxX < $minX) {
        return imagecrop($img, ['x' => 0, 'y' => 0, 'width' => $w, 'height' => $h]);
    }

    return imagecrop($img, [
        'x' => $minX,
        'y' => $minY,
        'width' => $maxX - $minX + 1,
        'height' => $maxY - $minY + 1,
    ]);
}

/**
 * Centre l'image dans un carré avec marge relative (ex. 0.06 = 6 % de chaque côté).
 * Fond entièrement transparent pour les favicons (pas de bloc blanc dans l’onglet).
 */
function centerInSquare(\GdImage $img, float $marginRatio): \GdImage|false
{
    $iw = imagesx($img);
    $ih = imagesy($img);
    $inner = (int) round(max($iw, $ih) * (1 + 2 * $marginRatio));
    $side = max($inner, max($iw, $ih));

    $canvas = imagecreatetruecolor($side, $side);
    imagealphablending($canvas, false);
    imagesavealpha($canvas, true);
    $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
    imagefill($canvas, 0, 0, $transparent);
    imagealphablending($canvas, true);

    $ox = (int) (($side - $iw) / 2);
    $oy = (int) (($side - $ih) / 2);
    imagecopy($canvas, $img, $ox, $oy, 0, 0, $iw, $ih);

    imagealphablending($canvas, false);
    imagesavealpha($canvas, true);

    return $canvas;
}
