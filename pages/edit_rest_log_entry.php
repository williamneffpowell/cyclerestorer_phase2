<?php
require '../includes/auth_check.inc.php';
require '../includes/dbconnect.inc.php';
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
if (empty($is_logged_in) || empty($_SESSION['username'])) {
    $_SESSION['target_url'] = $_SERVER['REQUEST_URI'] ?? '/pages/restoration_pics.php';
    header('Location: /login.php'); exit;
}
$username = (string)$_SESSION['username'];
$Link = mysqli_connect($Host, $User, $Password, $DBName);
if (!$Link) { http_response_code(500); exit('Database connection failed.'); }
mysqli_set_charset($Link, 'utf8mb4');
function esc($v) { return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function validDate($v) {
    if ($v === '' || $v === '0000-00-00') return true;
    $d = DateTimeImmutable::createFromFormat('!Y-m-d', $v);
    return $d && $d->format('Y-m-d') === $v;
}
function extractDetails($description, &$details) {
    $details = array_fill_keys(['supplier','parts','problems','solutions','measurements','next_steps'], '');
    if (preg_match('~<!-- CR_JOURNAL_DETAILS_START -->(.*?)<!-- CR_JOURNAL_DETAILS_END -->~s', $description, $m)) {
        foreach ($details as $key => $_) {
            if (preg_match('~<p data-cr-field="'.preg_quote($key, '~').'"><strong>.*?</strong>\\s*(.*?)</p>~s', $m[1], $hit)) {
                $details[$key] = html_entity_decode(strip_tags($hit[1]), ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
        }
        $description = trim(str_replace($m[0], '', $description));
    }
    return $description;
}
function composeDescription($description, $details) {
    $labels = ['supplier'=>'Supplier / source', 'parts'=>'Parts used', 'problems'=>'Problems encountered', 'solutions'=>'Solutions / techniques', 'measurements'=>'Measurements / specifications', 'next_steps'=>'Next steps'];
    $extra = '';
    foreach ($labels as $key => $label) {
        $value = trim((string)($details[$key] ?? ''));
        if ($value !== '') {
            $extra .= '<p data-cr-field="'.$key.'"><strong>'.$label.':</strong> '.nl2br(esc($value)).'</p>' . "\n";
        }
    }
    return $description . ($extra === '' ? '' : "\n<!-- CR_JOURNAL_DETAILS_START -->\n".$extra."<!-- CR_JOURNAL_DETAILS_END -->");
}
function validateEntry($data) {
    if (trim($data['title']) === '') return 'Please enter a log title.';
    if (!validDate($data['start']) || !validDate($data['end'])) return 'Use YYYY-MM-DD for dates.';
    foreach (['hours','cost'] as $field) {
        if ($data[$field] !== '' && (!is_numeric($data[$field]) || (float)$data[$field] < 0)) return 'Hours and cost must be positive numbers.';
    }
    if (!in_array($data['category'], ['log','todo'], true)) return 'Invalid entry type.';
    return '';
}
function submittedData($fallback) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return $fallback;
    $data = ['title'=>trim((string)($_POST['log_title_fd'] ?? '')),
      'description'=>(string)($_POST['description_fd'] ?? ''),
      'start'=>trim((string)($_POST['start_date_fd'] ?? '')),
      'end'=>trim((string)($_POST['end_date_fd'] ?? '')),
      'hours'=>trim((string)($_POST['hours_spent_fd'] ?? '')),
      'cost'=>trim((string)($_POST['cost_fd'] ?? '')),
      'category'=>(string)($_POST['todo_or_log'] ?? 'log'), 'details'=>[]];
    foreach (['supplier','parts','problems','solutions','measurements','next_steps'] as $key) {
        $data['details'][$key] = trim((string)($_POST[$key] ?? ''));
    }
    return $data;
}
function renderForm($data, $mode, $error, $id, $projectId) {
    $isEdit = $mode === 'edit';
    $title = $isEdit ? 'Edit Restoration Journal Entry' : 'Add Restoration Journal Entry';
    $action = $isEdit ? 'edit_rest_log_entry.php?edit_row='.rawurlencode((string)$id) : 'add_restoration_log_entry.php?bfore_aftr_row_id='.rawurlencode((string)$projectId).'&todo_or_log='.rawurlencode($data['category']);
    $labels = ['supplier'=>'Supplier / source (name, URL, or resource reference)', 'parts'=>'Parts used or purchased', 'problems'=>'Problems encountered', 'solutions'=>'Solutions / techniques', 'measurements'=>'Measurements / specifications', 'next_steps'=>'Next steps'];
    ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= esc($title) ?> | CycleRestorer</title>
<style>
body{margin:0;background:#f6f1e7;color:#30271e;font:17px/1.5 Arial,Helvetica,sans-serif}main{max-width:820px;margin:24px auto;padding:0 16px 40px}h1{font-size:1.8rem;margin-bottom:8px}h2{font-size:1.2rem;margin:8px 0 14px}p.hint{color:#615447;margin:0 0 20px}.panel{background:#fffdf8;border:1px solid #d5c8b7;border-radius:12px;padding:22px;margin:16px 0;box-shadow:0 1px 3px #0000000b}label{display:block;font-weight:700;margin:14px 0 6px}input,textarea,select{display:block;box-sizing:border-box;width:100%;font:inherit;padding:10px 12px;border:1px solid #a99b88;border-radius:6px;background:white;color:#28221d}textarea{min-height:100px;resize:vertical}textarea.large{min-height:190px}.fields{display:grid;grid-template-columns:1fr 1fr;gap:0 18px}.actions{display:flex;flex-wrap:wrap;gap:12px;align-items:center;margin-top:20px}.button{display:inline-block;border:0;border-radius:7px;background:#654b34;color:#fff;padding:11px 18px;text-decoration:none;font:700 16px Arial;cursor:pointer}.secondary{background:#e5d9c8;color:#2c231b}.danger{background:#9b3434}.alert{background:#fff0ed;border:1px solid #bd5544;padding:12px;border-radius:7px}small{color:#65584a}input:focus,textarea:focus,select:focus{outline:2px solid #85643d;outline-offset:1px}@media(max-width:600px){.fields{grid-template-columns:1fr}.panel{padding:16px}main{margin-top:12px}h1{font-size:1.5rem}}
</style></head><body><main><h1><?= esc($title) ?></h1><p class="hint">Keep a useful history of the work done on this motorcycle. Extra technical fields are optional.</p>
<?php if ($error !== ''): ?><p class="alert" role="alert"><?= esc($error) ?></p><?php endif; ?>
<form action="<?= esc($action) ?>" method="post">
<input type="hidden" name="csrf" value="<?= esc($_SESSION['cr_rest_journal_csrf']) ?>">
<section class="panel"><h2>Work performed</h2>
<label for="title">Entry title *</label><input required maxlength="255" id="title" name="log_title_fd" value="<?= esc($data['title']) ?>">
<label for="description">Work description</label><textarea class="large" id="description" name="description_fd"><?= esc($data['description']) ?></textarea>
<div class="fields"><div><label for="start">Work start date</label><input id="start" type="date" name="start_date_fd" value="<?= esc($data['start'] === '0000-00-00' ? '' : $data['start']) ?>"></div><div><label for="end">Work end date</label><input id="end" type="date" name="end_date_fd" value="<?= esc($data['end'] === '0000-00-00' ? '' : $data['end']) ?>"></div><div><label for="hours">Hours spent</label><input id="hours" type="number" step="0.01" min="0" name="hours_spent_fd" value="<?= esc($data['hours']) ?>"></div><div><label for="cost">Cost ($)</label><input id="cost" type="number" step="0.01" min="0" name="cost_fd" value="<?= esc($data['cost']) ?>"></div></div>
<label for="category">Entry type</label><select id="category" name="todo_or_log"><option value="log" <?= $data['category']==='log'?'selected':'' ?>>Restoration log</option><option value="todo" <?= $data['category']==='todo'?'selected':'' ?>>To do</option></select>
</section><section class="panel"><h2>Parts and technical reference</h2><p class="hint">Use these fields to help yourself and other restorers later. Supplier URLs can be recorded here; direct links to the resource directory can be added in a later update.</p>
<?php foreach ($labels as $key=>$label): ?><label for="<?= esc($key) ?>"><?= esc($label) ?></label><textarea id="<?= esc($key) ?>" rows="2" name="<?= esc($key) ?>"><?= esc($data['details'][$key] ?? '') ?></textarea><?php endforeach; ?>
</section><div class="actions"><button class="button" type="submit" name="action" value="save"><?= $isEdit ? 'Save changes' : 'Add entry' ?></button><a class="button secondary" href="restoration_pics.php?edit_row=<?= (int)$projectId ?>">Cancel / Back to restoration</a><?php if($isEdit): ?><button class="button danger" type="submit" name="action" value="delete" formnovalidate onclick="return confirm('Delete this entry permanently?')">Delete entry</button><?php endif; ?></div></form>
</main></body></html>
<?php }
if (empty($_SESSION['cr_rest_journal_csrf'])) { $_SESSION['cr_rest_journal_csrf'] = bin2hex(random_bytes(24)); }
function checkCsrf() { return isset($_POST['csrf']) && hash_equals($_SESSION['cr_rest_journal_csrf'], (string)$_POST['csrf']); }
function goBack($projectId) { header('Location: restoration_pics.php?edit_row='.(int)$projectId); exit; }

$id = filter_var($_GET['edit_row'] ?? $_POST['edit_row'] ?? 0, FILTER_VALIDATE_INT);
if (!$id || $id < 1) { http_response_code(400); exit('Invalid journal entry ID.'); }
$stmt = mysqli_prepare($Link, 'SELECT r.before_after_row_id, r.log_title, r.work_description, r.work_start_date, r.work_end_date, r.hours_spent, r.cost, r.category, r.username, b.username FROM tb_restoration_work r INNER JOIN before_after b ON b.row_ID = r.before_after_row_id WHERE r.row_ID = ? LIMIT 1');
mysqli_stmt_bind_param($stmt, 'i', $id); mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $projectId, $title, $description, $start, $end, $hours, $cost, $category, $entryOwner, $projectOwner);
$found = mysqli_stmt_fetch($stmt); mysqli_stmt_close($stmt);
if (!$found) { http_response_code(404); exit('Journal entry not found.'); }
if (strcasecmp((string)$projectOwner, $username) !== 0 || strcasecmp((string)$entryOwner, $username) !== 0) { http_response_code(403); exit('You cannot edit this entry.'); }
$description = extractDetails((string)$description, $details);
$initial = ['title'=>$title,'description'=>$description,'start'=>(string)$start,'end'=>(string)$end,'hours'=>(string)$hours,'cost'=>(string)$cost,'category'=>$category,'details'=>$details];
$data = submittedData($initial); $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!checkCsrf()) { http_response_code(403); exit('Your form session expired. Reload the form and try again.'); }
    if (($_POST['action'] ?? '') === 'delete') {
        $stmt = mysqli_prepare($Link, 'DELETE FROM tb_restoration_work WHERE row_ID = ? AND username = ?');
        mysqli_stmt_bind_param($stmt, 'is', $id, $username);
        if (mysqli_stmt_execute($stmt)) { mysqli_stmt_close($stmt); goBack($projectId); }
        $error = 'Unable to delete this entry.'; mysqli_stmt_close($stmt);
    } else {
        $error = validateEntry($data);
        if ($error === '') {
            $newDescription = composeDescription($data['description'], $data['details']);
            $hoursValue = $data['hours'] === '' ? 0.0 : (float)$data['hours'];
            $costValue = $data['cost'] === '' ? 0.0 : (float)$data['cost'];
            $stmt = mysqli_prepare($Link, 'UPDATE tb_restoration_work SET log_title=?,work_description=?,work_start_date=NULLIF(?,\'\'),work_end_date=NULLIF(?,\'\'),hours_spent=?,cost=?,category=? WHERE row_ID=? AND username=?');
            mysqli_stmt_bind_param($stmt, 'ssssddsis', $data['title'], $newDescription, $data['start'], $data['end'], $hoursValue, $costValue, $data['category'], $id, $username);
            if (mysqli_stmt_execute($stmt)) { mysqli_stmt_close($stmt); goBack($projectId); }
            $error = 'Unable to save the changes.'; mysqli_stmt_close($stmt);
        }
    }
}
renderForm($data, 'edit', $error, $id, $projectId);
