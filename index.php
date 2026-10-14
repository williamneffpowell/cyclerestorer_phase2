<?php
// index.php on cyclerestorer.com




require 'includes/auth_check.inc.php';

// ---- Visitor counter (speedometer reading) ----
include 'includes/dbconnect.inc.php';
require_once __DIR__ . '/includes/track_visit.inc.php';
$Link = mysqli_connect($Host, $User, $Password, $DBName);

$num = '0';
$query = 'SELECT `count` FROM `simplecount`';
$result = mysqli_query($Link, $query);
if ($result) {
    $row = mysqli_fetch_row($result);
    if ($row) {
        $num = $row[0];
    }
} else {
    error_log('Visitor counter query failed: ' . mysqli_error($Link));
}

// Map each digit of $num to its digit image (0.jpg - 9.jpg), most significant first.
$digit_images = [];
foreach (str_split((string)$num) as $digit) {
    $digit_images[] = $digit . '.jpg';
}

mysqli_close($Link);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="iso-8859-1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="verify-v1" content="6xbzK+VQ5IjySCWXF1cUK46EcH3+yHF6/NXSwkqPdAM=">
<title>Cyclerestorer.com &mdash; A Site for the Motorcycle Restorer</title>
<link href="css/cyclerestorer.css" rel="stylesheet" type="text/css">
<style>
*{box-sizing:border-box}
body{margin:0;font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:1.45}
.cr-home{width:min(1100px,calc(100% - 24px));margin:0 auto;padding:18px 0 36px}
.cr-masthead{text-align:center;padding:20px 16px;margin-bottom:18px;background:#f4ead7;border:3px solid #4b3827;border-radius:12px}
.cr-masthead h1{margin:0;font-family:Georgia,"Times New Roman",serif;font-size:clamp(34px,7vw,62px);line-height:1;color:#3c291d;text-shadow:none}
.cr-masthead p{max-width:760px;margin:12px auto 0;color:#49392d;font-size:clamp(18px,3vw,22px);font-weight:bold;text-shadow:none}
.cr-feature{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(260px,.65fr);gap:20px;align-items:stretch;margin:18px 0 26px}
.cr-photo,.cr-speedo-panel,.cr-section{background:#f4ead7;border:3px solid #4b3827;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.25)}
.cr-photo{overflow:hidden;position:relative;min-height:330px}
.cr-photo img{display:block;width:100%;height:100%;min-height:330px;object-fit:cover}
.cr-photo-caption{position:absolute;left:0;right:0;bottom:0;padding:13px 16px;background:rgba(0,0,0,.72);color:#fff;font-weight:bold}
.cr-speedo-panel{padding:18px;text-align:center;display:flex;flex-direction:column;justify-content:center}
.cr-speedo-panel h2{font-family:Georgia,"Times New Roman",serif;margin:0 0 10px;color:#3c291d}
.cr-speedo-face{max-width:220px;width:80%;height:auto;margin:0 auto 10px}
.cr-digits{display:flex;justify-content:center;gap:1px;flex-wrap:nowrap;margin:4px auto 8px}
.cr-digits img{height:34px;width:auto}
.cr-speedo-label{font-size:16px;color:#4b3827;font-weight:bold}
.cr-section{padding:20px;margin:0 0 22px}
.cr-section h2{font-family:Georgia,"Times New Roman",serif;text-align:center;margin:0 0 8px;color:#3c291d;font-size:30px}
.cr-section-intro{text-align:center;margin:0 auto 18px;max-width:780px;color:#49392d}
.cr-links{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
.cr-link{display:grid;grid-template-columns:74px 1fr;gap:13px;align-items:center;padding:12px;background:#fffaf0;border:2px solid #8a6b49;border-radius:9px;color:#251a13;text-decoration:none;min-height:96px}
.cr-link:hover,.cr-link:focus{background:#fff3d7;transform:translateY(-1px)}
.cr-link img{width:74px;height:68px;object-fit:cover;border:1px solid #6c5137;border-radius:5px;background:#ddd}
.cr-link h3{margin:0 0 3px;font-family:Georgia,"Times New Roman",serif;font-size:21px;color:#6f1d1b}
.cr-link p{margin:0;font-size:16px;line-height:1.3}
.cr-quick{display:flex;justify-content:center;gap:12px;flex-wrap:wrap;margin-top:18px}
.cr-button{display:inline-block;padding:11px 16px;border:2px solid #4b3827;border-radius:8px;background:#6f1d1b;color:#fff;text-decoration:none;font-weight:bold}
.cr-button.secondary{background:#f7e8c9;color:#3b2a1e}
.cr-note{margin-top:14px;text-align:center;font-size:16px;color:#49392d}
@media(max-width:760px){
 .cr-feature{grid-template-columns:1fr}
 .cr-photo{min-height:240px}.cr-photo img{min-height:240px}
 .cr-links{grid-template-columns:1fr}
 .cr-link{grid-template-columns:64px 1fr}.cr-link img{width:64px;height:60px}
}

/* Homepage prototype v2: simplify the shared nav brand and keep its links readable. */
.cr-nav{width:100%;background:#f4ead7;border-bottom:3px solid #4b3827}
.cr-nav-inner{width:min(1100px,calc(100% - 24px));margin:0 auto;padding:10px 0;display:flex;align-items:center;gap:18px;flex-wrap:wrap}
.cr-brand{font-family:Georgia,"Times New Roman",serif;font-size:22px;font-weight:bold;color:#3c291d;text-decoration:none;white-space:nowrap}
.cr-brand img{display:none!important}
.cr-nav-links,.cr-nav-account{display:flex;gap:12px;align-items:center;flex-wrap:wrap}
.cr-nav-links{flex:1}
.cr-nav a{color:#4f1b19}
.cr-nav-account{font-size:16px}
.cr-speedo-instrument{display:flex;flex-direction:column;align-items:center}
.cr-odometer-label{margin-top:4px;font-size:13px;letter-spacing:1.5px;font-weight:bold;color:#3c291d}
.cr-digits{padding:5px 7px;background:#171717;border:3px solid #8b6b38;border-radius:5px;box-shadow:inset 0 0 4px #000;margin:5px auto 10px}
.cr-digits img{display:block;height:38px;width:auto}
.cr-speedo-label{font-size:17px;color:#3c291d;font-weight:bold;line-height:1.35}
@media(max-width:760px){
 .cr-nav-inner{align-items:flex-start}
 .cr-brand{width:100%}
 .cr-nav-links,.cr-nav-account{gap:9px;font-size:16px}
}


/* V3: put the original odometer digits back into the speedometer window. */
.cr-speedo-instrument{
    position:relative;
    width:min(220px,80%);
    margin:0 auto 12px;
}
.cr-speedo-instrument .cr-speedo-face{
    display:block;
    width:100%;
    max-width:none;
    margin:0;
    height:auto;
}
.cr-digits-in-speedo{
    position:absolute;
    left:50%;
    top:64%;
    transform:translate(-50%,-50%);
    width:31%;
    height:8.5%;
    margin:0;
    padding:1px 2px;
    gap:0;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    background:#111;
    border:0;
    border-radius:1px;
    box-shadow:none;
}
.cr-digits-in-speedo img{
    display:block;
    height:100%;
    min-width:0;
    width:auto;
    flex:0 1 auto;
}

.cr-simple-footer{width:min(1100px,calc(100% - 24px));margin:0 auto 28px;padding:15px;text-align:center;background:#f4ead7;border:2px solid #4b3827;border-radius:9px;color:#3c291d;font-size:16px}.cr-simple-footer a{color:#6f1d1b;font-weight:bold}.cr-simple-footer span,.cr-simple-footer a{margin:0 4px}@media(max-width:520px){.cr-simple-footer span,.cr-simple-footer a{display:block;margin:5px 0}.cr-simple-footer span[aria-hidden=true]{display:none}}
</style>
</head>
<body>
<?php include 'includes/site_nav.inc.php'; ?>

<main class="cr-home">
    <header class="cr-masthead">
        <h1>CycleRestorer</h1>
        <p>A site for people who restore old motorcycles, share what they learn, and help keep these machines on the road.</p>
    </header>

    <section class="cr-feature">
        <div class="cr-photo">
            <img src="image_upload/rotate.php" alt="Motorcycle restoration shared by a CycleRestorer member">
            <div class="cr-photo-caption">Motorcycle restoration &mdash; shared by CycleRestorer members</div>
        </div>

        <aside class="cr-speedo-panel">
            <h2>Visitors on the Clock</h2>
            <div class="cr-speedo-instrument" aria-label="<?php echo htmlspecialchars((string)$num); ?> visits">
                <img class="cr-speedo-face" src="Images/cl77speedo.jpg" alt="Vintage motorcycle speedometer">
                <div class="cr-digits cr-digits-in-speedo">
                    <?php foreach ($digit_images as $img): ?>
                        <img src="<?php echo htmlspecialchars($img); ?>" alt="">
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="cr-speedo-label"><?php echo number_format((int)$num); ?> visits to CycleRestorer &mdash; on the clock since day one</div>
        </aside>
    </section>

    <section class="cr-section">
        <h2>Motorcycle Restoration</h2>
        <p class="cr-section-intro">Start with the part of the site you need. The old CycleRestorer character stays &mdash; we're just making it easier to use on today's computers and phones.</p>

        <div class="cr-links">
            <a class="cr-link" href="pages/before_after.php">
                <img src="image_upload/rotate.php" alt="">
                <span><h3>Restoration Projects</h3><p>Follow member restorations from before to after.</p></span>
            </a>

            <a class="cr-link" href="pages/serial_number_reference.php">
                <img src="Images/serial_numbers.jpg" alt="">
                <span><h3>Serial Number Reference</h3><p>Identify and date motorcycles by frame or engine number.</p></span>
            </a>

            <a class="cr-link" href="pages/image_library.php">
                <img src="image_library_upload/thumbs/rotate.php" alt="">
                <span><h3>Image Library</h3><p>Browse motorcycles by manufacturer, model, and year.</p></span>
            </a>

            <a class="cr-link" href="pages/library.php">
                <img src="Images/mid_ohio/thumbs/mid_ohio097.JPG" alt="">
                <span><h3>Member Collections</h3><p>See the motorcycles other members own and restore.</p></span>
            </a>

            <a class="cr-link" href="pages/identify_part.php">
                <img src="classified_ad_image_upload/thumbs/rotate.php" alt="">
                <span><h3>Identify a Part</h3><p>Post an unknown motorcycle part and ask other restorers for help.</p></span>
            </a>

            <a class="cr-link" href="pages/classified_ads.php">
                <img src="classified_ad_image_upload/thumbs/rotate.php" alt="">
                <span><h3>Restoration Classifieds</h3><p>Find motorcycles and restoration parts, or post parts you need.</p></span>
            </a>
        </div>

        <div class="cr-quick">
            <a class="cr-button secondary" href="pages/restoration_techniques.php">Restoration Techniques</a>
            <a class="cr-button secondary" href="pages/cycle_shows.php">Cycle Shows</a>
            <a class="cr-button secondary" href="pages/links.php">Useful Links</a>
            <?php if (empty($is_logged_in)): ?>
                <a class="cr-button" href="registration_page.php">Join CycleRestorer</a>
            <?php else: ?>
                <a class="cr-button" href="pages/add_restoration_pics.php">Add a Restoration</a>
            <?php endif; ?>
        </div>

        <p class="cr-note">CycleRestorer is built around restorers sharing information, photographs, experience, and hard-to-find parts.</p>
    </section>
</main>

<footer class="cr-simple-footer">
    <span>&copy; <?php echo date('Y'); ?> CycleRestorer.com</span>
    <span aria-hidden="true">&middot;</span>
    <a href="pages/privacy_policy.html">Privacy Policy</a>
    <span aria-hidden="true">&middot;</span>
    <a href="mailto:webmaster@cyclerestorer.com?subject=Suggestions for Cyclerestorer">Contact / Suggestions</a>
</footer>

<?php include 'includes/analytics.inc.php'; ?>
</body>
</html>
