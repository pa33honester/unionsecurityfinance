<?php 
require_once('header.php');

?>
 <div class="nk-content nk-content-fluid">
    <div class="card card-bordered">
               <div class="card-header font-weight-bold text-light" style="background-color:#033d75;">Security Setting</div>
          <div class="card-inner">
        <h5 class="card-title">Reset/Change your <?php echo $sitename ?> account password*</h5>
        <hr>
        <form action="" method="post" class="buysell-form" > 
          <!-- .buysell-field --> 
           <div class="buysell-field form-group row">
             <div class="col-lg-12 col-sm-12 p-2">
             <div class="form-group">
               <div class="form-control-wrap">
                <div class="form-icon form-icon-right">
                  <em class="icon ni ni-lock-fill"></em>
                </div>
               <input type="password" class="form-control form-control-xl form-control-outlined" id="cpassword" name="cpassword">
              <label class="form-label-outlined" for="outlined-right-icon">Current Password</label>
             </div>
             </div>
          </div>
           <div class="col-lg-6 col-sm-6 p-2">
             <div class="form-group">
               <div class="form-control-wrap">
                <div class="form-icon form-icon-right">
                  <em class="icon ni ni-security"></em>
                </div>
               <input type="password" class="form-control form-control-xl form-control-outlined"  id="npassword" name="npassword">
              <label class="form-label-outlined" for="outlined-right-icon">New password</label>
             </div>
             </div>
          </div>
           <div class="col-lg-6 col-sm-6 p-2">
             <div class="form-group">
               <div class="form-control-wrap">
                <div class="form-icon form-icon-right">
                  <em class="icon ni ni-security"></em>
                </div>
               <input type="password" class="form-control form-control-xl form-control-outlined"  id="cnpassword" name="cnpassword">
              <label class="form-label-outlined" for="outlined-right-icon">Confirm New Password</label>
             </div>
             </div>
          </div>
          <div class="cardResult"></div>
          <div class="col-lg-12 col-sm-12 p-2">
             <div class="form-group">
                <button class="btn btn-primary btn-block cardBtn">Reset Password</button>
             </div>
          </div>
    </div>
  </form>
      <!-- .buysell-form -->
    </div>
</div>
</div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
 $('.cardBtn').on('click', function() {
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
 })
$(document).ready(function () {
    $('.cardBtn').click(function (e) {
      e.preventDefault();
      var cpassword = $('#cpassword').val();
      var npassword = $('#npassword').val();
      var cnpassword = $('#cnpassword').val();
      $.ajax
        ({
          type: "POST",
          url: "../scripts/auth.php?action=user_pass_reset",
          data: {"cpassword": cpassword, "npassword": npassword, "cnpassword": cnpassword},
          success: function (data) {
            $('.cardResult').html(data);
            $('#form')[0].reset();
          }
        });
    });
  });
</script>
<?php 
require_once('footer.php');

?>