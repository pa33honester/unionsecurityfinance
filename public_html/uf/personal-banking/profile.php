<?php include("header.php"); ?>

<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <div class="nk-block-head-sub"><span>Account Setting</span></div>
                    <h2 class="nk-block-title fw-normal">My Profile</h2>
                    <div class="nk-block-des">
                        <p>
                            You have full control to manage your own account setting.
                            <span class="text-primary">
                                <em class="icon ni ni-info" data-toggle="tooltip" data-placement="right"></em>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <ul class="nk-nav nav nav-tabs">
                <li class="nav-item"><a class="nav-link" href="profile">Personal</a></li>
                <li class="nav-item"><a class="nav-link" href="account-setting">Security</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Notifications</a></li>
            </ul>

            <div class="nk-block">

                <div class="alert alert-warning">
                    <p>
                        When you're on public Wi-Fi, hackers can more easily access your computer.
                        Always use a secure network when accessing online banking.
                    </p>
                </div>

                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Personal Information</h5>
                        <p>Basic info, like your name and address, that you use on <?php echo $sitename; ?>.</p>
                    </div>
                </div>

                <!-- BASICS -->
                <div class="nk-data data-list">
                    <div class="data-head">
                        <h6 class="overline-title">Basics</h6>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Full Name</span>
                            <span class="data-value"><?php echo $fullname; ?></span>
                        </div>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Display Name</span>
                            <span class="data-value"><?php echo $middlename; ?></span>
                        </div>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Email</span>
                            <span class="data-value"><?php echo $email; ?></span>
                        </div>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Phone Number</span>
                            <span class="data-value"><?php echo $phone; ?></span>
                        </div>
                    </div>

                    <!-- NEXT OF KIN (FIXED & WORKING) -->
                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Next of Kin</span>
                            <span class="data-value"><?php echo $next_of_kin; ?></span>
                        </div>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Next of Kin Phone</span>
                            <span class="data-value"><?php echo $next_of_kin_phone; ?></span>
                        </div>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Relationship</span>
                            <span class="data-value"><?php echo $next_of_kin_relationship; ?></span>
                        </div>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Security Question</span>
                            <span class="data-value"><?php echo $securityQuestion; ?></span>
                        </div>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Security Answer</span>
                            <span class="data-value"><?php echo $answer; ?></span>
                        </div>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Address</span>
                            <span class="data-value"><?php echo $address; ?></span>
                        </div>
                    </div>
                </div>

                <!-- PREFERENCES -->
                <div class="nk-data data-list">
                    <div class="data-head">
                        <h6 class="overline-title">Preferences</h6>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Language</span>
                            <span class="data-value">English (<?php echo $sitecountry; ?>)</span>
                        </div>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Date Format</span>
                            <span class="data-value">M d, YYYY</span>
                        </div>
                    </div>

                    <div class="data-item">
                        <div class="data-col">
                            <span class="data-label">Current Timezone</span>
                            <span class="data-value"><?php getTimezone(); ?></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
