<?php
// A simple hold page. Do not call usserAccessCheck() here to avoid redirect loop.
include("../scripts/functions.php");
// Clear any sensitive session tokens if desired (optional):
// session_unset();
// session_destroy();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Account On Hold</title>
<link rel="stylesheet" href="../assets/css/dashlite.css?ver=2.4.0">
<style>
.hold-box{max-width:820px;margin:6rem auto;padding:2rem;border-radius:8px;border:1px solid #f4c6c6;background:#fff8f8;color:#611111}
.hold-title{font-size:1.25rem;margin-bottom:0.5rem;font-weight:700}
.hold-msg{margin-top:1rem}
.hold-actions{margin-top:1.25rem}
.btn-contact{background:#e85347;color:#fff;border:none;padding:0.5rem 0.9rem;border-radius:6px;text-decoration:none}
</style>
</head>
<body>
<div class="hold-box">
    <div style="display:flex;align-items:center;gap:16px">
        <div style="font-size:2.4rem;color:#e85347">&#9888;</div>
        <div>
            <div class="hold-title"><?php echo !empty($blocked_title) ? $blocked_title : 'Account On Hold'; ?></div>
            <div><?php echo !empty($blocked_msg) ? $blocked_msg : 'Your account has been placed on hold. Please contact support for assistance.'; ?></div>
        </div>
    </div>
    <div class="hold-msg">
        <p>If you believe this is an error, please contact our support team or visit your branch.</p>
    </div>
    <div class="hold-actions">
        <a class="btn-contact" href="../contact">Contact Support</a>
        &nbsp; <a href="../logout">Sign out</a>
    </div>
</div>
</body>
</html>
