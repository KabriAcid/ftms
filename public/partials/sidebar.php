<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside class="sidebar">
    <nav>
        <div class="header">
            <a href="dashboard.php"><span class="focus"><img src="../favicon.png" alt="favicon" width="50px" height="50px"></span><span class="unfocus">Family Tree</span></a>
        </div>
        <div class="separator-wrapper">
            <hr class="separator" />
            <label for="minimize" class="minimize-btn">
                <input type="checkbox" id="minimize" />
                <i class="fa-solid fa-angle-left"></i>
            </label>
        </div>
        <div class="navigation">
            <div class="section main-section">
                <div class="title-wrapper">
                    <span class="title">Main</span>
                </div>
                <ul class="items">
                    <li class="item <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                        <a href="dashboard.php">
                            <i class="fa-solid fa-sitemap"></i>
                            <span class="item-text">Family Tree</span>
                            <span class="item-tooltip">Tree</span>
                        </a>
                    </li>
                    <li class="item <?php echo ($current_page == 'profile.php') ? 'active' : ''; ?>">
                        <a href="profile.php">
                            <i class="fa-solid fa-user"></i>
                            <span class="item-text">Profile</span>
                            <span class="item-tooltip">Profile</span>
                        </a>
                    </li>
                    <li class="item <?php echo ($current_page == 'members.php') ? 'active' : ''; ?>">
                        <a href="members.php">
                            <i class="fa-solid fa-users"></i>
                            <span class="item-text">Members</span>
                            <span class="item-tooltip">Members</span>
                        </a>
                    </li>
                    <?php
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'Admin') {
                    ?>
                        <li class="item <?php echo ($current_page == 'add_member.php') ? 'active' : ''; ?>">
                            <a href="add_member.php">
                                <i class="fa-solid fa-user-plus"></i>
                                <span class="item-text">Add Member</span>
                                <span class="item-tooltip">Add Member</span>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="item <?php echo ($current_page == 'events.php') ? 'active' : ''; ?>">
                        <a href="events.php">
                            <i class="fa-solid fa-calendar-alt"></i>
                            <span class="item-text">Events</span>
                            <span class="item-tooltip">Events</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="section settings-section">
                <div class="title-wrapper">
                    <span class="title">Settings</span>
                </div>
                <ul class="items">
                    <?php
                    if (isset($_SESSION['user']) && $_SESSION['user']['role'] == 'Admin') {
                    ?>
                        <li class="item <?php echo ($current_page == 'manage_app.php') ? 'active' : ''; ?>">
                            <a href="manage_app.php">
                                <i class="fa-solid fa-cog"></i>
                                <span class="item-text">Manage App</span>
                                <span class="item-tooltip">Manage App</span>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="item <?php echo ($current_page == 'update_password.php') ? 'active' : ''; ?>">
                        <a href="update_password.php">
                            <i class="fa-solid fa-lock"></i>
                            <span class="item-text">Change Password</span>
                            <span class="item-tooltip">Change Password</span>
                        </a>
                    </li>
                    <li class="item">
                        <a href="logout.php">
                            <i class="fa-solid fa-key"></i>
                            <span class="item-text">Logout</span>
                            <span class="item-tooltip">Logout</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</aside>