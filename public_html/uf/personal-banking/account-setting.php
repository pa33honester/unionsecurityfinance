<?php include("header.php"); ?>
<div class="nk-content nk-content-fluid">
                    <div class="nk-block">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title">Security Settings</h5>
                                        <div class="nk-block-des">
                                            <p>These settings are helps you keep your <?php echo$sitename ?> account secure.</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="card card-bordered">
                                    <div class="card-inner-group">
                                        <div class="card-inner">
                                            <div class="between-center flex-wrap flex-md-nowrap g-3">
                                                <div class="nk-block-text">
                                                    <h6>Save my Activity Logs</h6>
                                                    <p>You can save all activity logs including unusual activity detected.</p>
                                                </div>
                                                <div class="nk-block-actions">
                                                    <ul class="align-center gx-3">
                                                        <li class="order-md-last d-inline-flex">
                                                            <div class="custom-control custom-switch mr-n2">
                                                                <input type="checkbox" class="custom-control-input" id="activity-log">
                                                                <label class="custom-control-label" for="activity-log"></label>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <a href="activity-logs" class="link link-sm link-primary">See Recent Activity</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div><!-- .card-inner -->
                                        <div class="card-inner">
                                            <div class="between-center flex-wrap flex-md-nowrap g-3">
                                                <div class="nk-block-text">
                                                    <h6>Security Pin Code</h6>
                                                    <p>You can set your pin code, we will ask you this code during login attempts and transactions.</p>
                                                </div>
                                                <div class="nk-block-actions">
                                                    <div class="custom-control custom-switch mr-n2">
                                                        <input type="checkbox" checked="" class="custom-control-input" id="security-pin">
                                                        <label class="custom-control-label" for="security-pin"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .card-inner -->
                                        <div class="card-inner">
                                          
                                        </div><!-- .card-inner -->
                                        <div class="card-inner">
                                            <div class="between-center flex-wrap flex-md-nowrap g-3">
                                                <div class="nk-block-text">
                                                    <h6>2FA Authentication <span class="badge badge-success">Enabled</span></h6>
                                                    <p>Secure your account with 2FA security. When it is activated you will need to enter not only your password, but also a special code using app. You can receive this code by in mobile app. </p>
                                                </div>

                                            </div>
                                        </div><!-- .card-inner -->
                                    </div><!-- .card-inner-group -->
                                </div><!-- .card -->
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-head-content">
                                        <div class="nk-block-title-group">
                                            <h6 class="nk-block-title title">Recent Activity</h6>
                                            <a href="activity-logs" class="link">See full log</a>
                                        </div>
                                        <div class="nk-block-des">
                                            <p>This information about recent login activity on your account.</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-head -->
                                <div class="card card-bordered">
                                    <table class="table table-ulogs">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="tb-col-os"><span class="overline-title">Browser <span class="d-sm-none">/ IP</span></span></th>
                                                <th class="tb-col-ip"><span class="overline-title">IP</span></th>
                                                <th class="tb-col-time"><span class="overline-title">Time</span></th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<?php include("../scripts/connect.php");

                                             $query=$conn->query("SELECT * FROM login WHERE userid = '$userid' ORDER BY id DESC LIMIT 20");
                                             while($row = mysqli_fetch_assoc($query)){


                                        	 ?>
                                            <tr>
                                                <td class="tb-col-os"><?php echo "".$row['browser']."" ?></td>
                                                <td class="tb-col-ip"><span class="sub-text"><?php echo "".$row['ip']."" ?></span></td>
                                                <td class="tb-col-time"><span class="sub-text"><?php echo "".$row['dated']."" ?></span></td>
                                                
                                            </tr>
                                           <?php } ?>
                                        </tbody>
                                    </table>
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div>
                    </div>
                </div>
            </div>
<?php include("footer.php"); ?>