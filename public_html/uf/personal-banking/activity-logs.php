<?php include("header.php"); ?>
<div class="nk-content nk-content-fluid">
                   
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

                                             $query=$conn->query("SELECT * FROM login WHERE userid = '$userid' ORDER BY id DESC LIMIT 100");
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