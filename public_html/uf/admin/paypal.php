<?php
require_once('header.php');
?>
<!-- content @s -->
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-head-sub"><span>Account Assets</span> </div>
                <div class="nk-block-between-md g-4">
                    <div class="nk-block-head-content">
                        <h2 class="nk-block-title fw-normal">PayPal Withdrawals</h2>
                        <div class="nk-block-des">
                            <p>Account Assets Management</p>
                        </div>
                    </div>
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools gx-3">
                            <li><a href="users" class="btn btn-primary"><span>Back</span> <em class="icon ni ni-arrow-long-left"></em></a></li>
                        </ul>
                    </div>
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <?php
            if ($_GET['action'] == "withrawal_requests") { ?>
                <div class="card card-preview">
                    <div class="card-inner">
                        <table class="datatable-init nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                            <thead>
                                <tr class="nk-tb-item nk-tb-head">
                                    <th class="nk-tb-col nk-tb-col-check">
                                        <div class="custom-control custom-control-sm custom-checkbox notext">
                                            <input type="checkbox" class="custom-control-input" id="uid">
                                            <label class="custom-control-label" for="uid"></label>
                                        </div>
                                    </th>

                                    <th class="nk-tb-col"><span class="sub-text">Currency</span></th>
                                    <th class="nk-tb-col"><span class="sub-text">Transaction ID</span></th>
                                    <th class="nk-tb-col"><span class="sub-text">User</span></th>
                                    <th class="nk-tb-col tb-col-mb"><span class="sub-text">Amount</span></th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Paypal Address</span></th>
                                    <th class="nk-tb-col tb-col-md"><span class="sub-text">Date</span></th>
                                    <th class="nk-tb-col tb-col-lg"><span class="sub-text">Action</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = $conn->query("SELECT * FROM paypal_withdrawals WHERE status = 'pending' ORDER BY id DESC");
                                while ($rows = mysqli_fetch_array($query)) {
                                    $userid3 = $rows['userid'];
                                    $id = $rows['id'];
                                    $query3 = $conn->query("SELECT * FROM users WHERE id = '$userid3'");
                                    $user = mysqli_fetch_array($query3);
                                ?>

                                    <tr class="nk-tb-item">
                                        <td class="nk-tb-col nk-tb-col-check">
                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                <input type="checkbox" class="custom-control-input" id="<?php echo $id ?>">
                                                <label class="custom-control-label" for="<?php echo $id ?>"></label>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col">
                                            <div class="user-card">
                                                <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                                    <span><?php echo $rows['currency']; ?></span>
                                                </div>
                                                <div class="user-info">
                                                    <span class="tb-lead"><?php echo $rows['currency'] ?><span class="dot dot-success d-md-none ml-1"></span></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                                            <span class="tb-amount"><?php echo "" . $rows['transactionId']; ?></span>
                                        </td>
                                        <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                                            <span class="tb-amount"><?php echo "" . $user['firstname'] . " " . $user['lastname'] . " " . $user['middlename'] . ""; ?></span>
                                        </td>
                                        <td class="nk-tb-col tb-col-mb" data-order="35040.34">
                                            <span class="tb-amount"><?php echo $money ?> <span class="currency"><?php echo $rows['amount'] ?></span></span>
                                        </td>
                                        <td class="nk-tb-col tb-col-md">
                                            <span><?php echo $rows['toEmail'] ?></span>
                                        </td>
                                        <td class="nk-tb-col tb-col-md">
                                            <span><?php echo date('Y-m-d H:i:s', $rows['createdAt']); ?></span>
                                        </td>
                                        <td class="nk-tb-col nk-tb-col-tools">
                                            <ul class="nk-tb-actions gx-1">
                                                <li class="nk-tb-action">
                                                    <a href="#" class="btn btn-trigger btn-icon" <?php echo "data-toggle='modal' data-target='#approve" . $id . "'"; ?> data-placement="top" title="Approve">
                                                        <em class="icon ni ni-wallet-fill text-success"></em>
                                                    </a>
                                                </li>
                                                <li class="nk-tb-action">
                                                    <a href="#" class="btn btn-trigger btn-icon" data-placement="top" title="Reject" <?php echo "data-toggle='modal' data-target='#reject" . $id . "'"; ?>>
                                                        <em class="icon ni ni-external text-danger"></em>
                                                    </a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <!--- Accept Crypto Withdrawal------->
                                    <div class="modal fade" tabindex="-1" id="approve<?php echo $id ?>">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <a href="#" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                    <em class="icon ni ni-cross"></em>
                                                </a>
                                                <div class="modal-header text-white" style="background-color:#033d75; color: white;">
                                                    <h5 class="modal-title">Approve Withdrawal</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <strong>You are about to Approve <?php echo $money;
                                                                                        echo " ";
                                                                                        echo $rows['amount'] ?> Withdrawal request Made by <?php echo "" . $user['firstname'] . " " . $user['lastname'] . " " . $user['middlename'] . ""; ?> </strong>
                                                </div>
                                                <form action="" method="post">
                                                    <div class="approve_result_<?php echo $id ?>"></div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" name="f<?php echo $id ?>" value="<?php echo $id ?>" id="f<?php echo $id ?>">
                                                        <button type="submit" class="btn btn-primary btn-sm approveBtn_<?php echo $id ?>">Approve</button>
                                                        <button class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                    </div>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('.approveBtn_<?php echo $id ?>').click(function(e) {
                                e.preventDefault();
                                var f<?php echo $id ?> = $('#f<?php echo $id ?>').val();
                                $.ajax({
                                    type: "POST",
                                    url: "../scripts/auth.php?action=approvePaypalWithdrawal&id=<?php echo $id ?>&amount=<?php echo $rows['amount'] ?>&userid=<?php echo $userid3 ?>",
                                    data: {
                                        "f<?php echo $id ?>": f<?php echo $id ?>,
                                    },
                                    success: function(data) {
                                        $('.approve_result_<?php echo $id ?>').html(data);
                                    }
                                });
                            });
                        });
                    </script>

                    <!--- Reject Crypto Withdrawal------->
                    <div class="modal fade" tabindex="-1" id="reject<?php echo $id ?>">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <a href="#" class="close text-white" data-dismiss="modal" aria-label="Close">
                                    <em class="icon ni ni-cross"></em>
                                </a>
                                <div class="modal-header text-white" style="background-color:#033d75; color: white;">
                                    <h5 class="modal-title">Reject Withdrawal</h5>
                                </div>
                                <div class="modal-body">
                                    <strong>You are about to Reject <?php echo $money;
                                                                    echo " ";
                                                                    echo $rows['amount'] ?> Withdrawal request Made by <?php echo "" . $user['firstname'] . " " . $user['lastname'] . " " . $user['middlename'] . ""; ?> </strong>
                                </div>
                                <form action="" method="post">
                                    <div class="reject_result<?php echo $id ?>"></div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="f<?php echo $id ?>" value="<?php echo $id ?>" id="f<?php echo $id ?>">
                                        <button type="submit" class="btn btn-primary btn-sm rejectBtn<?php echo $id ?>">Reject</button>
                                        <button class="btn btn-danger btn-sm" data-dismiss="modal">Cancel</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.rejectBtn<?php echo $id ?>').click(function(e) {
                            e.preventDefault();
                            var f<?php echo $id ?> = $('#f<?php echo $id ?>').val();
                            $.ajax({
                                type: "POST",
                                url: "../scripts/auth.php?action=rejectCryptoWithdrawal&id=<?php echo $id ?>&amount=<?php echo $rows['amount'] ?>&userid=<?php echo $userid3 ?>&coin=<?php echo $coin ?>",
                                data: {
                                    "f<?php echo $id ?>": f<?php echo $id ?>,
                                },
                                success: function(data) {
                                    $('.reject_result<?php echo $id ?>').html(data);
                                }
                            });
                        });
                    });
                </script>
            <?php } ?>
            </div><!-- .card-preview -->

<?php } else {
            
            } ?>
</div>


<?php
require_once('footer.php');
?>