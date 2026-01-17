<?php

    $display_username = $_SESSION['username'] ?? 'User';
    $is_admin = $_SESSION['is_admin'] ?? FALSE; 
    

    $dashboard_link = 'dashboard.php';
    $admin_link = 'admin_dashboard.php';
    $help_link = 'help.php';
    $logout_link = 'logout.php'; 


    $current_page = basename($_SERVER['PHP_SELF']);
    

    $dashboard_active = ($current_page === 'dashboard.php') ? 'active' : '';
    $admin_active = ($current_page === 'admin_dashboard.php') ? 'active' : '';
    $help_active = ($current_page === 'help.php') ? 'active' : '';
?>

<link rel="stylesheet" href="header_style.css">

<style>

    .header-bar {
        display: flex;
        justify-content: space-between; 
        align-items: center;
        padding: 10px 20px;
        background-color: #343a40; 
        color: white;
    }
    

    .header-left {
        display: flex;
        align-items: center;
        gap: 25px;
    }


    .main-nav ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
    }
    .main-nav ul li {
        margin: 0 10px;
    }
    .main-nav ul li a {
        color: white;
        text-decoration: none;
        padding: 8px 15px;
        border-radius: 4px;
        transition: background-color 0.2s;
        font-weight: 500;
    }
    .main-nav ul li a:hover {
        background-color: #495057;
    }
    

    .main-nav ul li a.active {
        background-color: #007bff;
        font-weight: bold;
    }


    .user-menu {
        position: relative;
        cursor: pointer;
        z-index: 10;
        padding: 8px 15px; 
    }
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #f9f9f9;
        min-width: 120px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }
    .dropdown-content a {
        color: #333;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    .user-menu:hover .dropdown-content {
        display: block;
    }
</style>

<div class="header-bar">
    
    <div class="header-left">
        <div class="header-title">Event Manager</div>

        <nav class="main-nav">
            <ul>
                <li><a href="<?php echo $dashboard_link; ?>" class="<?php echo $dashboard_active; ?>">My Bookings</a></li>
                <?php if ($is_admin): ?>
                    <li><a href="<?php echo $admin_link; ?>" class="<?php echo $admin_active; ?>">Admin Panel</a></li>
                <?php endif; ?>
                <li><a href="<?php echo $help_link; ?>" class="<?php echo $help_active; ?>">Help</a></li>
            </ul>
        </nav>
        </div>

    <div class="user-menu">
        <div class="user-name-display">
            Welcome, <?php echo htmlspecialchars($display_username); ?> 
            <span style="font-size: 0.8em;">▼</span> 
        </div>
        <div class="dropdown-content">
            <a href="<?php echo $logout_link; ?>">Sign Out</a>
        </div>
    </div>
</div>