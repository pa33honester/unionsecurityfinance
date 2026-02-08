<?php
include("header.php");
?>

<?php
$j = $_SESSION['payeedetails'];
if($j[0] == ""){
	i_redirect("pay-bills");
    die();
}
$query = $conn->query("INSERT INTO payee (name, method, account, address, city, state, zipcode, userid, ref) VALUES ('$j[0]', '$j[1]', '$j[2]', '$j[3]', '$j[4]', '$j[5]', '$j[6]', '$userid', '$j[7]')");
?>
<div class="nk-content">
    <div class="container-fluid p-2">
           <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                        <h4 class="nk-modal-title">Your Payee has been successfully added.</h4>
                        <div class="nk-modal-text">
                            <p class="caption-text">Paying new and existing payees is now even more convenient through <?php echo$sitename ?>'s internet banking!
                            </p>
                            <p class="sub-text-sm">Details of the payee are as below;</a></p>
                        </div>
                            <ul class="buysell-overview-list">
                                <li class="buysell-overview-item">
                                   <span class="pm-title">Payee Name</span>
                                    <span class="pm-currency"></em> 
                                   <span><?php echo $j[0] ?></span></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Delivery Method</span>
                                    <span class="pm-currency"><?php echo $j[1] ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Account #</span>
                                    <span class="pm-currency"><?php echo $j[2] ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Address</span>
                                    <span class="pm-currency"><?php echo $j[3] ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">city</span>
                                    <span class="pm-currency"><?php echo $j[4] ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">State</span>
                                    <span class="pm-currency"><?php echo $j[5] ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Zipcode</span>
                                    <span class="pm-currency"><?php echo $j[6] ?></span>
                                </li>
                            </ul>
                        </div>
                       <div class="nk-modal-action-lg">
                            <ul class="btn-group gx-4">
                                <li>
                                	<a href="dashboard" class="btn btn-lg btn-mw btn-success">Home</a> 
                                	<a href="pay-bills" class="btn btn-lg btn-mw btn-primary">Pay a bill</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
      </div>
 </div>
<?php
include("footer.php");
unset($_SESSION['payeedetails']);
 ?>