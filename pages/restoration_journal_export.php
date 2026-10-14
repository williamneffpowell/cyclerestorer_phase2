<?php
// CycleRestorer restoration journal export: CSV or printer-friendly HTML.
require '../includes/auth_check.inc.php';
require '../includes/dbconnect.inc.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$link = mysqli_connect($Host, $User, $Password, $DBName);
mysqli_set_charset($link, 'utf8mb4');
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) { http_response_code(400); exit('Invalid restoration ID.'); }
$format = ($_GET['format'] ?? 'print') === 'csv' ? 'csv' : 'print';
$stmt = mysqli_prepare($link, 'SELECT restoration_title, username FROM before_after WHERE row_id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$project = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
if (!$project) { http_response_code(404); exit('Restoration not found.'); }
$stmt = mysqli_prepare($link, "SELECT category, log_title, work_description, work_start_date, work_end_date, hours_spent, cost FROM tb_restoration_work WHERE before_after_row_id = ? AND category IN ('log','todo') ORDER BY work_start_date, work_end_date, row_ID");
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$rows = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);
$esc = static fn($v) => htmlspecialchars((string)($v ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$totalHours = 0.0; $totalCost = 0.0;
foreach ($rows as $r) { if ($r['category'] === 'log') { $totalHours += (float)$r['hours_spent']; $totalCost += (float)$r['cost']; } }
if ($format === 'csv') {
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="restoration-journal-' . $id . '.csv"');
    header('X-Content-Type-Options: nosniff');
    $f = fopen('php://output', 'w');
    fwrite($f, "\xEF\xBB\xBF");
    fputcsv($f, ['Restoration', 'Restorer', 'Category', 'Title', 'Description', 'Start Date', 'End Date', 'Hours', 'Cost']);
    foreach ($rows as $r) {
        $values = [$project['restoration_title'], $project['username'], $r['category'], $r['log_title'], $r['work_description'], $r['work_start_date'], $r['work_end_date'], $r['hours_spent'], $r['cost']];
        // Prevent spreadsheet formula execution when opening untrusted free-text cells.
        $values = array_map(static function($v) { $s=(string)($v??''); return preg_match('/^[\s\x00-\x1F]*[=+@\-]/u', $s) ? "'".$s : $s; }, $values);
        fputcsv($f, $values);
    }
    fclose($f); exit;
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Restoration Journal — <?= $esc($project['restoration_title']) ?></title>
<style>
*{box-sizing:border-box}body{font:17px/1.5 Arial,sans-serif;background:#f4eddd;color:#30271e;margin:0}.wrap{max-width:950px;margin:25px auto;padding:22px;background:#fffdf7;border:1px solid #c9bba7;border-radius:10px}h1{margin:.2em 0;color:#633b27}h2{font-size:21px;margin:0 0 10px}.meta{color:#594b3e}.totals{display:flex;gap:15px;flex-wrap:wrap;margin:22px 0}.totals div{background:#f4eddd;padding:12px 18px;border-radius:8px}.entry{padding:18px 0;border-top:1px solid #d7cbb8;break-inside:avoid}.entry p{white-space:pre-wrap;overflow-wrap:anywhere}.entry-head{display:flex;justify-content:space-between;gap:15px;flex-wrap:wrap}.small{font-size:15px;color:#594b3e}.actions{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:18px}.actions a,.actions button{font:inherit;padding:10px 14px;border:0;border-radius:6px;background:#634934;color:white;text-decoration:none;cursor:pointer}@media print{body{background:white}.wrap{border:0;margin:0;max-width:none;padding:0}.actions{display:none}.entry{break-inside:avoid}}@media(max-width:600px){.wrap{margin:0;padding:15px;border-radius:0}}
</style></head><body><main class="wrap">
<nav class="actions"><a href="restoration_pics.php?edit_row=<?= $id ?>">← Back to Restoration</a><a href="restoration_journal_export.php?id=<?= $id ?>&amp;format=csv">Download CSV</a><button type="button" onclick="window.print()">Print / Save PDF</button></nav>
<div class="small">CYCLERESTORER · RESTORATION JOURNAL</div>
<h1><?= $esc($project['restoration_title']) ?></h1><div class="meta">Presented by <?= $esc($project['username']) ?></div>
<div class="totals"><div><strong><?= count(array_filter($rows, static fn($r) => $r['category']==='log')) ?></strong> log entries</div><div><strong><?= number_format($totalHours, 1) ?></strong> hours logged</div><div><strong>$<?= number_format($totalCost, 2) ?></strong> logged costs</div></div>
<?php if (!$rows): ?><p>No restoration journal entries have been recorded yet.</p><?php endif; ?>
<?php foreach ($rows as $r): ?>
<section class="entry"><div class="entry-head"><div><div class="small"><?= $esc(strtoupper($r['category'])) ?> · <?= $esc($r['work_start_date']) ?><?php if ($r['work_end_date'] && $r['work_end_date'] !== $r['work_start_date']): ?> – <?= $esc($r['work_end_date']) ?><?php endif; ?></div><h2><?= $esc($r['log_title']) ?></h2></div><div class="small"><?= number_format((float)$r['hours_spent'], 1) ?> hours · $<?= number_format((float)$r['cost'], 2) ?></div></div>
<?php if (trim((string)$r['work_description']) !== ''): ?><p><?= $esc($r['work_description']) ?></p><?php endif; ?></section>
<?php endforeach; ?>
<p class="small">Totals above cover completed log entries only; to-do entries are listed separately and are not included in totals. Costs reflect amounts recorded in the restoration work log, not the separate parts ledger.</p>
</main></body></html>
