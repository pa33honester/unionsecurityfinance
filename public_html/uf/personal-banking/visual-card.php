<?php include_once 'header.php'; ?>
<?php if(isset($_GET['cardList'])){ ?>
 <!-- content @s -->
                <div class="nk-content nk-content-fluid">
                    <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-head-sub"><span>Visual Card</span> </div>
                                <div class="nk-block-between-md g-4">
                                    <div class="nk-block-head-content">
                                        <h2 class="nk-block-title fw-normal">Visual Card Magement</h2>
                                        <div class="nk-block-des">
                                            <p>A fall back option for customers who have forgotten or lost their Card, but need to perform urgent online purchase.</p>
                                        </div>
                                    </div>
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="nk-block-head-sm">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title title">Available cards</h5>
                                    </div>
                                </div>
                                <div class="row g-gs">
                                	<?php $query = $conn->query("SELECT * FROM visual_cards WHERE userid = '$userid'");
                                     while($cardData = mysqli_fetch_array($query)){
                                     	if($cardData['card_type'] == "mastercard"){
                                     		$icon = '<em class="icon ni ni-master-card text-danger"></em>';
                                     		$carder = '<em class="icon ni ni-master-card h1 text-white"></em>';
                                     		$carder2 = '<em class="icon ni ni-master-card h1 text-primary"></em>';
                                     	}
                                     	if($cardData['card_type'] == "visa"){
                                     		$icon = '<em class="icon ni ni-visa-alt h3 text-primary"></em>';
                                     		$carder = '<em class="icon ni ni-visa h1 text-white"></em>';
                                     		$carder2 = '<em class="icon ni ni-visa h1 text-primary"></em>';
                                     	}
                                     	if($cardData['card_type'] == "discover"){
                                     		$icon = '<em class="icon ni ni-discover  text-white"></em>';
                                     		$carder = '<em class="icon ni ni-cc-discover h1 text-white"></em>';
                                     		$carder2 = '<em class="icon ni ni-cc-discover h1 text-primary"></em>';
                                     	}

                                     	if($cardData['status'] == 'active'){
                                     		$s1 = "active";
                                     		$s2 = 'success';
                                     	}
                                     	if($cardData['status'] == 'pending'){
                                     		$s1 = "Inactive";
                                     		$s2 = 'danger';
                                     	}
                                     	if($cardData['status'] == 'inactive'){
                                     		$s1 = "Inactive";
                                     		$s2 = 'danger';
                                     	}
                                	 ?>                                	 
                                    <div class="col-sm-12 col-lg-6 col-xl-6 col-xxl-6">
                                        <div class="card card-bordered is-dark">
                                            <div class="nk-wgw">
                                                <div class="nk-wgw-inner">
                                                    <a class="nk-wgw-name" href="#">
                                                        <div class="nk-wgw-icon ">
                                                          <?php echo $icon ?>  
                                                        </div>
                                                        <h5 class="nk-wgw-title title"><?php echo strtoupper($cardData['card_type']) ?></h5>
                                                    </a>
                                                    <div class="nk-wgw-balance">
                                                        <div class="amount"><?php echo$cardData['card_number'] ?></div>
                                                        <div class="tranx-date">VALID THRU <span class="text-white"><?php echo$cardData['expiry_date']; ?></span> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span class="text-center">CCV:<span class="text-white"><?php echo$cardData['ccv']; ?></span></div>
                                                        <span class="text-white text-center"><?php echo strtoupper($cardData['fullname']); ?></span>
                                                        <div class="tranx-date">Bal:<span class="currency currency-usd"><?php echo$cardData['balance'] ?> <?php echo$money ?></span></div>

                                                    </div>
                                                </div>
                                                <div class="nk-wgw-actions">
                                                    <ul>
                                                       <li><a href="#"><em class="icon ni ni-check-circle-fill text-<?php echo$s2 ?>"></em> <span><?php echo$s1 ?></span></a></li>
                                              <li><a href="#" <?php echo "data-toggle='modal' data-target='#addFund".$cardData['id']."'";
 ?>><em class="icon ni ni-plus"></em><span>Add Fund</span></a></li>
                                                    </ul>
                                                </div>
                                                <div class="nk-wgw-more dropdown">
                                                    <a href="#"><?php echo$carder ?></a>
                                                </div>
                                            </div>
                                        </div><!-- .card -->
                                    </div><!-- .col -->
  <!--- Add Fund to Card------->
 <div class="modal fade" tabindex="-1" id="addFund<?php echo$cardData['id'] ?>" >
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body modal-body-lg">
                    <div class="nk-block-head nk-block-head-xs text-center">
                    	<?php echo$carder2 ?>
                        <h5 class="nk-block-title">Fund Visual Card*</h5>
                        <div class="nk-block-text">
                    </div>
                    <div class="nk-block">
                        <div class="buysell-field form-group">
                            <div class="form-label-group">
                                <label class="form-label">Choose payment account</label>
                            </div>
                               <input type="hidden" value="btc" name="bs-currency" id="buysell-choose-currency-modal">
                            <div class="dropdown buysell-cc-dropdown">
                                <a href="#" class="buysell-cc-choosen dropdown-indicator" data-toggle="dropdown">
                                    <div class="coin-item coin-btc">
                                        <div class="coin-icon">
                                            <em class="icon ni ni-wallet-out"></em>
                                        </div>
                                        <div class="coin-info">
                                            <span class="coin-name"><?php echo$accounttype ?></span>
                                            <span class="coin-text">Balance(<?php echo$money; echo$accountbalance ?>)</span>
                                        </div>
                                    </div>
                                </a>
                            <div class="dropdown-menu dropdown-menu-auto dropdown-menu-mxh">
                                    <ul class="buysell-cc-list">
                                        <li class="buysell-cc-item selected">
                                            <a href="#" class="buysell-cc-opt" data-currency="btc">
                                                <div class="coin-item coin-btc">
                                                    <div class="coin-icon">
                                                        <em class="icon ni ni-wallet-out"></em>
                                                    </div>
                                                    <div class="coin-info">
                                                        <span class="coin-name"><?php echo$accounttype ?></span>
                                                        <span class="coin-text"><?php echo substr($accountnumber, 0,4); echo"*****"; ?></span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li> <!-- .buysell-cc-item -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <form action="" method="post">
                         <div class="buysell-field form-group">
                            <div class="form-label-group">
                              <label class="form-label" for="buysell-amount">Amount</label>
                                </div>
                                  <div class="form-control-group">
                                    <input type="number" step="any" class="form-control form-control form-control-number" max="<?php echo$loan_maxi;  ?>" name="amount<?php echo$cardData['id']?>" id="amount<?php echo$cardData['id']?>" placeholder="200.00" required>
                                          <div class="form-dropdown">
                                               <div class="text"><?php echo $money ?></div>  
                                           </div>
                                       </div>
                                            <div class="form-note-group">
                                                <span class="buysell-rate form-note-alt">Maximum Daily Limit:<?php echo number_format($loan_maxi); echo " $money"; ?></span>
                                            </div>
                                        </div><!-- .buysell-field -->
   
                          <div class="form-group">
                             <div class="form-label-group">
                                <label class="form-label"><?php echo$cardData['question']; ?> <span class="text-danger">*</span></label>
                              </div>
                              <div class="form-control-group">
                                <input type="password" name="answer<?php echo$cardData['id']?>" id="answer<?php echo$cardData['id']?>" placeholder="Enter answer"  required class="form-control form-control-lg">
                            </div>
                         </div>
                         <div class="addFundResult<?php echo$cardData['id'] ?>"></div>
                         <hr>
                         <div class="form-control-group">
                        	 <button class="btn btn-primary addFundBtn<?php echo$cardData['id'] ?> btn-block"id="btn<?php echo$cardData['id']?>" type="submit">Add Fund</button>
                            <div class="pt-3">
                                <a href="#" data-dismiss="modal" class="btn btn-sm btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
          </div>
         </div>
             <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>    
    <script type="text/javascript">
     $(document).ready(function () {
    $('.addFundBtn<?php echo$cardData['id'] ?>').click(function (e) {
      e.preventDefault();
      document.getElementById("btn<?php echo$cardData['id']?>").disabled = true;	
      var amount<?php echo$cardData['id']?> = $('#amount<?php echo$cardData['id']?>').val();
      var answer<?php echo$cardData['id']?> = $('#answer<?php echo$cardData['id']?>').val();
       $.ajax
        ({
          type: "POST",
          url: "../scripts/auth?action=addFund&cardid=<?php echo$cardData['id'] ?>",
          data: {"amount<?php echo$cardData['id']?>": amount<?php echo$cardData['id'] ?>, "answer<?php echo$cardData['id']?>": answer<?php echo$cardData['id'] ?>, },
          success: function (data) {
          	document.getElementById("btn<?php echo$cardData['id']?>").disabled = false;
            $('.addFundResult<?php echo$cardData['id'] ?>').html(data);
          }
        });
    });
  });
    </script>
                                <?php } ?>
                                </div><!-- .row -->
                            </div>
                        </div>
                    </div>
                </div>

	<?php } else { ?>
                <div class="nk-content nk-content-fluid">
                    <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="kyc-app wide-sm m-auto">
                                <div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
                                    <div class="nk-block-head-content text-center">
                                        <h2 class="nk-block-title fw-normal">Visual Debit Card</h2>
                                        <div class="nk-block-des">
                                            <p>Specially designed for your online transactions.</p>
                                        </div>
                                    </div>
                                </div><!-- nk-block-head -->
                                <div class="nk-block">
                                    <div class="card card-bordered">
                                        <div class="card-inner card-inner-lg">
                                            <div class="nk-kyc-app p-sm-2 text-center">
                                                <div class="nk-kyc-app-icon">
                                                    <em class="icon ni ni-cc-new text-primary"></em>
                                                </div>
                                                <div class="nk-kyc-app-text mx-auto">
                                                    <p class="lead">The <?php echo$sitename ?> Virtual Debit  Card is a digital payment card designed to facilitate frequent online shoppers with a secure and flexible alternative to physical payment cards. The virtual card is instantly issued opon request.</p>
                                                </div>
                                                <div class="nk-kyc-app-action">
                                                    <a href="card_application" class="btn btn-lg btn-primary"><em class="icon ni ni-cc-new"></em> Request for a New Virtual Card</a> 
                                                </div>
                                                 <p class="nk-kyc-app-action" style="margin-top: 10px;">
                                                 <?php if(getCardStatus($userid) !=0){ ?>
                                                  <a href="visual-card?cardList=manage" class="btn btn-lg btn-default border-dark"><em class="icon ni ni-cc-secure"></em> Manage Existing Visual Cards</a>  
                                                  <?php } ?>
                                                 </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center pt-4">
                                        <p>If you have any question, please contact our support team <a href="mailto:<?php echo$siteemail ?>"><?php echo$siteemail ?></a></p>
                                    </div>
                                </div><!-- nk-block -->
                            </div><!-- kyc-app -->
                        </div>
                    </div>
                </div>
            <?php } ?>
<?php include_once 'footer.php'; ?>