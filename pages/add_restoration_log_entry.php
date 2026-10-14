<?php
require '../includes/auth_check.inc.php';
require '../includes/dbconnect.inc.php';
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($is_logged_in)) {
    $_SESSION['target_url'] = $_SERVER['REQUEST_URI'] ?? '/pages/restoration_pics.php';
    header('Location: /login.php'); exit;
}
$Link = mysqli_connect($Host, $User, $Password, $DBName);
if (!$Link) { http_response_code(500); exit('Database unavailable.'); }
mysqli_set_charset($Link, 'utf8mb4');
function e($v) { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function field($key, $default='') { return (string)($_POST[$key] ?? $default); }
function getrow($db, $sql, $types, ...$params) {
    $s = mysqli_prepare($db,$sql); if (!$s) return null;
    if ($params) mysqli_stmt_bind_param($s,$types,...$params);
    mysqli_stmt_execute($s); $r=mysqli_stmt_get_result($s);
    $v=$r?mysqli_fetch_assoc($r):null; mysqli_stmt_close($s); return $v;
}
function metadata_split($description) {
    $meta=['supplier'=>'','parts'=>'','problems'=>'','solutions'=>'','measurements'=>'','next_steps'=>'','resource_url'=>''];
    $pattern='~\\n?<!-- CR-JOURNAL-V1:(\\{.*?\\}) -->\\s*$~s';
    if (preg_match($pattern,$description,$m)) {
        $json=json_decode($m[1],true);
        if (is_array($json)) foreach ($meta as $k=>$v) if(isset($json[$k]) && is_string($json[$k])) $meta[$k]=$json[$k];
        $description=preg_replace($pattern,'',$description);
    }
    return [$description,$meta];
}
function metadata_join($description,$meta) {
    $data=[]; foreach (['supplier','parts','problems','solutions','measurements','next_steps','resource_url'] as $k) {
        $v=trim((string)($meta[$k]??'')); if ($v!=='') $data[$k]=$v;
    }
    if (!$data) return $description;
    return rtrim($description)."\n<!-- CR-JOURNAL-V1:".json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_HEX_TAG)." -->";
}
function display_form($heading,$action,$row,$meta,$errors,$csrf,$parent,$category,$edit_id=0) { ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=e($heading)?> | CycleRestorer</title>
<link rel="stylesheet" href="../css/cyclerestorer.css">
<style>
body{background:#f5f0e6;color:#352d22;font:17px/1.5 Arial,sans-serif;margin:0}main{max-width:820px;margin:22px auto;padding:22px;background:#fffdf8;border:1px solid #d8cbb7;border-radius:12px;box-sizing:border-box}
h1{font-size:1.65rem;margin:0 0 8px;color:#48321e}.hint{color:#635746;font-size:.94rem;margin:4px 0 18px}.fields{display:grid;grid-template-columns:1fr 1fr;gap:16px}.full{grid-column:1/-1}label{display:block;font-weight:700;margin-bottom:5px}input,textarea,select{width:100%;max-width:100%;box-sizing:border-box;padding:10px;border:1px solid #a99a85;border-radius:6px;background:white;color:#2d281f;font:inherit}textarea{min-height:90px}textarea.large{min-height:170px}section{margin-top:24px;padding-top:16px;border-top:1px solid #e5d8c6}h2{font-size:1.15rem;color:#513c28}button,.button{display:inline-block;padding:11px 17px;border-radius:6px;background:#675036;color:white;border:0;text-decoration:none;font:700 16px Arial,sans-serif;cursor:pointer}.button{background:#e9dfd0;color:#3a2c1f}.actions{display:flex;flex-wrap:wrap;gap:12px;margin-top:25px}.error{background:#fff0e8;border:1px solid #ad553e;padding:12px;border-radius:6px}small{display:block;font-weight:400;color:#645b50;margin-top:4px}@media(max-width:620px){main{margin:8px;padding:16px}.fields{grid-template-columns:1fr}.full{grid-column:1}h1{font-size:1.4rem}}
</style></head><body><main><h1><?=e($heading)?></h1><p class="hint">Keep a useful record of work completed. Only the title is required; everything else is optional.</p>
<?php if ($errors): ?><div class="error"><?=e(implode(' ', $errors))?></div><?php endif; ?>
<form method="post" action="<?=e($action)?>">
<input type="hidden" name="csrf" value="<?=e($csrf)?>"><input type="hidden" name="parent_id" value="<?=e($parent)?>"><input type="hidden" name="edit_id" value="<?=e($edit_id)?>">
<div class="fields"><div class="full"><label for="log_title">Log title *</label><input id="log_title" name="log_title" maxlength="255" required value="<?=e($row['log_title']??'')?>"></div>
<div class="full"><label for="description">Work performed / description</label><textarea class="large" id="description" name="description"><?=e($row['work_description']??'')?></textarea></div>
<div><label for="start">Work start date</label><input id="start" name="start_date" type="date" value="<?=e($row['work_start_date']??'')?>"></div>
<div><label for="end">Work end date</label><input id="end" name="end_date" type="date" value="<?=e($row['work_end_date']??'')?>"></div>
<div><label for="hours">Hours spent</label><input id="hours" name="hours" type="number" min="0" step="0.25" value="<?=e($row['hours_spent']??'')?>"></div>
<div><label for="cost">Cost ($)</label><input id="cost" name="cost" type="number" min="0" step="0.01" value="<?=e($row['cost']??'')?>"></div>
<div class="full"><label for="category">Entry type</label><select name="category" id="category"><option value="log" <?=$category==='log'?'selected':''?>>Restoration log</option><option value="todo" <?=$category==='todo'?'selected':''?>>To-do item</option></select></div></div>
<section><h2>Parts and suppliers</h2><div class="fields"><div><label for="supplier">Supplier / source</label><input id="supplier" name="supplier" value="<?=e($meta['supplier'])?>"></div><div><label for="parts">Parts obtained or used</label><input id="parts" name="parts" value="<?=e($meta['parts'])?>"></div><div class="full"><label for="resource_url">Supplier or resource link</label><input id="resource_url" name="resource_url" type="url" placeholder="https://" value="<?=e($meta['resource_url'])?>"></div></div></section>
<section><h2>Technical restoration notes</h2><div class="fields"><div class="full"><label for="problems">Problems encountered</label><textarea id="problems" name="problems"><?=e($meta['problems'])?></textarea></div><div class="full"><label for="solutions">Solutions / techniques</label><textarea id="solutions" name="solutions"><?=e($meta['solutions'])?></textarea></div><div class="full"><label for="measurements">Measurements / specifications</label><textarea id="measurements" name="measurements"><?=e($meta['measurements'])?></textarea></div><div class="full"><label for="next_steps">Next steps</label><textarea id="next_steps" name="next_steps"><?=e($meta['next_steps'])?></textarea></div></div></section>
<div class="actions"><button type="submit" name="save" value="1">Save entry</button><a class="button" href="restoration_pics.php?edit_row=<?=e($parent)?>">Cancel / return to restoration</a></div></form></main></body></html>
<?php }
function form_values() {
    $row=['log_title'=>trim(field('log_title')),'work_description'=>field('description'),'work_start_date'=>field('start_date'),'work_end_date'=>field('end_date'),'hours_spent'=>field('hours'),'cost'=>field('cost')];
    $meta=[];foreach(['supplier','parts','problems','solutions','measurements','next_steps','resource_url'] as $k) $meta[$k]=field($k);
    return [$row,$meta];
}
function validation_errors($row,$meta) {
    $errors=[]; if($row['log_title']==='')$errors[]='A log title is required.';
    foreach(['work_start_date','work_end_date'] as $k) if($row[$k]!=='' && !preg_match('/^\\d{4}-\\d{2}-\\d{2}$/',$row[$k]))$errors[]='Please enter valid dates.';
    foreach(['hours_spent','cost'] as $k) if($row[$k]!=='' && (!is_numeric($row[$k]) || (float)$row[$k]<0))$errors[]='Hours and cost must be positive numbers.';
    if($meta['resource_url']!=='' && (!filter_var($meta['resource_url'],FILTER_VALIDATE_URL) || !in_array(strtolower((string)parse_url($meta['resource_url'],PHP_URL_SCHEME)),['https','http'],true)))$errors[]='Supplier link must be an http or https URL.';
    return $errors;
}
function owner($db,$parent,$username) {
    return getrow($db,'SELECT row_ID FROM before_after WHERE row_ID=? AND username=?','is',$parent,$username)!==null;
}
$session_username=(string)($_SESSION['username'] ?? '');
if ($session_username==='') { http_response_code(403); exit('Your login session is missing a username.'); }
if (empty($_SESSION['restoration_csrf'])) $_SESSION['restoration_csrf']=bin2hex(random_bytes(24));
$csrf=$_SESSION['restoration_csrf'];
$parent=(int)($_POST['parent_id']??$_GET['bfore_aftr_row_id']??0);
$category=(string)($_POST['category']??$_GET['todo_or_log']??'log');
if(!in_array($category,['log','todo'],true))$category='log';
if($parent<1 || !owner($Link,$parent,$session_username)){http_response_code(403);exit('Restoration not found or access denied.');}
$row=['log_title'=>'','work_description'=>'','work_start_date'=>'','work_end_date'=>'','hours_spent'=>'','cost'=>''];
$meta=array_fill_keys(['supplier','parts','problems','solutions','measurements','next_steps','resource_url'],'');
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST') {
 if(!hash_equals($csrf,(string)($_POST['csrf']??''))) {http_response_code(403);exit('Form expired. Please reload.');}
 [$row,$meta]=form_values();$errors=validation_errors($row,$meta);
 if(!$errors){
 $description=metadata_join($row['work_description'],$meta);
 $start=$row['work_start_date']?:null;$end=$row['work_end_date']?:null;
 $hours=$row['hours_spent']!==''?(float)$row['hours_spent']:0.0;$cost=$row['cost']!==''?(float)$row['cost']:0.0;
 $stmt=mysqli_prepare($Link,'INSERT INTO tb_restoration_work (log_title,work_description,work_start_date,work_end_date,enter_date,hours_spent,username,before_after_row_id,cost,category) VALUES (?,?,?,?,NOW(),?,?,?,?,?)');
 if($stmt){mysqli_stmt_bind_param($stmt,'ssssdsids',$row['log_title'],$description,$start,$end,$hours,$session_username,$parent,$cost,$category);}
 if(!$stmt || !mysqli_stmt_execute($stmt))$errors[]='Unable to save this entry. Please try again.';
 else {header('Location: restoration_pics.php?edit_row='.$parent);exit;}
 }
}
display_form('Add Restoration Journal Entry','add_restoration_log_entry.php',$row,$meta,$errors,$csrf,$parent,$category);
