<?php
include("header.php");
$j = $_SESSION['paymentdetails'];
$otp = $j[6];
if(empty($otp)){
  echo"<script>window.location.href='../personal-banking/pay-bills'; </script>";}
  else{}
$j = $_SESSION['paymentdetails'];
$otp = $j['6'];
?>
<style>
      input[type=number] {
          height: 50px;
          width: 50px;
          font-size: 25px;
          color: #033d75;
          text-align: center;
          border: 3px solid #033d75;
          box-shadow: 4px #033d75;
          border-radius: 7px;
          font-weight: 600;
      }
      input:focus{
      	border-bottom:5px solid #008000;
      	
      }
      input[type=number]::-webkit-inner-spin-button,
      input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
      }
    </style>
    <script>
      function getCodeBoxElement(index) {
        return document.getElementById('codeBox' + index);
      }
      function onKeyUpEvent(index, event) {
        const eventCode = event.which || event.keyCode;
        if (getCodeBoxElement(index).value.length === 1) {
          if (index !== 4) {
            getCodeBoxElement(index+ 1).focus();
          } else {
            getCodeBoxElement(index).blur();
            // Submit code
            console.log('submit code ');
          }
        }
        if (eventCode === 8 && index !== 1) {
          getCodeBoxElement(index - 1).focus();
        }
      }
      function onFocusEvent(index) {
        for (item = 1; item < index; item++) {
          const currentElement = getCodeBoxElement(item);
          if (!currentElement.value) {
              currentElement.focus();
              break;
          }
        }
      }
    </script>
   <div class="nk-content" style="margin-top: 100px;">
              <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="buysell wide-xs m-auto">
                                <div class="buysell-title text-center">
                                  <h2 class="title">Complete your transaction!</h2>
                                </div><!-- .buysell-title -->
                                <div class="buysell-block">
                                    <form action="#" method="post" class="buysell-form">
                                        <div class="BillOtpResult"></div>
                                        <div class="buysell-field form-group">
                                            <div class="form-label-group">
                                                <strong class="form-label text-primary text-center">Let's make sure it's really you. We've just send a verification code to the email address and phone number that is assoiated with your <?php echo $sitename ?> account. </strong>
                                            </div>
                                        </div><!-- .buysell-field -->
                                        <div class="buysell-field form-group">
                                        	<center>
                                            <div class="">
                                                <label class="form-label font-weight-bold" for="">Enter OTP:</label>
                                            </div>
                                            <stong></stong>
                                            <form action="" method="post" id="otpForm">
                                               <input id="codeBox1" name="codeBox1" type="number" maxlength="1" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)"/>
                                                    <input id="codeBox2" name="codeBox2" type="number" maxlength="1" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)"/>
                                                    <input id="codeBox3" name="codeBox3" type="number" maxlength="1" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)"/>
                                       <input id="codeBox4" name="codeBox4" type="number" maxlength="1" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)"/>
                                        <div class="">
                                                <span class="buysell-min form-note-alt">Note: OTP expires in <span class="" id="timer">10:00<<span> minutes</span>
                                            </div>
                                        </div></center><!-- .buysell-field -->
                                        <div class="buysell-field form-action">
                                            <button type="submit" class="btn btn-lg btn-block btn-primary billOtp">Verify OTP</a>
                                        </div><!-- .buysell-field -->
                                        <div class="form-note text-base text-center">Note:Do not disclose your OTP to a third party.</div>
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


<?php include("footer.php") ?>