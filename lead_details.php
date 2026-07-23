<?php
session_start();

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin.php");
    exit;
}

require_once 'config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Database Connection Failed");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    header('Content-Type: application/json');
    if ($_POST['action'] === 'mark_contacted') {
        $lead_id = intval($_POST['lead_id']);
        $sql = "UPDATE contact_leads SET is_contacted = 1 WHERE id = $lead_id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    }
    $conn->close();
    exit;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: admin.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM contact_leads WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    header("Location: admin.php");
    exit;
}
$lead = $result->fetch_assoc();
$stmt->close();
$conn->close();

$is_contacted = !empty($lead['is_contacted']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Details — Protec Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=TASA+Orbiter:wght@400..800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0442F2;
            --primary-purple: #6D28D9;
            --bg-dark: #0D001E;
            --bg-card: rgba(255,255,255,0.04);
            --border-glass: rgba(255,255,255,0.1);
            --font-main: 'TASA Orbiter', 'Inter', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body {
            font-family: var(--font-body);
            background: var(--bg-dark);
            color: #F3F4F6;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(4,66,242,0.5); border-radius: 10px; }

        /* Animated Background Orbs */
        .bg-orbs { position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }
        .orb { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.3; animation: floatOrb 12s ease-in-out infinite alternate; }
        .orb-1 { width: 500px; height: 500px; background: #0442F2; top: -150px; left: -150px; }
        .orb-2 { width: 400px; height: 400px; background: #6D28D9; bottom: -100px; right: -100px; animation-delay: 3s; }
        @keyframes floatOrb {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(30px, 30px) scale(1.1); }
        }

        /* Navbar */
        .admin-nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(13,0,30,0.85);
            border-bottom: 1px solid var(--border-glass);
            backdrop-filter: blur(20px);
            padding: 0 40px;
            display: flex; align-items: center; justify-content: space-between;
            height: 68px;
        }
        .nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .nav-logo-mark {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #0442F2, #6D28D9);
            border-radius: 10px; display: flex; align-items: center; justify-content: center;
            font-family: var(--font-main); font-weight: 800; font-size: 16px; color: #fff;
        }
        .nav-brand-name { font-family: var(--font-main); font-weight: 700; font-size: 1rem; color: #fff; }
        .nav-brand-name span { color: rgba(255,255,255,0.45); font-weight: 400; font-size: 0.85rem; margin-left: 6px; }

        .back-btn {
            display: flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.8); padding: 8px 18px; border-radius: 10px;
            font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: all 0.3s ease;
        }
        .back-btn:hover { background: rgba(255,255,255,0.15); color: #fff; }

        /* Main Content */
        .admin-main { position: relative; z-index: 1; max-width: 900px; margin: 0 auto; padding: 40px 20px 60px; }
        
        .page-header { margin-bottom: 30px; }
        .page-title { font-family: var(--font-main); font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 6px; }
        .page-subtitle { color: rgba(255,255,255,0.45); font-size: 0.95rem; }

        .details-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            padding: 30px 35px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }

        .section-title {
            font-size: 0.8rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 1px; color: rgba(255,255,255,0.4);
            margin: 25px 0 15px; padding-bottom: 8px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .section-title:first-child { margin-top: 0; }

        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .detail-item {
            background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);
            border-radius: 14px; padding: 16px 20px;
        }
        .detail-item.full { grid-column: 1 / -1; }
        .detail-label {
            font-size: 0.75rem; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.8px; color: rgba(255,255,255,0.4); margin-bottom: 6px;
        }
        .detail-value { font-size: 1rem; color: #fff; font-weight: 500; line-height: 1.6; word-break: break-word; }
        .detail-value.mono { font-family: monospace; }
        .detail-value.muted { color: rgba(255,255,255,0.4); font-style: italic; }

        .pill { padding: 6px 14px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; display: inline-block; }
        .pill-yes { background: rgba(16,185,129,0.15); color: #6EE7B7; border: 1px solid rgba(16,185,129,0.25); }
        .pill-no  { background: rgba(239,68,68,0.1);  color: #FCA5A5; border: 1px solid rgba(239,68,68,0.2); }

        .actions-row { display: flex; gap: 12px; margin-top: 30px; flex-wrap: wrap; }
        .action-btn {
            flex: 1; padding: 14px 20px; border-radius: 12px; font-size: 0.9rem; font-weight: 700;
            text-align: center; text-decoration: none; cursor: pointer; transition: all 0.25s ease;
            display: flex; align-items: center; justify-content: center; gap: 8px; border: none; font-family: var(--font-body);
        }
        .btn-call  { background: rgba(4,66,242,0.15); color: #93C5FD; border: 1px solid rgba(4,66,242,0.25); }
        .btn-call:hover  { background: rgba(4,66,242,0.25); transform: translateY(-2px); }
        .btn-email { background: rgba(245,197,24,0.12); color: #F5C518; border: 1px solid rgba(245,197,24,0.25); }
        .btn-email:hover { background: rgba(245,197,24,0.22); transform: translateY(-2px); }
        .btn-mark { background: rgba(16,185,129,0.15); color: #6EE7B7; border: 1px solid rgba(16,185,129,0.25); width: 100%; margin-top: 12px; }
        .btn-mark:hover { background: rgba(16,185,129,0.25); transform: translateY(-2px); }
        
        .toast-container { position: fixed; bottom: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; }
        .toast { background: rgba(13,0,30,0.9); border: 1px solid rgba(255,255,255,0.1); padding: 16px 20px; border-radius: 12px; display: flex; gap: 12px; transform: translateX(120%); transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        .toast.show { transform: translateX(0); }
        .toast.success { border-left: 4px solid #10B981; }
        .toast.error { border-left: 4px solid #EF4444; }
        .toast-icon { font-size: 20px; }
        .toast-title { font-weight: 700; font-size: 0.9rem; color: #fff; }
        .toast-msg { font-size: 0.8rem; color: rgba(255,255,255,0.6); margin-top: 4px; }

        @media (max-width: 768px) {
            .details-grid { grid-template-columns: 1fr; }
            .admin-nav { padding: 0 20px; }
            .nav-brand-name span { display: none; }
        }
    </style>
</head>
<body>

<div class="bg-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
</div>

<nav class="admin-nav">
    <a href="index.php" class="nav-brand">
        <div class="nav-logo-mark">P</div>
        <div class="nav-brand-name">ProTec <span>Admin Panel</span></div>
    </a>
    <a href="admin.php" class="back-btn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Back to Dashboard
    </a>
</nav>

<main class="admin-main">
    <div class="page-header">
        <h1 class="page-title">Lead Details</h1>
        <p class="page-subtitle">Lead ID: #<?php echo str_pad($lead['id'], 4, '0', STR_PAD_LEFT); ?></p>
    </div>

    <div class="details-card">
        <div class="section-title">📋 Contact Information</div>
        <div class="details-grid">
            <div class="detail-item">
                <div class="detail-label">Full Name</div>
                <div class="detail-value"><?php echo htmlspecialchars($lead['full_name']); ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Mobile Number</div>
                <div class="detail-value mono"><?php echo htmlspecialchars($lead['mobile']); ?></div>
            </div>
            <div class="detail-item full">
                <div class="detail-label">Email Address</div>
                <div class="detail-value"><?php echo htmlspecialchars($lead['email']); ?></div>
            </div>
        </div>

        <div class="section-title">🛡️ Insurance Details</div>
        <div class="details-grid">
            <div class="detail-item">
                <div class="detail-label">Insurance Type</div>
                <div class="detail-value <?php echo empty($lead['insurance_type']) ? 'muted' : ''; ?>">
                    <?php echo empty($lead['insurance_type']) ? 'Not specified' : htmlspecialchars($lead['insurance_type']); ?>
                </div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Submitted On</div>
                <div class="detail-value"><?php echo isset($lead['created_at']) ? (new DateTime($lead['created_at']))->format('d M Y, h:i A') : '—'; ?></div>
            </div>
            <div class="detail-item full">
                <div class="detail-label">Message / Query</div>
                <div class="detail-value <?php echo empty($lead['message']) ? 'muted' : ''; ?>" style="white-space: pre-wrap;"><?php echo empty($lead['message']) ? 'No message provided' : htmlspecialchars($lead['message']); ?></div>
            </div>
        </div>

        <div class="section-title">✅ Consent Status</div>
        <div class="details-grid">
            <div class="detail-item">
                <div class="detail-label">WhatsApp Consent</div>
                <div class="detail-value">
                    <?php if (!empty($lead['whatsapp_consent'])): ?>
                        <span class="pill pill-yes">✅ Consented</span>
                    <?php else: ?>
                        <span class="pill pill-no">❌ Not Consented</span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Promo Consent</div>
                <div class="detail-value">
                    <?php if (!empty($lead['promo_consent'])): ?>
                        <span class="pill pill-yes">✅ Consented</span>
                    <?php else: ?>
                        <span class="pill pill-no">❌ Not Consented</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="actions-row">
            <a href="tel:<?php echo htmlspecialchars($lead['mobile']); ?>" class="action-btn btn-call">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 01.01 1.18 2 2 0 012 .01h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                Call Now
            </a>
            <a href="mailto:<?php echo htmlspecialchars($lead['email']); ?>" class="action-btn btn-email">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                Send Email
            </a>
        </div>
        
        <?php if (!$is_contacted): ?>
        <button class="action-btn btn-mark" id="markBtn" onclick="markContacted(<?php echo $lead['id']; ?>)">
            ✓ Mark as Contacted
        </button>
        <?php else: ?>
        <button class="action-btn" style="width: 100%; margin-top: 12px; background: rgba(255,255,255,0.05); color: rgba(255,255,255,0.5); cursor: not-allowed;" disabled>
            Already Contacted
        </button>
        <?php endif; ?>

    </div>
</main>

<div id="toast-container" class="toast-container"></div>

<script>
function showToast(title, msg, type = 'success') {
    const container = document.getElementById('toast-container');
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    const icon = type === 'success' ? '✅' : '⚠️';
    toast.innerHTML = `
        <div class="toast-icon">${icon}</div>
        <div>
            <div class="toast-title">${title}</div>
            <div class="toast-msg">${msg}</div>
        </div>
    `;
    container.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 400);
    }, 4000);
}

function markContacted(id) {
    const btn = document.getElementById('markBtn');
    btn.textContent = 'Updating...';
    btn.style.pointerEvents = 'none';

    fetch('lead_details.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=mark_contacted&lead_id=' + id
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('Success!', 'Lead marked as contacted.', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('Error', data.error || 'Failed to update', 'error');
            btn.textContent = '✓ Mark as Contacted';
            btn.style.pointerEvents = 'auto';
        }
    })
    .catch(e => {
        showToast('Error', 'Failed to process request.', 'error');
        btn.textContent = '✓ Mark as Contacted';
        btn.style.pointerEvents = 'auto';
    });
}
</script>
</body>
</html>
