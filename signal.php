<?php
// Skiff signaling for shared hosting (InfinityFree). Stores tiny JSON files in /rooms.
header('Content-Type: application/json');
header('Cache-Control: no-store');

$in   = json_decode(file_get_contents('php://input'), true) ?: [];
$room = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $in['room'] ?? ''));
$id   = preg_replace('/[^a-z0-9]/', '', $in['id'] ?? '');
$act  = $in['action'] ?? '';
if (strlen($room) < 3 || strlen($room) > 8 || strlen($id) < 4) { echo '{"error":"bad request"}'; exit; }

$dir = __DIR__ . '/rooms';
$file = "$dir/$room.json";

// remove rooms untouched for 10 minutes
foreach (glob("$dir/*.json") ?: [] as $f) if (filemtime($f) < time() - 600) @unlink($f);

$fh = fopen($file, 'c+');
flock($fh, LOCK_EX);
$raw = stream_get_contents($fh);
$st  = json_decode($raw, true) ?: ['peers' => [], 'q' => []];
$now = time();

// drop peers silent for 60s
foreach ($st['peers'] as $p => $t) if ($now - $t > 60) { unset($st['peers'][$p], $st['q'][$p]); }

$out = [];
if ($act === 'join') {
  if (!isset($st['peers'][$id]) && count($st['peers']) >= 2) {
    $out = ['type' => 'full'];
  } else {
    $st['peers'][$id] = $now; $st['q'][$id] = $st['q'][$id] ?? [];
    foreach ($st['peers'] as $p => $_) if ($p !== $id) $st['q'][$p][] = ['type' => 'peer-joined'];
    $out = ['type' => 'joined', 'peers' => count($st['peers'])];
  }
} elseif ($act === 'poll') {
  $st['peers'][$id] = $now;
  $out = ['msgs' => $st['q'][$id] ?? []];
  $st['q'][$id] = [];
} elseif ($act === 'send' && isset($in['msg']['type']) && in_array($in['msg']['type'], ['offer', 'answer', 'ice'])) {
  foreach ($st['peers'] as $p => $_) if ($p !== $id) $st['q'][$p][] = $in['msg'];
  $out = ['ok' => true];
} elseif ($act === 'leave') {
  unset($st['peers'][$id], $st['q'][$id]);
  foreach ($st['peers'] as $p => $_) $st['q'][$p][] = ['type' => 'peer-left'];
  $out = ['ok' => true];
}

ftruncate($fh, 0); rewind($fh);
fwrite($fh, json_encode($st));
fflush($fh); flock($fh, LOCK_UN); fclose($fh);
echo json_encode($out);
