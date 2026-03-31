<?php
/**
 * upload-image.php
 * Drive admin — image upload handler
 * Saves uploaded images into ./Pictures/
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Handle CORS preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    $errCode = $_FILES['image']['error'] ?? -1;
    $errMap  = [
        UPLOAD_ERR_INI_SIZE   => 'File exceeds server upload limit',
        UPLOAD_ERR_FORM_SIZE  => 'File exceeds form upload limit',
        UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
    ];
    $errMsg = $errMap[$errCode] ?? 'Upload error (code ' . $errCode . ')';
    echo json_encode(['success' => false, 'error' => $errMsg]);
    exit;
}

// Validate file type by MIME and extension
$allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
$allowedExts  = ['jpg', 'jpeg', 'png', 'webp'];

$finfo    = new finfo(FILEINFO_MIME_TYPE);
$mimeType = $finfo->file($_FILES['image']['tmp_name']);

if (!in_array($mimeType, $allowedMimes, true)) {
    echo json_encode(['success' => false, 'error' => 'Invalid file type. Allowed: jpg, jpeg, png, webp']);
    exit;
}

$originalName = $_FILES['image']['name'];
$ext          = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

if (!in_array($ext, $allowedExts, true)) {
    echo json_encode(['success' => false, 'error' => 'Invalid file extension. Allowed: jpg, jpeg, png, webp']);
    exit;
}

// Normalise jpeg → jpg
if ($ext === 'jpeg') $ext = 'jpg';

// Build safe unique filename
$date     = date('Ymd');
$uid      = substr(bin2hex(random_bytes(5)), 0, 8);
$filename = 'car_' . $date . '_' . $uid . '.' . $ext;

// Ensure Pictures/ folder exists
$targetDir = __DIR__ . '/Pictures/';
if (!is_dir($targetDir)) {
    if (!mkdir($targetDir, 0755, true)) {
        echo json_encode(['success' => false, 'error' => 'Could not create Pictures folder']);
        exit;
    }
}

$targetPath = $targetDir . $filename;

if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
    echo json_encode(['success' => false, 'error' => 'Failed to save file']);
    exit;
}

echo json_encode([
    'success' => true,
    'path'    => './Pictures/' . $filename,
]);
