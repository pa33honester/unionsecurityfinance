<?php
include("header.php");
if (empty($_GET['verification'])) {
    echo "<script>window.location.href='wire';</script>";
}else{
    
    $_SESSION['wireImfCounter'] = $imf_cot_counter;
    $_SESSION['wireCotCounter'] = $imf_cot_counter;
    $_SESSION['tacCounter'] = $imf_cot_counter;
    $_SESSION['tinCounter'] = $imf_cot_counter;
    $_SESSION['icCounter'] = $imf_cot_counter;
    
}
?>

<?php if ($_GET['verification'] == "imf") {
?>
   <div class="nk-content">
   <?php echo $stockrate?>
              <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="buysell wide-xs m-auto">
                                <div class="buysell-title text-center">
                                    <h1 class="text-center text-danger display-1"><em class="icon ni ni-alert-circle"></em></h1>
                                  <h2 class="title">Before you proceed!</h2>
                                </div><!-- .buysell-title -->
                                <div class="buysell-block">
                                    <form action="#" method="post" class="buysell-form">
                                        <div class="BillOtpResult"></div>
                                        <div class="buysell-field form-group">
                                            <div class="form-label-group">
                                                <strong class="form-label text-danger text-left">
                                                <?php echo $imfMsg; ?> 
                                                </strong>
                                            </div>
                                        </div><!-- .buysell-field -->
                                        <div class="buysell-field form-group">
                                            <div class="">
                                                <label class="form-label font-weight-bold" for="">Enter IMF Code:</label>
                                            </div>
                                            <form action="" method="post" id="otpForm">
                                <div class="form-control-group"> 
                             <input type="text" class="form-control form-control-lg form-control-number" id="imf" name="imf" placeholder="*******"> 
                          <div class="form-dropdown"> 
                            <div class="text">IMF Code<span></span></div> 
                                    </div>
                               </div>
                                        <div class="">
                                            </div>
                                        </div></center>
                                        <div class="card card-bordered text-muted p-2">We have security measures in place to safeguard your money, because we are committed to providing you with a secure banking experience.</div>
                                        <div class="wireImfResult"></div>
                                        <div class="buysell-field form-action">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary WireimfBtn">Verify IMF</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php include("footer.php") ?>
<?php } ?>

<?php if ($_GET['verification'] == "cot") {
?>
<div class="nk-content">
      <?php echo $stockrate?>
              <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="buysell wide-xs m-auto">
                                <div class="buysell-title text-center">
                                    <h1 class="text-center text-danger display-1"><em class="icon ni ni-lock-alt-fill"></em></h1>
                                  <h2 class="title">Cost Of Transfer Code is Required.</h2>
                                </div><!-- .buysell-title -->
                                <div class="buysell-block">
                                    <form action="#" method="post" class="buysell-form">
                                        <div class="BillOtpResult"></div>
                                        <div class="buysell-field form-group">
                                            <div class="form-label-group">
                                                <strong class="form-label text-danger text-left">
                                                <?php echo $cotMsg; ?> 
                                                </strong>
                                            </div>
                                        </div><!-- .buysell-field -->
                                        <div class="buysell-field form-group">
                                            <div class="">
                                                <label class="form-label font-weight-bold" for="">Enter COT Code:</label>
                                            </div>
                                            <form action="" method="post">
                                <div class="form-control-group"> 
                             <input type="text" placeholder="******" class="form-control form-control-lg form-control-number" id="cot" name="cot"> 
                          <div class="form-dropdown"> 
                            <div class="text">COT Code<span></span></div> 
                                    </div>
                               </div>
                                        <div class="">
                                            </div>
                                        </div></center>
                                        <div class="card card-bordered text-muted p-2">We have security measures in place to safeguard your money, because we are committed to providing you with a secure banking experience.</div>
                                        <div class="wireCotResult"></div>
                                        <div class="buysell-field form-action">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary WirecotBtn">Verify COT</a>
                                        </div><!-- .buysell-field -->
                                    </form><!-- .buysell-form -->
                                </div><!-- .buysell-block -->
                            </div><!-- .buysell -->
                        </div>
                    </div>
                </div>

<?php include("footer.php") ?>
<?php } ?>
<?php if ($_GET['verification'] == "tac") {
?>
<div class="nk-content">
      <?php echo $stockrate?>
              <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="buysell wide-xs m-auto">
                                <div class="buysell-title text-center">
                                    <h1 class="text-center text-danger display-1"><em class="icon ni ni-lock-alt-fill"></em></h1>
                                  <h2 class="title">Transfer Authorization Code is required.</h2>
                                </div><!-- .buysell-title -->
                                <div class="buysell-block">
                                    <form action="#" method="post" class="buysell-form">
                                        <div class="BillOtpResult"></div>
                                        <div class="buysell-field form-group">
                                            <div class="form-label-group">
                                                <strong class="form-label text-danger text-left">
                                                <?php echo $tacMsg; ?> 
                                                </strong>
                                            </div>
                                        </div><!-- .buysell-field -->
                                        <div class="buysell-field form-group">
                                            <div class="">
                                                <label class="form-label font-weight-bold" for="">Enter Transfer Authorization Code:</label>
                                            </div>
                                            <form action="" method="post">
                                <div class="form-control-group"> 
                             <input type="text" placeholder="******"  class="form-control form-control-lg form-control-number" id="tac" name="tac"> 
                          <div class="form-dropdown"> 
                            <div class="text">TAC<span></span></div> 
                                    </div>
                               </div>
                                        <div class="">
                                            </div>
                                        </div></center>
                                        <div class="card card-bordered text-muted p-2">We have security measures in place to safeguard your money, because we are committed to providing you with a secure banking experience.</div>
                                        <div class="cotResult"></div>
                                        <div class="buysell-field form-action">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary WiretacBtn" id="btn">Verify</a>
                                        </div><!-- .buysell-field -->
                                    </form><!-- .buysell-form -->
                                </div><!-- .buysell-block -->
                            </div><!-- .buysell -->
                        </div>
                    </div>
                </div>
<?php include("footer.php") ?>
<?php } ?>
<?php if ($_GET['verification'] == "ic") {
     if($enable_ic != "Yes"){
         $link = $_SESSION['transaction_session'];
         echo "<script>
         window.location.href='../personal-banking/wire-auth?verification=tin&transferToken=$link';
         </script>";
    } else {}
?>
?>
<div class="nk-content">
      <?php echo $stockrate?>
              <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="buysell wide-xs m-auto">
                                <div class="buysell-title text-center">
                                    <h1 class="text-center text-danger display-1"><em class="icon ni ni-lock-alt-fill"></em></h1>
                                  <h2 class="title">Insurance Code is Required.</h2>
                                </div><!-- .buysell-title -->
                                <div class="buysell-block">
                                    <form action="#" method="post" class="buysell-form">
                                        <div class="BillOtpResult"></div>
                                        <div class="buysell-field form-group">
                                            <div class="form-label-group">
                                                <strong class="form-label text-danger text-left">
                                                <?php echo $icMsg; ?> 
                                                </strong>
                                            </div>
                                        </div><!-- .buysell-field -->
                                        <div class="buysell-field form-group">
                                            <div class="">
                                                <label class="form-label font-weight-bold" for="">Enter Insurance Code:</label>
                                            </div>
                                            <form action="" method="post">
                                <div class="form-control-group"> 
                             <input type="text" placeholder="******" class="form-control form-control-lg form-control-number" id="ic" name="ic"> 
                          <div class="form-dropdown"> 
                            <div class="text">IC<span></span></div> 
                                    </div>
                               </div>
                                        <div class="">
                                            </div>
                                        </div></center>
                                        <div class="card card-bordered text-muted p-2">We have security measures in place to safeguard your money, because we are committed to providing you with a secure banking experience.</div>
                                        <div class="cotResult"></div>
                                        <div class="buysell-field form-action">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary WireicBtn" id="btn">Verify</a>
                                        </div><!-- .buysell-field -->
                                    </form><!-- .buysell-form -->
                                </div><!-- .buysell-block -->
                            </div><!-- .buysell -->
                        </div>
                    </div>
                </div>
<?php include("footer.php") ?>
<?php } ?>


<?php if ($_GET['verification'] == "tin") {
    if($enable_tin != "Yes"){
        $link = $_SESSION['transaction_session'];
        echo "<script>
        window.location.href='../email/wire-otp-mail.php?transferToken=$link';
        </script>";
    } else {}
?>
<div class="nk-content">
      <?php echo $stockrate?>
              <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="buysell wide-xs m-auto">
                                <div class="buysell-title text-center">
                                    <h1 class="text-center text-danger display-1"><em class="icon ni ni-alert-circle"></em></h1>
                                  <h2 class="title">Tax Identification Number is Required.</h2>
                                </div><!-- .buysell-title -->
                                <div class="buysell-block">
                                    <form action="#" method="post" class="buysell-form">
                                        <div class="BillOtpResult"></div>
                                        <div class="buysell-field form-group">
                                            <div class="form-label-group">
                                                <strong class="form-label text-danger text-left">
                                                <?php echo $tinMsg; ?> 
                                                </strong>
                                            </div>
                                        </div><!-- .buysell-field -->
                                        <div class="buysell-field form-group">
                                            <div class="">
                                                <label class="form-label font-weight-bold" for="">Enter TIN:</label>
                                            </div>
                                            <form action="" method="post">
                                <div class="form-control-group"> 
                             <input type="text" placeholder="******" class="form-control form-control-lg form-control-number" id="tin" name="tin"> 
                          <div class="form-dropdown"> 
                            <div class="text">TIN<span></span></div> 
                                    </div>
                               </div>
                                        <div class="">
                                            </div>
                                        </div></center>
                                        <div class="card card-bordered text-muted p-2">We have security measures in place to safeguard your money, because we are committed to providing you with a secure banking experience.</div>
                                        <div class="cotResult"></div>
                                        <div class="buysell-field form-action">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary WiretinBtn" id="btn">Verify</a>
                                        </div><!-- .buysell-field -->
                                    </form><!-- .buysell-form -->
                                </div><!-- .buysell-block -->
                            </div><!-- .buysell -->
                        </div>
                    </div>
                </div>
<?php include("footer.php") ?>
<?php } ?>
<script src="../js/jquery.min.js"></script>
<script type="text/javaScript">
    //IMF AND COT FOR WIRE TRANSFER 
 $(document).ready(function() {
 $('.WirecotBtn').on('click', function() {
 var $this = $(this);
 var loadingText = '<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>&nbsp;Processing...';
 if ($(this).html() !== loadingText) {
 $this.data('original-text', $(this).html());
 $this.html(loadingText);
 }
 setTimeout(function() {
 $this.html($this.data('original-text'));
 },3000);
 });
 });
$(document).ready(function () {
    $('.WirecotBtn').click(function (e) {
      e.preventDefault();
      var cot = $('#cot').val();
      $.ajax
        ({
          type: "POST",
          url: "../scripts/wire-cot.php",
          data: {"cot": cot},
          success: function (data) {
            $('.wireCotResult').html(data);
            $('#form')[0].reset();
          }
        });
    });
  });
$(document).ready(function() {
 $('.WireimfBtn').on('click', function() {
 var $this = $(this);
 var loadingText = '<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>&nbsp;Processing...';
 if ($(this).html() !== loadingText) {
 $this.data('original-text', $(this).html());
 $this.html(loadingText);
 }
 setTimeout(function() {
 $this.html($this.data('original-text'));
 },3000);
 });
 });
$(document).ready(function () {
    $('.WireimfBtn').click(function (e) {
      e.preventDefault();
      var imf = $('#imf').val();
      $.ajax
        ({
          type: "POST",
          url: "../scripts/wire-imf.php",
          data: {"imf": imf},
          success: function (data) {
            $('.wireImfResult').html(data);
            $('#form')[0].reset();
          }
        });
    });
  });

</script>

