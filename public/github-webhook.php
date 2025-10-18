<?php
// Secretul setat în GitHub Webhook.
$secret = '8mKR2mOs9O';  // modifică după cum vrei

// Citește payloadul JSON trimis de GitHub
$payload = file_get_contents('php://input');
$headers = getallheaders();

// Verifică dacă e un push event
if (isset($headers['X-GitHub-Event']) && $headers['X-GitHub-Event'] === 'push') {
    $data = json_decode($payload, true);

    // Extrage numele branch-ului (ex: "main" sau "master")
    $branch = basename($data['ref']);

    if ($branch === 'main') {
        // Log pentru debugging (opțional)
        file_put_contents('/volume1/web/www/suracurost.ro/writable/logs/webhook.log', date('Y-m-d H:i:s') . " — push pe $branch\n", FILE_APPEND);

        // Execută actualizarea codului
        shell_exec('cd /volume1/web/www/suracurost.ro && GIT_SSH_COMMAND="ssh -i /volume1/web/.ssh/id_ed25519 -o StrictHostKeyChecking=no" git pull origin main 2>&1');
    }
}

http_response_code(200);
echo "OK";
?>
