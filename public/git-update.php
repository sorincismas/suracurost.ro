<?php
// =========================
// GitHub Webhook Auto Deploy
// Secure version with secret
// =========================

// --- CONFIG ---
$repoPath = '/volume1/web/www/suracurost.ro';
$secret   = 's3cr3tg1thu8';
$logFile  = '/tmp/git-webhook.log';

// --- VERIFY SIGNATURE ---
$payload = file_get_contents('php://input');
$headers = getallheaders();
$signature = $headers['X-Hub-Signature-256'] ?? '';

if (!$signature) {
    http_response_code(400);
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - Missing signature\n", FILE_APPEND);
    exit('Missing signature');
}

$expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);
if (!hash_equals($expected, $signature)) {
    http_response_code(403);
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - Invalid signature\n", FILE_APPEND);
    exit('Invalid signature');
}

// --- Inițializează variabilele Git ---
$outputFetch = [];
$outputReset = [];
$returnFetch = null;
$returnReset = null;

// --- Comenzi Git ---
exec("/bin/git -C $repoPath fetch --all 2>&1", $outputFetch, $returnFetch);
exec("/bin/git -C $repoPath reset --hard origin/main 2>&1", $outputReset, $returnReset);

// --- Log ---
$logMsg = date('Y-m-d H:i:s')
    . " - FETCH Return: $returnFetch\n" . implode("\n", $outputFetch) . "\n"
    . " - RESET Return: $returnReset\n" . implode("\n", $outputReset) . "\n\n";

file_put_contents($logFile, $logMsg, FILE_APPEND);

// --- Log eventuale erori PHP ---
$error = error_get_last();
if ($error) {
    file_put_contents($logFile, print_r($error, true), FILE_APPEND);
}

// --- Răspuns HTTP ---
if ($returnFetch === 0 && $returnReset === 0) {
    http_response_code(200);
    echo "OK";
} else {
    http_response_code(500);
    echo "Git pull failed";
}
?>
