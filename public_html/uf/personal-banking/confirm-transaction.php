<?php
include("header.php");
?> 
<div class="nk-content nk-content-fluid">
              <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="buysell wide-xs m-auto">
                                <div class="buysell-title text-center">
                                  <h2 class="title">Complete your transaction!</h2>
                                </div><!-- .buysell-title -->
                                <div class="buysell-block">
                                    <form action="#" method="post" class="buysell-form">
                                        <div class="verifyResult"></div>
                                        <div class="buysell-field form-group">
                                            <div class="form-label-group">
                                                <strong class="form-label text-primary text-center">Please enter the six Digits OTP code sent to the email address or phone number that is associated with your account. </strong>
                                            </div>
                                        </div><!-- .buysell-field -->
                                        <div class="buysell-field form-group">
                                            <div class="form-label-group">
                                                <label class="form-label" for="buysell-amount">Enter OTP:</label>
                                            </div>
                                            <div class="form-control-group">
                                                <input type="number" class="form-control form-control-lg form-control-number" id="otp" name="otp" name="otp" placeholder="000000">
                                                <div class="form-dropdown">
                                                    <div class="text text-primary">OTP<span></span></div>
                                                </div>
                                            </div>
                                            <div class="form-note-group">
                                                <span class="buysell-min form-note-alt">Note: OTP expires in <span class="" id="timer">10:00<<span> minutes</span>
                                            </div>
                                        </div><!-- .buysell-field -->
                                        <div class="buysell-field form-action">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary verifyBtn" id="btn">Verify OTP</a>
                                        </div><!-- .buysell-field -->
                                        <div class="form-note text-base text-center">Note: our transfer fee is included.</div>
                                    </form><!-- .buysell-form -->
                                </div><!-- .buysell-block -->
                            </div><!-- .buysell -->
                        </div>
                    </div>
                </div>
                <script>
         window.onload = function () {
            var minute = 9;
            var sec = 60;
            setInterval(function () {
               document.getElementById("timer").innerHTML =
                  minute + " : " + sec;
               sec--;
               if (sec == 00) {
                  minute--;
                  sec = 60;
                  if (minute == 0) {
                     minute = 9;
                  }
               }
            }, 1000);
         };
      </script>
<?php
	include("footer.php");

?>	