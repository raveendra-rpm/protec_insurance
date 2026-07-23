<?php
session_start();

// --- Handle Login ---
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // DB Connection for Login
    require_once 'config.php';

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        $error = "Database connection failed.";
    } else {
        $stmt = $conn->prepare("SELECT password_hash FROM admin_users WHERE username = ?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hash);
            $stmt->fetch();
            
            if (password_verify($pass, $hash)) {
                $_SESSION['admin_logged_in'] = true;
                header("Location: admin.php");
                exit;
            } else {
                $error = "Invalid username or password. Please try again.";
            }
        } else {
            $error = "Invalid username or password. Please try again.";
        }
        $stmt->close();
        $conn->close();
    }
}

// --- Handle AJAX Actions ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    header('Content-Type: application/json');
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        echo json_encode(['success' => false, 'error' => 'Not logged in']);
        exit;
    }
    
    require_once 'config.php';
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'error' => 'DB Connection Failed']);
        exit;
    }

    if ($_POST['action'] === 'mark_contacted') {
        $lead_id = intval($_POST['lead_id']);
        $sql = "UPDATE contact_leads SET is_contacted = 1 WHERE id = $lead_id";
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
    } 
    elseif ($_POST['action'] === 'delete_leads') {
        $ids = json_decode($_POST['ids']);
        if (is_array($ids) && count($ids) > 0) {
            $ids = array_map('intval', $ids);
            $ids_str = implode(',', $ids);
            $sql = "DELETE FROM contact_leads WHERE id IN ($ids_str)";
            if ($conn->query($sql) === TRUE) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => $conn->error]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'No IDs provided']);
        }
    }
    elseif ($_POST['action'] === 'change_password') {
        $new_password = $_POST['new_password'] ?? '';
        if (strlen($new_password) < 6) {
            echo json_encode(['success' => false, 'error' => 'Password must be at least 6 characters']);
        } else {
            $hash = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE admin_users SET password_hash = ? WHERE username = 'admin'");
            $stmt->bind_param("s", $hash);
            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Failed to update database']);
            }
            $stmt->close();
        }
    }
    
    $conn->close();
    exit;
}

// --- Check Login Status ---
$is_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

// If logged in, fetch data
$leads = [];
$total_leads = 0;
$today_leads = 0;
$pending_leads = 0;
$contacted_leads_count = 0;

if ($is_logged_in) {
    require_once 'config.php';
    
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Database Connection Failed: " . $conn->connect_error);
    }

    // Fetch all leads
    $sql = "SELECT * FROM contact_leads ORDER BY created_at DESC";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $leads[] = $row;
        }
    }

    $total_leads = count($leads);
    $today = date('Y-m-d');
    foreach ($leads as $lead) {
        if (isset($lead['created_at']) && strpos($lead['created_at'], $today) === 0) {
            $today_leads++;
        }
        if (!empty($lead['is_contacted']) && $lead['is_contacted'] == 1) {
            $contacted_leads_count++;
        } else {
            $pending_leads++;
        }
    }

    $conn->close();
}

// Get insurance type distribution for search/filter
$insurance_types = array_unique(array_filter(array_column($leads, 'insurance_type')));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel — Protec General Insurance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=TASA+Orbiter:wght@400..800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #0442F2;
            --primary-purple: #6D28D9;
            --hero-bg: #160028;
            --accent-yellow: #F5C518;
            --accent-orange: #F59E0B;
            --text-dark: #111827;
            --text-light: #F3F4F6;
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
            color: var(--text-light);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(4,66,242,0.5); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #0442F2; }

        /* ─── ANIMATED BACKGROUND ─────────────────── */
        .bg-orbs {
            position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden;
        }
        .orb {
            position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.3;
            animation: floatOrb 12s ease-in-out infinite alternate;
        }
        .orb-1 { width: 500px; height: 500px; background: #0442F2; top: -150px; left: -150px; animation-delay: 0s; }
        .orb-2 { width: 400px; height: 400px; background: #6D28D9; bottom: -100px; right: -100px; animation-delay: 3s; }
        .orb-3 { width: 300px; height: 300px; background: #F5C518; top: 40%; left: 50%; animation-delay: 6s; opacity: 0.1; }
        @keyframes floatOrb {
            from { transform: translate(0, 0) scale(1); }
            to   { transform: translate(30px, 30px) scale(1.1); }
        }

        /* ─── LOGIN PAGE ─────────────────────────── */
        .login-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
            padding: 20px;
        }

        .login-card {
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 44px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 32px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.05) inset;
        }

        .login-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 36px;
        }
        .login-logo-mark {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, #0442F2, #6D28D9);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-main);
            font-weight: 800;
            font-size: 20px;
            color: #fff;
            flex-shrink: 0;
        }
        .login-logo-text strong {
            display: block;
            font-family: var(--font-main);
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
            letter-spacing: 0.5px;
        }
        .login-logo-text span {
            font-size: 0.78rem;
            color: rgba(255,255,255,0.5);
        }

        .login-title {
            font-family: var(--font-main);
            font-size: 1.8rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }
        .login-subtitle {
            font-size: 0.9rem;
            color: rgba(255,255,255,0.5);
            margin-bottom: 36px;
        }

        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: rgba(255,255,255,0.6);
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }
        .form-input {
            width: 100%;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 14px 18px;
            color: #fff;
            font-size: 0.95rem;
            font-family: var(--font-body);
            transition: all 0.3s ease;
            outline: none;
        }
        .form-input::placeholder { color: rgba(255,255,255,0.3); }
        .form-input:focus {
            border-color: #0442F2;
            background: rgba(4,66,242,0.08);
            box-shadow: 0 0 0 3px rgba(4,66,242,0.2);
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #0442F2, #6D28D9);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 0.95rem;
            font-weight: 700;
            font-family: var(--font-body);
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
            margin-top: 8px;
            position: relative;
            overflow: hidden;
        }
        .login-btn::before {
            content: '';
            position: absolute; inset: 0;
            background: linear-gradient(135deg, #6D28D9, #0442F2);
            opacity: 0; transition: opacity 0.3s ease;
        }
        .login-btn:hover::before { opacity: 1; }
        .login-btn span { position: relative; z-index: 1; }

        .error-msg {
            background: rgba(239,68,68,0.1);
            border: 1px solid rgba(239,68,68,0.3);
            border-radius: 10px;
            padding: 12px 16px;
            font-size: 0.85rem;
            color: #FCA5A5;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }

        /* ─── NAVBAR ─────────────────────────────── */
        .admin-nav {
            position: sticky; top: 0; z-index: 100;
            background: rgba(13,0,30,0.85);
            border-bottom: 1px solid var(--border-glass);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 0 40px;
            display: flex; align-items: center; justify-content: space-between;
            height: 68px;
        }
        .nav-brand {
            display: flex; align-items: center; gap: 12px;
            text-decoration: none;
        }
        .nav-logo-mark {
            width: 36px; height: 36px;
            background: linear-gradient(135deg, #0442F2, #6D28D9);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-main);
            font-weight: 800;
            font-size: 16px;
            color: #fff;
        }
        .nav-brand-name {
            font-family: var(--font-main);
            font-weight: 700;
            font-size: 1rem;
            color: #fff;
        }
        .nav-brand-name span { color: rgba(255,255,255,0.45); font-weight: 400; font-size: 0.85rem; margin-left: 6px; }

        .nav-right {
            display: flex; align-items: center; gap: 16px;
        }
        .nav-badge {
            background: rgba(245,197,24,0.12);
            border: 1px solid rgba(245,197,24,0.3);
            color: #F5C518;
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        .logout-btn {
            display: flex; align-items: center; gap: 7px;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            color: rgba(255,255,255,0.7);
            padding: 8px 18px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: var(--font-body);
        }
        .logout-btn:hover {
            background: rgba(239,68,68,0.12);
            border-color: rgba(239,68,68,0.3);
            color: #FCA5A5;
        }

        /* ─── MAIN CONTENT ───────────────────────── */
        .admin-main {
            position: relative; z-index: 1;
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 40px 60px;
        }

        .page-header {
            margin-bottom: 36px;
        }
        .page-title {
            font-family: var(--font-main);
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.5px;
            margin-bottom: 6px;
        }
        .page-title span { color: #0442F2; }
        .page-subtitle {
            color: rgba(255,255,255,0.45);
            font-size: 0.9rem;
        }

        /* ─── STAT CARDS ─────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 36px;
        }
        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glass);
            border-radius: 18px;
            padding: 24px 26px;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 2px;
            background: linear-gradient(90deg, #0442F2, #6D28D9);
            opacity: 0; transition: opacity 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-3px); border-color: rgba(255,255,255,0.18); }
        .stat-card:hover::before { opacity: 1; }

        .stat-icon {
            width: 40px; height: 40px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            margin-bottom: 16px;
        }
        .stat-icon.blue  { background: rgba(4,66,242,0.15); }
        .stat-icon.yellow { background: rgba(245,197,24,0.12); }
        .stat-icon.purple { background: rgba(109,40,217,0.15); }
        .stat-icon.green  { background: rgba(16,185,129,0.12); }

        .stat-number {
            font-family: var(--font-main);
            font-size: 2.2rem;
            font-weight: 800;
            color: #fff;
            line-height: 1;
            margin-bottom: 6px;
        }
        .stat-label {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.45);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        /* ─── TABS ───────────────────────────────── */
        .dashboard-tabs {
            display: flex; gap: 8px; margin-bottom: 24px;
            background: rgba(255,255,255,0.03);
            padding: 6px; border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.06);
            width: fit-content;
        }
        .tab-btn {
            background: transparent; color: rgba(255,255,255,0.5);
            border: none; padding: 10px 24px; border-radius: 10px;
            font-size: 0.9rem; font-weight: 600; cursor: pointer;
            transition: all 0.3s ease; font-family: var(--font-body);
        }
        .tab-btn:hover { color: rgba(255,255,255,0.8); background: rgba(255,255,255,0.05); }
        .tab-btn.active {
            background: #0442F2; color: #fff;
            box-shadow: 0 4px 12px rgba(4,66,242,0.3);
        }

        .btn-mark-contacted {
            width: 100%; margin-top: 10px;
            background: rgba(16,185,129,0.15); color: #6EE7B7; border: 1px solid rgba(16,185,129,0.25);
        }
        .btn-mark-contacted:hover { background: rgba(16,185,129,0.25); transform: translateY(-1px); }

        /* ─── TABLE CARD ─────────────────────────── */
        .table-card {
            background: var(--bg-card);
            border: 1px solid var(--border-glass);
            border-radius: 20px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .table-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 26px;
            border-bottom: 1px solid var(--border-glass);
            flex-wrap: wrap;
            gap: 14px;
        }
        .table-toolbar-title {
            font-family: var(--font-main);
            font-size: 1.1rem;
            font-weight: 700;
            color: #fff;
        }
        .table-toolbar-right {
            display: flex; align-items: center; gap: 10px;
        }

        .search-box {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 9px 16px;
            color: #fff;
            font-size: 0.85rem;
            font-family: var(--font-body);
            outline: none;
            width: 220px;
            transition: all 0.3s ease;
        }
        .search-box::placeholder { color: rgba(255,255,255,0.3); }
        .search-box:focus {
            border-color: #0442F2;
            background: rgba(4,66,242,0.08);
            box-shadow: 0 0 0 3px rgba(4,66,242,0.15);
        }

        .export-btn {
            display: flex; align-items: center; gap: 7px;
            background: linear-gradient(135deg, #F5C518, #F59E0B);
            color: #111827;
            border: none;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: var(--font-body);
        }
        .export-btn:hover { transform: translateY(-1px); box-shadow: 0 8px 20px rgba(245,197,24,0.35); }

        .btn-delete-selected {
            display: none; /* hidden by default */
            align-items: center; gap: 7px;
            background: rgba(239,68,68,0.15); color: #FCA5A5;
            border: 1px solid rgba(239,68,68,0.3);
            padding: 9px 18px; border-radius: 10px;
            font-size: 0.85rem; font-weight: 700;
            cursor: pointer; transition: all 0.3s ease;
            font-family: var(--font-body);
        }
        .btn-delete-selected:hover {
            background: rgba(239,68,68,0.25); transform: translateY(-1px);
        }

        /* Checkbox Styling */
        .col-checkbox {
            width: 40px; text-align: center; display: none;
        }
        body.show-checkboxes .col-checkbox { display: table-cell; }
        
        .custom-checkbox {
            width: 16px; height: 16px; cursor: pointer;
            accent-color: #EF4444;
        }

        /* Table */
        .table-wrapper { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }
        thead tr {
            background: rgba(4,66,242,0.08);
            border-bottom: 1px solid rgba(4,66,242,0.2);
        }
        th {
            padding: 14px 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: rgba(255,255,255,0.5);
            text-align: left;
            white-space: nowrap;
        }
        tbody tr {
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: background 0.2s ease;
        }
        tbody tr:hover { background: rgba(4,66,242,0.05); }
        tbody tr:last-child { border-bottom: none; }
        td {
            padding: 16px 20px;
            font-size: 0.875rem;
            color: rgba(255,255,255,0.8);
            vertical-align: middle;
        }

        .td-name { font-weight: 600; color: #fff; }
        .td-id {
            font-family: monospace;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.35);
        }
        .td-date { color: rgba(255,255,255,0.5); font-size: 0.82rem; white-space: nowrap; }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            white-space: nowrap;
        }
        .badge-blue  { background: rgba(4,66,242,0.15); color: #93C5FD; border: 1px solid rgba(4,66,242,0.25); }
        .badge-yes   { background: rgba(16,185,129,0.12); color: #6EE7B7; border: 1px solid rgba(16,185,129,0.2); }
        .badge-no    { background: rgba(239,68,68,0.1); color: #FCA5A5; border: 1px solid rgba(239,68,68,0.2); }

        .td-msg {
            max-width: 180px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            color: rgba(255,255,255,0.5);
            font-size: 0.82rem;
        }

        .consent-icons { display: flex; flex-direction: column; gap: 3px; }
        .consent-row { font-size: 0.75rem; color: rgba(255,255,255,0.45); display: flex; align-items: center; gap: 5px; }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            color: rgba(255,255,255,0.3);
        }
        .empty-icon { font-size: 3rem; margin-bottom: 16px; }
        .empty-state p { font-size: 0.95rem; }

        /* Table footer count */
        .table-footer {
            padding: 16px 26px;
            border-top: 1px solid var(--border-glass);
            font-size: 0.8rem;
            color: rgba(255,255,255,0.35);
        }

        /* ─── PRINT ──────────────────────────────── */
        @media print {
            body { background: #fff; color: #000; }
            .bg-orbs, .admin-nav, .export-btn, .search-box { display: none !important; }
            .table-card { border: 1px solid #ddd; background: #fff; }
            th { color: #333; }
            td { color: #444; }
        }

        @media (max-width: 768px) {
            .admin-nav { padding: 0 20px; }
            .admin-main { padding: 24px 20px 40px; }
            .page-title { font-size: 1.5rem; }
            .search-box { width: 160px; }
            .nav-badge { display: none; }
        }

        /* ─── CLICKABLE ROWS ─────────────────────── */
        tbody tr { cursor: pointer; }
        tbody tr:hover td.td-name { color: #F5C518; }
        .row-hint {
            display: inline-block;
            font-size: 0.7rem;
            color: rgba(255,255,255,0.25);
            margin-left: 8px;
            font-style: italic;
        }

        /* ─── MODAL ──────────────────────────────── */
        .modal-overlay {
            position: fixed; inset: 0; z-index: 1000;
            background: rgba(0,0,0,0.75);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            display: flex; align-items: center; justify-content: center;
            padding: 20px;
            opacity: 0; pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .modal-overlay.open {
            opacity: 1; pointer-events: all;
        }
        .modal-box {
            background: #0D001E;
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 24px;
            width: 100%;
            max-width: 560px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 40px 100px rgba(0,0,0,0.7), 0 0 0 1px rgba(255,255,255,0.04) inset;
            transform: translateY(20px) scale(0.97);
            transition: transform 0.3s ease;
        }
        .modal-overlay.open .modal-box {
            transform: translateY(0) scale(1);
        }
        .modal-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 24px 28px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .modal-title {
            font-family: var(--font-main);
            font-size: 1.25rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.3px;
        }
        .modal-id {
            font-family: monospace;
            font-size: 0.78rem;
            color: rgba(255,255,255,0.35);
            margin-top: 3px;
        }
        .modal-close {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            color: rgba(255,255,255,0.6);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .modal-close:hover { background: rgba(239,68,68,0.15); border-color: rgba(239,68,68,0.3); color: #FCA5A5; }

        .modal-body { padding: 24px 28px 28px; }

        .modal-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255,255,255,0.3);
            margin-bottom: 14px;
            margin-top: 22px;
            padding-bottom: 6px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .modal-section-title:first-child { margin-top: 0; }

        .modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        .modal-field {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 12px;
            padding: 14px 16px;
        }
        .modal-field.full { grid-column: 1 / -1; }
        .modal-field-label {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            color: rgba(255,255,255,0.35);
            margin-bottom: 5px;
        }
        .modal-field-value {
            font-size: 0.9rem;
            color: #fff;
            font-weight: 500;
            word-break: break-word;
            line-height: 1.5;
        }
        .modal-field-value.mono { font-family: monospace; font-size: 0.85rem; }
        .modal-field-value.muted { color: rgba(255,255,255,0.4); font-style: italic; }

        .consent-pills { display: flex; gap: 8px; flex-wrap: wrap; }
        .pill {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 0.78rem;
            font-weight: 600;
        }
        .pill-yes { background: rgba(16,185,129,0.15); color: #6EE7B7; border: 1px solid rgba(16,185,129,0.25); }
        .pill-no  { background: rgba(239,68,68,0.1);  color: #FCA5A5; border: 1px solid rgba(239,68,68,0.2); }

        .modal-actions {
            display: flex; gap: 10px; margin-top: 22px; flex-wrap: wrap;
        }
        .modal-action-btn {
            flex: 1;
            padding: 12px 18px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.25s ease;
            display: flex; align-items: center; justify-content: center; gap: 7px;
            font-family: var(--font-body);
            border: none;
        }
        .btn-call  { background: rgba(4,66,242,0.15); color: #93C5FD; border: 1px solid rgba(4,66,242,0.25); }
        .btn-call:hover  { background: rgba(4,66,242,0.25); transform: translateY(-1px); }
        .btn-email { background: rgba(245,197,24,0.12); color: #F5C518; border: 1px solid rgba(245,197,24,0.25); }
        .btn-email:hover { background: rgba(245,197,24,0.22); transform: translateY(-1px); }

    </style>
</head>
<body>

<!-- Animated Background Orbs -->
<div class="bg-orbs">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
</div>

<?php if (!$is_logged_in): ?>
<!-- ═══ LOGIN SCREEN ════════════════════════════════ -->
<div class="login-page">
    <div class="login-card">
        <div class="login-logo">
            <div class="login-logo-mark">P</div>
            <div class="login-logo-text">
                <strong>ProTec General Insurance</strong>
                <span>Admin Portal</span>
            </div>
        </div>

        <h1 class="login-title">Welcome back</h1>
        <p class="login-subtitle">Sign in to access the leads dashboard</p>

        <?php if ($error): ?>
        <div class="error-msg">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="admin.php">
            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="text" class="form-input" id="username" name="username" placeholder="admin" required autocomplete="username">
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" class="form-input" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
            </div>
            <button type="submit" name="login" class="login-btn">
                <span>Sign In to Dashboard →</span>
            </button>
        </form>
    </div>
</div>

<?php else: ?>
<!-- ═══ DASHBOARD SCREEN ════════════════════════════ -->
<nav class="admin-nav">
    <a href="index.php" class="nav-brand" style="text-decoration:none;">
        <div class="nav-logo-mark">P</div>
        <div class="nav-brand-name">ProTec <span>Admin Panel</span></div>
    </a>
    <div class="nav-right">
        <span class="nav-badge">● Live</span>
        <button class="logout-btn" onclick="openPwdModal()" style="background: rgba(245,197,24,0.1); border-color: rgba(245,197,24,0.3); color: #F5C518;">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
            Change Password
        </button>
        <a href="logout.php" class="logout-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            Logout
        </a>
    </div>
</nav>

<main class="admin-main">
    <div class="page-header">
        <h1 class="page-title">Lead <span>Dashboard</span></h1>
        <p class="page-subtitle">All submitted leads from the Protec website</p>
    </div>

    <!-- Stats Row -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">📋</div>
            <div class="stat-number"><?php echo $total_leads; ?></div>
            <div class="stat-label">Total Leads</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">⏳</div>
            <div class="stat-number"><?php echo $pending_leads; ?></div>
            <div class="stat-label">Pending Leads</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">✅</div>
            <div class="stat-number"><?php echo $contacted_leads_count; ?></div>
            <div class="stat-label">Contacted</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">📅</div>
            <div class="stat-number"><?php echo $today_leads; ?></div>
            <div class="stat-label">Today's Leads</div>
        </div>
    </div>

    <!-- Tabs Row -->
    <div class="dashboard-tabs">
        <button class="tab-btn active" onclick="switchTab('all', this)">All Lead Submissions</button>
        <button class="tab-btn" onclick="switchTab('contacted', this)">Contacted Leads</button>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-toolbar">
            <div class="table-toolbar-title">All Lead Submissions</div>
            <div class="table-toolbar-right">
                <button class="btn-delete-selected" id="btnDeleteSelected" onclick="deleteSelectedLeads()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
                    Delete Selected
                </button>
                <input type="search" class="search-box" id="searchInput" placeholder="🔍  Search leads..." oninput="filterTable()" autocomplete="nope" readonly onfocus="this.removeAttribute('readonly');">
                <button class="export-btn" onclick="exportToCSV()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                    Export CSV
                </button>
            </div>
        </div>

        <div class="table-wrapper">
            <table id="leadsTable">
                <thead>
                    <tr>
                        <th class="col-checkbox"><input type="checkbox" class="custom-checkbox" id="selectAll" onclick="toggleAll(this)"></th>
                        <th>ID</th>
                        <th>Date & Time</th>
                        <th>Full Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Insurance Type</th>
                        <th>Message</th>
                        <th>Consent</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php if (empty($leads)): ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">📭</div>
                                <p>No leads found yet. They'll appear here as users submit the form.</p>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($leads as $lead): ?>
                        <?php
                            $dt2 = isset($lead['created_at']) ? (new DateTime($lead['created_at']))->format('d M Y, h:i A') : '—';
                            $wa  = !empty($lead['whatsapp_consent']) ? '1' : '0';
                            $pro = !empty($lead['promo_consent']) ? '1' : '0';
                            $is_contacted = !empty($lead['is_contacted']) ? '1' : '0';
                        ?>
                        <tr data-id="<?php echo $lead['id']; ?>" data-contacted="<?php echo $is_contacted; ?>" onclick="window.location.href='lead_details.php?id=<?php echo htmlspecialchars($lead['id'], ENT_QUOTES); ?>'">
                            <td class="col-checkbox" onclick="event.stopPropagation();">
                                <input type="checkbox" class="custom-checkbox lead-checkbox" value="<?php echo $lead['id']; ?>" onclick="updateDeleteBtn()">
                            </td>
                            <td class="td-id">#<?php echo str_pad(htmlspecialchars($lead['id']), 4, '0', STR_PAD_LEFT); ?></td>
                            <td class="td-date">
                                <?php
                                    $dt = isset($lead['created_at']) ? new DateTime($lead['created_at']) : null;
                                    echo $dt ? $dt->format('d M Y') . '<br><span style="font-size:0.75rem;opacity:0.5;">' . $dt->format('h:i A') . '</span>' : '—';
                                ?>
                            </td>
                            <td class="td-name">
                                <?php echo htmlspecialchars($lead['full_name']); ?>
                                <span class="row-hint">click for details</span>
                            </td>
                            <td><?php echo htmlspecialchars($lead['mobile']); ?></td>
                            <td><?php echo htmlspecialchars($lead['email']); ?></td>
                            <td>
                                <?php if (!empty($lead['insurance_type'])): ?>
                                <span class="badge badge-blue"><?php echo htmlspecialchars($lead['insurance_type']); ?></span>
                                <?php else: ?>
                                <span style="color:rgba(255,255,255,0.25);">—</span>
                                <?php endif; ?>
                            </td>
                            <td class="td-msg" title="<?php echo htmlspecialchars($lead['message'] ?? ''); ?>">
                                <?php echo !empty($lead['message']) ? htmlspecialchars($lead['message']) : '<span style="opacity:0.3">No message</span>'; ?>
                            </td>
                            <td>
                                <div class="consent-icons">
                                    <span class="consent-row">
                                        WA:&nbsp;
                                        <?php if (!empty($lead['whatsapp_consent'])): ?>
                                        <span class="badge badge-yes">Yes</span>
                                        <?php else: ?>
                                        <span class="badge badge-no">No</span>
                                        <?php endif; ?>
                                    </span>
                                    <span class="consent-row">
                                        Promo:&nbsp;
                                        <?php if (!empty($lead['promo_consent'])): ?>
                                        <span class="badge badge-yes">Yes</span>
                                        <?php else: ?>
                                        <span class="badge badge-no">No</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            Showing <span id="rowCount"><?php echo count($leads); ?></span> of <?php echo $total_leads; ?> leads
        </div>
    </div>
</main>

<!-- ═══ LEAD DETAIL MODAL ═══════════════════════════ -->
<div class="modal-overlay" id="leadModal" onclick="closeModalOnBg(event)">
    <div class="modal-box">
        <div class="modal-header">
            <div>
                <div class="modal-title" id="modal-name">Lead Details</div>
                <div class="modal-id" id="modal-id"></div>
            </div>
            <button class="modal-close" onclick="closeModal()">✕</button>
        </div>
        <div class="modal-body">

            <div class="modal-section-title">📋 Contact Information</div>
            <div class="modal-grid">
                <div class="modal-field">
                    <div class="modal-field-label">Full Name</div>
                    <div class="modal-field-value" id="md-name">—</div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-label">Mobile Number</div>
                    <div class="modal-field-value mono" id="md-mobile">—</div>
                </div>
                <div class="modal-field full">
                    <div class="modal-field-label">Email Address</div>
                    <div class="modal-field-value" id="md-email">—</div>
                </div>
            </div>

            <div class="modal-section-title">🛡️ Insurance Details</div>
            <div class="modal-grid">
                <div class="modal-field">
                    <div class="modal-field-label">Insurance Type</div>
                    <div class="modal-field-value" id="md-insurance">—</div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-label">Submitted On</div>
                    <div class="modal-field-value" id="md-date">—</div>
                </div>
                <div class="modal-field full">
                    <div class="modal-field-label">Message / Query</div>
                    <div class="modal-field-value" id="md-message" style="white-space: pre-wrap;">—</div>
                </div>
            </div>

            <div class="modal-section-title">✅ Consent Status</div>
            <div class="modal-grid">
                <div class="modal-field">
                    <div class="modal-field-label">WhatsApp Consent</div>
                    <div class="modal-field-value" id="md-wa">—</div>
                </div>
                <div class="modal-field">
                    <div class="modal-field-label">Promo Consent</div>
                    <div class="modal-field-value" id="md-promo">—</div>
                </div>
            </div>

            <div class="modal-actions">
                <a class="modal-action-btn btn-call" id="md-call-btn" href="#">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8 19.79 19.79 0 01.01 1.18 2 2 0 012 .01h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
                    Call Now
                </a>
                <a class="modal-action-btn btn-email" id="md-email-btn" href="#">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Send Email
                </a>
            </div>

            <button class="modal-action-btn btn-mark-contacted" id="md-mark-btn" onclick="markAsContacted()">
                ✓ Mark as Contacted
            </button>

        </div>
    </div>
</div>

<!-- ═══ CHANGE PASSWORD MODAL ═══════════════════════════ -->
<div class="modal-overlay" id="pwdModal">
    <div class="modal-box" style="max-width: 400px;">
        <div class="modal-header">
            <div>
                <div class="modal-title">Change Password</div>
                <div class="modal-id">Update your admin credentials</div>
            </div>
            <button class="modal-close" onclick="closePwdModal()">✕</button>
        </div>
        <div class="modal-body">
            <div class="modal-field" style="margin-bottom: 15px;">
                <div class="modal-field-label">New Password</div>
                <input type="password" id="newPwd" class="form-input" placeholder="Enter new password" style="margin-top:5px;" required>
            </div>
            <div class="modal-field" style="margin-bottom: 25px;">
                <div class="modal-field-label">Confirm Password</div>
                <input type="password" id="confirmPwd" class="form-input" placeholder="Confirm new password" style="margin-top:5px;" required>
            </div>
            <button class="modal-action-btn btn-mark-contacted" id="btnChangePwd" onclick="changePassword()" style="width: 100%;">
                Update Password
            </button>
        </div>
    </div>
</div>

<!-- ═══ DELETE CONFIRMATION MODAL ═══════════════════════════ -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-box" style="max-width: 400px; border-color: rgba(239,68,68,0.3);">
        <div class="modal-header" style="border-bottom-color: rgba(239,68,68,0.15);">
            <div>
                <div class="modal-title" style="color: #FCA5A5;">Delete Leads</div>
                <div class="modal-id">This action cannot be undone</div>
            </div>
            <button class="modal-close" onclick="closeDeleteModal()">✕</button>
        </div>
        <div class="modal-body">
            <p style="color: rgba(255,255,255,0.7); font-size: 0.95rem; margin-bottom: 25px; line-height: 1.5;" id="deleteModalText">
                Are you sure you want to permanently delete these leads?
            </p>
            <div style="display: flex; gap: 12px;">
                <button class="modal-action-btn" onclick="closeDeleteModal()" style="flex: 1; background: rgba(255,255,255,0.06); color: rgba(255,255,255,0.7); border: 1px solid rgba(255,255,255,0.12);">
                    Cancel
                </button>
                <button class="modal-action-btn" id="btnConfirmDelete" onclick="confirmDeleteLeads()" style="flex: 1; background: rgba(239,68,68,0.15); color: #FCA5A5; border: 1px solid rgba(239,68,68,0.3);">
                    Yes, Delete
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentTab = 'all';
let currentLeadId = null;

function switchTab(tab, btnElement) {
    currentTab = tab;
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    btnElement.classList.add('active');
    
    if (tab === 'contacted') {
        document.body.classList.add('show-checkboxes');
    } else {
        document.body.classList.remove('show-checkboxes');
        document.querySelectorAll('.lead-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAll').checked = false;
    }
    
    updateDeleteBtn();
    filterTable();
}

function toggleAll(source) {
    const visibleCheckboxes = document.querySelectorAll('#tableBody tr:not([style*="display: none"]) .lead-checkbox');
    visibleCheckboxes.forEach(cb => cb.checked = source.checked);
    updateDeleteBtn();
}

function updateDeleteBtn() {
    if (currentTab !== 'contacted') {
        document.getElementById('btnDeleteSelected').style.display = 'none';
        return;
    }
    const checked = document.querySelectorAll('.lead-checkbox:checked').length;
    document.getElementById('btnDeleteSelected').style.display = checked > 0 ? 'flex' : 'none';
    
    const visible = document.querySelectorAll('#tableBody tr:not([style*="display: none"]) .lead-checkbox').length;
    if (visible > 0) {
        document.getElementById('selectAll').checked = (checked === visible);
    }
}

function deleteSelectedLeads() {
    const checked = document.querySelectorAll('.lead-checkbox:checked');
    if (checked.length === 0) return;
    
    document.getElementById('deleteModalText').textContent = `Are you sure you want to permanently delete ${checked.length} lead(s)?`;
    document.getElementById('deleteModal').classList.add('open');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
}

function confirmDeleteLeads() {
    const checked = document.querySelectorAll('.lead-checkbox:checked');
    if (checked.length === 0) return;
    
    const ids = Array.from(checked).map(cb => cb.value);
    
    const btn = document.getElementById('btnConfirmDelete');
    btn.innerHTML = 'Deleting...';
    btn.style.pointerEvents = 'none';

    fetch('admin.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=delete_leads&ids=' + encodeURIComponent(JSON.stringify(ids))
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            ids.forEach(id => {
                const row = document.querySelector(`tr[data-id='${id}']`);
                if (row) row.remove();
            });
            document.getElementById('selectAll').checked = false;
            filterTable();
            updateDeleteBtn();
            showToast('Success!', `${ids.length} lead(s) deleted permanently.`, 'success');
            closeDeleteModal();
        } else {
            showToast('Error', data.error, 'error');
        }
    })
    .catch(e => showToast('Error', 'Failed to process request.', 'error'))
    .finally(() => {
        btn.innerHTML = `Yes, Delete`;
        btn.style.pointerEvents = 'auto';
    });
}

function openPwdModal() {
    document.getElementById('pwdModal').classList.add('open');
    document.getElementById('newPwd').value = '';
    document.getElementById('confirmPwd').value = '';
}

function closePwdModal() {
    document.getElementById('pwdModal').classList.remove('open');
}

function changePassword() {
    const newPwd = document.getElementById('newPwd').value;
    const confirmPwd = document.getElementById('confirmPwd').value;
    
    if (newPwd.length < 6) {
        showToast('Error', 'Password must be at least 6 characters long.', 'error');
        return;
    }
    if (newPwd !== confirmPwd) {
        showToast('Error', 'Passwords do not match.', 'error');
        return;
    }
    
    const btn = document.getElementById('btnChangePwd');
    btn.textContent = 'Updating...';
    btn.style.pointerEvents = 'none';

    fetch('admin.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=change_password&new_password=' + encodeURIComponent(newPwd)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showToast('Success!', 'Password changed successfully.', 'success');
            closePwdModal();
        } else {
            showToast('Error', data.error, 'error');
        }
    })
    .catch(e => showToast('Error', 'Failed to process request.', 'error'))
    .finally(() => {
        btn.textContent = 'Update Password';
        btn.style.pointerEvents = 'auto';
    });
}

function openModal(data) {
    currentLeadId = data.id;

    // Populate fields
    document.getElementById('modal-name').textContent = data.name || 'Lead Details';
    document.getElementById('modal-id').textContent   = 'Lead ID: #' + String(data.id).padStart(4, '0');
    document.getElementById('md-name').textContent     = data.name    || '—';
    document.getElementById('md-mobile').textContent   = data.mobile  || '—';
    document.getElementById('md-email').textContent    = data.email   || '—';
    document.getElementById('md-date').textContent     = data.date    || '—';

    const ins = document.getElementById('md-insurance');
    ins.textContent = data.insurance || 'Not specified';
    ins.className = 'modal-field-value' + (data.insurance ? '' : ' muted');

    const msg = document.getElementById('md-message');
    msg.textContent = data.message || 'No message provided';
    msg.className = 'modal-field-value' + (data.message ? '' : ' muted');

    // Consent pills
    document.getElementById('md-wa').innerHTML    = data.wa    === '1' ? '<span class="pill pill-yes">✅ Consented</span>' : '<span class="pill pill-no">❌ Not Consented</span>';
    document.getElementById('md-promo').innerHTML = data.promo === '1' ? '<span class="pill pill-yes">✅ Consented</span>' : '<span class="pill pill-no">❌ Not Consented</span>';

    // Action buttons
    document.getElementById('md-call-btn').href  = data.mobile ? 'tel:' + data.mobile : '#';
    document.getElementById('md-email-btn').href = data.email  ? 'mailto:' + data.email : '#';

    // Toggle Mark as Contacted button
    const markBtn = document.getElementById('md-mark-btn');
    if (data.contacted === '1') {
        markBtn.style.display = 'none';
    } else {
        markBtn.style.display = 'flex';
        markBtn.textContent = '✓ Mark as Contacted';
        markBtn.style.pointerEvents = 'auto';
    }

    // Open modal
    document.getElementById('leadModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function showToast(title, msg, type = 'success') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container';
        document.body.appendChild(container);
    }
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    const icon = type === 'success' ? '✅' : '⚠️';
    toast.innerHTML = `
        <div class="toast-icon">${icon}</div>
        <div class="toast-content">
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

function markAsContacted() {
    if (!currentLeadId) return;
    const btn = document.getElementById('md-mark-btn');
    btn.textContent = 'Updating...';
    btn.style.pointerEvents = 'none';

    fetch('admin.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=mark_contacted&lead_id=' + currentLeadId
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const row = document.querySelector(`tr[data-id='${currentLeadId}']`);
            if (row) row.setAttribute('data-contacted', '1');
            closeModal();
            filterTable();
            showToast('Success!', 'Lead marked as contacted.', 'success');
        } else {
            showToast('Error', data.error, 'error');
        }
    })
    .catch(e => showToast('Error', 'Failed to process request.', 'error'))
    .finally(() => {
        btn.textContent = '✓ Mark as Contacted';
        btn.style.pointerEvents = 'auto';
    });
}

function closeModal() {
    document.getElementById('leadModal').classList.remove('open');
    document.body.style.overflow = '';
}

function closeModalOnBg(e) {
    if (e.target === document.getElementById('leadModal')) closeModal();
}

// Close on Escape key
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

function filterTable() {
    const searchInput = document.getElementById('searchInput');
    const q = searchInput ? searchInput.value.toLowerCase() : '';
    const rows = document.querySelectorAll('#tableBody tr');
    let visible = 0;
    rows.forEach(row => {
        if (!row.hasAttribute('data-contacted')) return; // ignore empty state row
        
        const txt = row.textContent.toLowerCase();
        const showSearch = txt.includes(q);

        const contacted = row.getAttribute('data-contacted');
        const showTab = (currentTab === 'all' && contacted !== '1') || 
                     (currentTab === 'contacted' && contacted === '1');
        
        const show = showSearch && showTab;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    
    document.getElementById('rowCount').textContent = visible;
    updateDeleteBtn();
}

function exportToCSV() {
    let csv = [];
    const rows = document.querySelectorAll("table tr");
    
    for (let i = 0; i < rows.length; i++) {
        if (rows[i].style.display === 'none') continue;
        
        let row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (let j = 1; j < cols.length; j++) {
            let data = cols[j].innerText.replace(/(\r\n|\n|\r)/gm, " ").replace(/"/g, '""');
            data = data.replace('click for details', '').trim();
            row.push('"' + data + '"');
        }
        csv.push(row.join(","));
    }

    const csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
    const downloadLink = document.createElement("a");
    downloadLink.download = "protec_leads_" + new Date().toISOString().slice(0,10) + ".csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
    document.body.removeChild(downloadLink);
}

document.addEventListener("DOMContentLoaded", () => {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.value = '';
        setTimeout(() => { searchInput.value = ''; filterTable(); }, 50);
        setTimeout(() => { searchInput.value = ''; filterTable(); }, 500);
    }
    filterTable();
});
</script>
<?php endif; ?>

</body>
</html>

