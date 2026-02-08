<?php
include("header.php");
$j = $_SESSION['recipientDetails'];
if($j[0] == ""){
	echo"<script>window.location.href='wire';</script>";
    die();
}
$country = $j[0]; $state = $j[1]; $city = $j[2]; $address = $j[3]; $zipcode = $j[4]; $email = $j[5]; $phone = $j[6]; $fullname = $j[7]; $type = $j[8]; $iban = $j[9]; $accounttype = $j[10]; $accountholder = $j[11]; $bankname = $j[12]; $phone = $j[14]; $swiftcode = $j[15]; $accountnumber = $j[16];
$dated = date("d M Y");
$query = $conn->query("INSERT INTO wire (userid, country, state, city, address, zipcode, email, phone, type, iban, fullname, account, accountholder, accounttype, bankname, datecreated, swiftcode) VALUES ('$userid', '$country', '$state', '$city', '$address', '$zipcode', '$email', '$phone', '$type', '$iban', '$fullname', '$accountnumber', '$accountholder', '$accounttype', '$bankname', '$dated', '$swiftcode')");
?>
<div class="nk-content">
    <div class="container-fluid p-2">
           <div class="modal-content">
                <div class="modal-body modal-body-lg text-center">
                    <div class="nk-modal">
                        <em class="nk-modal-icon icon icon-circle icon-circle-xxl ni ni-check bg-success"></em>
                        <h4 class="nk-modal-title">Recipient has been successfully added.</h4>
                        <div class="nk-modal-text">
                            <p class="caption-text">sending money to new and existing international recipients is now fast and even more convenient through <?php echo$sitename ?>'s internet banking!
                            </p>
                            <p class="sub-text-sm">Recipient's details are shown below;</a></p>
                        </div>
                            <ul class="buysell-overview-list">
                                <li class="buysell-overview-item">
                                   <span class="pm-title">Recipient Name</span>
                                    <span class="pm-currency"></em> 
                                   <span><?php echo $fullname ?></span></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Transfer Type</span>
                                    <span class="pm-currency"><?php echo $type?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Account #</span>
                                    <span class="pm-currency"><?php echo $accountnumber ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">IBAN</span>
                                    <span class="pm-currency"><?php echo $iban ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Bank name</span>
                                    <span class="pm-currency"><?php echo $bankname ?></span>
                                </li>
                                <li class="buysell-overview-item">
                                    <span class="pm-title">Recipient Email</span>
                                    <span class="pm-currency"><?php echo $email ?></span>
                                </li>
                            </ul>
                        </div>
                       <div class="nk-modal-action-lg">
                            <ul class="btn-group gx-4">
                                <li>
                                	<a href="dashboard" class="btn btn-lg btn-mw btn-success">Home</a> 
                                	<a href="wire" class="btn btn-lg btn-mw btn-primary">Make a Cross-border transfer</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!-- .modal-body -->
            </div><!-- .modal-content -->
      </div>
 </div>


<?php include("footer.php"); 
unset($_SESSION['recipientDetails']);
?>