<?php include("header.php") ?>
    <div class="nk-content">
       <div class="container-xl wide-lg">
        <div class="nk-content-body">
        <div class="nk-block-head">
         <div class="nk-block-head-sub">
         </div>
           <div class="nk-block-between-md g-4 card-bordered">
             <div class="nk-block-head-content">
              <h4 class="nk-block-title fw-normal">Cross-border transfer.</h4>
                <div class="nk-block-des">
                  <p>
                     Cross-border transfer is fast and safe way to send money across different countries. The funds are deposited into the recipient's bank account associated with the IBAN or Swift Code you have added.
                   </p>
                      </div>
                       </div>
                            <div class="nk-block-head-content">
                                        <ul class="nk-block-tools gx-3">
                                            <li><a href="transfer" class="btn btn-primary btn-light text-light"><span>Local Transfer</span><em class="icon ni ni-wallet-out"></em></a></li>
                                            <li class="opt-menu-md dropdown">
                                                <a href="#" class="btn btn-white btn-light btn-icon" data-toggle="dropdown"><em class="icon ni ni-setting"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><em class="icon ni ni-coin-alt"></em><span>Curreny Settings</span></a></li>
                                                        <li><a href="#"><em class="icon ni ni-notify"></em><span>Push Notification</span></a></li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>

                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                        </div>
                    </div>

     <div class="card card-bordered">
        <div class="card-header text-light" style="background-color:#033d75;">
         <ul class="nav nav-tabs mt-n3">
           <li class="nav-item ">
            <a class="nav-link active text-light" data-toggle="tab" href="#tabItem5"><em class="icon ni ni-wallet-alt"></em> <span >Send Money</span></a>
            </li>
        <li class="nav-item">
        <a class="nav-link text-light" data-toggle="tab" href="#tabItem6"><em class="icon ni ni-cc-new"></em><span>Add a Recipient</span></a>
        </li>
       <li class="nav-item">
        <a class="nav-link text-light" data-toggle="tab" href="#tabItem7"><em class="icon ni ni-exchange"></em><span>History</span></a>
        </li>
        </ul>
   </div>
       <div class="card-inner">
     <div class="tab-content">
    <div class="tab-pane active" id="tabItem5">
    <p>

      <form action="" method="post">
        <div class="row">              
          <div class="form-group col-md-6">
        <div class="form-control-wrap">
         <select type="text" name="recipient" class="form-control form-control-outlined " id="recipient" placeholder="">
            <option disabled="" selected=""> </option>
            <option disabled="" selected="">Select a Recipient</option>
            <?php $query = $conn->query("SELECT * FROM wire WHERE userid = '$userid'");
            if (mysqli_num_rows($query) < 1) {
                echo "<option selected disabled>No recipient have been added</option>";
            }
            while($row = mysqli_fetch_assoc($query)){

             ?>
         <option value="<?php echo$row['id'] ?>"><?php echo$row['fullname'] ?> (<?php echo$row['country']  ?>)</option>

     <?php } ?>
         </select>
         <label class="form-label-outlined" for="outlined">Select a Recipient</label>
         </div>
        </div> 
         <div class="form-group col-md-6">
        <div class="form-control-wrap">
         <input type="date" class="form-control form-control-outlined" id="dated" name="dated" placeholder="">
         <label class="form-label-outlined" for="outlined">Delivery date</label>
         </div>
        </div> 
        <div class="buysell-field form-group col-md-12"> 
       <div class="form-label-group"> 
        <label class="form-label" for="buysell-amount">Amount</label> 
       </div>
      <div class="form-control-group"> 
        <input type="number" class="form-control form-control-lg form-control-number" id="amount" name="amount" placeholder="2000"> 
        <div class="form-dropdown"> 
            <div class="text"><?php echo$money; ?><span></span></div> 
        </div>
         </div>
          <div class="form-note-group"> 
            <span class="buysell-min form-note-alt"></span> <span class="buysell-rate form-note-alt">*Cross-border transfer fee will be deducted</span> 
          </div> 
          </div>
        <div class="form-group col-md-12">
        <div class="form-control-wrap">
         <input type="text" class="form-control form-control-outlined" id="description" name="description" placeholder="">
         <label class="form-label-outlined" for="outlined">Description (Reason)</label>
         </div>
        </div> 
        <div class="wireResult"></div>
        <div class="form-group col-md-12"> 
            <button type="submit" class="btn btn-primary btn-block wireBtn" id="btn1">Continue</button>
        </div>
                         
         </div>
     </form>
      <script src="../js/jquery.min.js"></script>
     <script type="text/javascript">
            $(document).ready(function() {
 $('.wireBtn').on('click', function() {
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
    $('.wireBtn').click(function (e) {
         document.getElementById("btn1").disabled = true;
      e.preventDefault();
      var recipient = $('#recipient').val(); var dated = $('#dated').val();  var description = $('#description').val();  var amount = $('#amount').val();
      $.ajax
        ({
          type: "POST",
          url: "../scripts/wire",
          data: {
          "amount": amount, "recipient": recipient, "dated": dated, "description": description
        },
          success: function (data) {
             document.getElementById("btn1").disabled = false;
            $('.wireResult').html(data);
            $('#form')[0].reset();
          }
        });
    });
  });
        </script>
    </p>
     </div>
      <div class="tab-pane" id="tabItem6">
       <p>
        <b>Recipient's and banking information</b> 

        <form method="post"  action="">
        <div class="row">
            <?php include("wire2.php");?>
        <div class="form-group col-md-12">
        <div class="form-control-wrap">
         <input type="text" class="form-control form-control-outlined" id="address"  name="address">
         <label class="form-label-outlined" for="outlined">Address</label>
         </div>
        </div>
                <div class="form-group col-md-4">
        <div class="form-control-wrap">
         <input type="text" class="form-control form-control-outlined" id="zipcode"  name="zipcode">
         <label class="form-label-outlined" for="outlined">Postal/Zipcode</label>
         </div>
        </div>
                <div class="form-group col-md-4">
        <div class="form-control-wrap">
         <input type="text" class="form-control form-control-outlined" id="email"  name="email">
         <label class="form-label-outlined" for="outlined">Email address</label>
         </div>
        </div>
        <div class="form-group col-md-4">
        <div class="form-control-wrap">
         <input type="tel" class="form-control" id="phone"  name="phone" placeholder="e.g. +1 702 123 4567">
         
         
         </div>
        </div>
        
        <div class="form-group col-md-12">
        <div class="form-control-wrap">
         <input type="text" class="form-control form-control-outlined" id="fullname"  name="fullname">
         <label class="form-label-outlined" for="outlined">Recipient fullname </label>
         </div>
        </div> 
        <div class="form-group col-md-12">       
         <select type="text" class="form-control form-control-outlined" id="type" name="type" placeholder="">
         <option>International transfer</option>
         </select>
         <label class="form-label-outlined" for="outlined">Transfer type</label>
         </div>
        <hr style="background-color: black; height: 2px;">
       <div class="form-group col-md-12">
        <div class="form-control-wrap">
         <input type="text" class="form-control form-control-outlined" id="iban" name="iban" >
         <label class="form-label-outlined" for="outlined">IBAN</label>
         <small>You will have to provide the IBAN for European countries, or the ABA for the United States.
        </small>
         </div>
        </div>
       <div class="form-group col-md-6">
        <div class="form-control-wrap">
         <input type="text" class="form-control form-control-outlined" id="swiftcode" name="swiftcode" >
         <label class="form-label-outlined" for="outlined">Swift Code</label>
         </div>
        </div>
         <div class="form-group col-md-6">
        <div class="form-control-wrap">
         <input type="text" class="form-control form-control-outlined" onkeyup="showHint(this.value)" id="accountnumber" name="accountnumber" >
         <label class="form-label-outlined" for="outlined" >Account Number</label>    
         </div>
        </div>
       </div>
        <div class="row">
         <p id="detailB" class="col-lg-12"></p>
        </div>
    </p>
        <p>
       <div class="row">
     <div class="addRecipientResult"></div>
    <div class="form-group col-md-12">
    <div class="form-control-wrap">
    <button onclick="" type="submit" class="btn btn-primary btn-block addRecipient" id="btn2">continue</button>
        </div>
    </div>
        </div>
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
 $('.addRecipient').on('click', function() {
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
    $('.addRecipient').click(function (e) {
         document.getElementById("btn2").disabled = true;
      e.preventDefault();
      var countryId = $('#countryId').val(); var stateId = $('#stateId').val();  var cityId = $('#cityId').val();  var phone = $('#phone').val(); var address = $('#address').val();
      var zipcode = $('#zipcode').val(); var email = $('#email').val(); var fullname = $('#fullname').val(); var type = $('#type').val();
      var iban = $('#iban').val(); var swiftcode = $('#swiftcode').val(); var accountnumber = $('#accountnumber').val(); var accountholder = $('#accountholder').val();
      var accounttype = $('#accounttype').val(); var bankname = $('#bankname').val();
      $.ajax
        ({
          type: "POST",
          url: "../scripts/add-recipient",
          data: {
          "countryId": countryId, "stateId": stateId, "cityId": cityId, "address": address, "zipcode": zipcode,
          "email": email, "fullname": fullname, "type": type, "phone": phone, "iban": iban, "swiftcode": swiftcode, "accountnumber": accountnumber,
          "accountholder": accountholder, "accounttype": accounttype, "bankname": bankname
        },
          success: function (data) {
             document.getElementById("btn2").disabled = false;
            $('.addRecipientResult').html(data);
            $('#form')[0].reset();
          }
        });
    });
  });
        </script>
     </p>
        </div>
       <div class="tab-pane" id="tabItem7">
        <p>
            <div class="card card-preview ">
              <div class="card-inner p-0">
                <table class="datatable-init table">
                  <thead>
                    <tr>
                     <th>Recipient</th>
                      <th>Ref Number</th>
                       <th>Date</th>
                      <th>Amount</th>
                    <th>Description</th>
                  </tr>
                </thead>
                 <tbody>
                    <?php 
                    $query = $conn->query("SELECT * FROM wire_transfer WHERE userid = '$userid' ORDER BY id DESC");
                     while ($rows = mysqli_fetch_array($query)) {
                        if (mysqli_num_rows($query) < 1) {
                            echo "<strong>No international transfer have been recorded on your account</strong>";
                        }
                       /* if($rows['status'] == "pending"){
                            $stat = "<strong class='text-danger'>Pending</strong>";
                        }else{ $stat = "<strong class='text-success'>Completed</strong>"; }
                         */
                    ?>
                    <tr>
                      <td><?php echo$rows['fullname']; ?></td>    
                      <td><?php echo$rows['ref']; ?></td>  
                      <td><?php echo$rows['dated']; ?></td>  
                      <td><b><?php echo$money; ?></b> <?php echo$rows['amount'] ?></td> 
                      <td><?php echo$rows['description'] ?></td> 
                      </tr> 
              <?php   }   ?>
          </tbody>
      </table>
      </div>
  </div>
</p>
</div>
          </div>
        </div>
     </div>
   </div>
    <script src="../js/jquery.min.js"></script>
      <script src="https://www.jqueryscript.net/demo/jQuery-International-Telephone-Input-With-Flags-Dial-Codes/build/js/intlTelInput.js"></script>
  <script>
       $("#phone").intlTelInput({
          

        });
       </script>
   <script>
function showHint(str) {
  if (str.length == 0) { 
    document.getElementById("detailB").innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("detailB").innerHTML =
    this.responseText;
  }
  xhttp.open("GET", "../scripts/getbank.php?q="+str);
  xhttp.send();   
}
</script>
<script type="text/javascript">
    function ajaxCall() {
    this.send = function(data, url, method, success, type) {
        type = type||'json';
        var successRes = function(data) {
            success(data);
        }

        var errorRes = function(e) {
            console.log(e);
        }
        jQuery.ajax({
            url: url,
            type: method,
            data: data,
            success: successRes,
            error: errorRes,
            dataType: type,
            timeout: 60000
        });

    }

}

    function locationInfo() {
    var rootUrl = "https://geodata.solutions/api/api.php";
    //now check for set values
    var addParams = '';
    if(jQuery("#gds_appid").length > 0) {
        addParams += '&appid=' + jQuery("#gds_appid").val();
    }
    if(jQuery("#gds_hash").length > 0) {
        addParams += '&hash=' + jQuery("#gds_hash").val();
    }

    var call = new ajaxCall();

    this.confCity = function(id) {
        var url = rootUrl+'?type=confCity&country='+ jQuery('#country option:selected').attr('country') +'&state=' + jQuery('#state option:selected').attr('state') + '&city=' + id;
        var method = "post";
        var data = {};
        call.send(data, url, method, function(data) {
        });
    };


    this.getCities = function(id) {
        jQuery(".cities option:gt(0)").remove();
        var stateClasses = jQuery('#city').attr('class');

        var cC = stateClasses.split(" ");
        cC.shift();
        var addClasses = '';
        if(cC.length > 0)
        {
            acC = cC.join();
            addClasses = '&addClasses=' + encodeURIComponent(acC);
        }
        var url = rootUrl+'?type=getCities&country='+ jQuery('#country option:selected').attr('country') +'&state=' + id + addParams + addClasses;
        var method = "post";
        var data = {};
        jQuery('.cities').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            jQuery('.cities').find("option:eq(0)").html("Select City");
            if(data.tp == 1){
                var listlen = Object.keys(data['result']).length;

                if(listlen > 0)
                {
                    jQuery.each(data['result'], function(key, val) {

                        var option = jQuery('<option />');
                        option.attr('value', val).text(val);
                        jQuery('.cities').append(option);
                    });
                }
                else
                {
                    var usestate = jQuery('#state option:selected').val();
                    var option = jQuery('<option />');
                    option.attr('value', usestate).text(usestate);
                    option.attr('selected', 'selected');
                    jQuery('.cities').append(option);
                }

                jQuery(".cities").prop("disabled",false);
            }
            else{
                alert(data.msg);
            }
        });
    };

    this.getStates = function(id) {
        jQuery(".states option:gt(0)").remove();
        jQuery(".cities option:gt(0)").remove();
        //get additional fields
        var stateClasses = jQuery('#state').attr('class');

        var cC = stateClasses.split(" ");
        cC.shift();
        var addClasses = '';
        if(cC.length > 0)
        {
            acC = cC.join();
            addClasses = '&addClasses=' + encodeURIComponent(acC);
        }
        var url = rootUrl+'?type=getStates&country=' + id + addParams  + addClasses;
        var method = "post";
        var data = {};
        jQuery('.states').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            jQuery('.states').find("option:eq(0)").html("Select State");
            if(data.tp == 1){
                jQuery.each(data['result'], function(key, val) {
                    var option = jQuery('<option />');
                    option.attr('value', val).text(val);
                    option.attr('state', key);
                    jQuery('.states').append(option);
                });
                jQuery(".states").prop("disabled",false);
            }
            else{
                alert(data.msg);
            }
        });
    };

    this.getCountries = function() {
        //get additional fields
        var countryClasses = jQuery('#country').attr('class');

        var cC = countryClasses.split(" ");
        cC.shift();
        var addClasses = '';
        if(cC.length > 0)
        {
            acC = cC.join();
            addClasses = '&addClasses=' + encodeURIComponent(acC);
        }

        var presel = false;
        var iip = 'N';
        jQuery.each(cC, function( index, value ) {
            if (value.match("^presel-")) {
                presel = value.substring(7);

            }
            if(value.match("^presel-byi"))
            {
                var iip = 'Y';
            }
        });


        var url = rootUrl+'?type=getCountries' + addParams + addClasses;
        var method = "post";
        var data = {};
        jQuery('.countries').find("option:eq(0)").html("Please wait..");
        call.send(data, url, method, function(data) {
            jQuery('.countries').find("option:eq(0)").html("Select Country");

            if(data.tp == 1){
                if(presel == 'byip')
                {
                    presel = data['presel'];
                    console.log('2 presel is set as ' + presel);
                }


                if(jQuery.inArray("group-continents",cC) > -1)
                {
                    var $select = jQuery('.countries');
                    console.log(data['result']);
                    jQuery.each(data['result'], function(i, optgroups) {
                        var $optgroup = jQuery("<optgroup>", {label: i});
                        if(optgroups.length > 0)
                        {
                            $optgroup.appendTo($select);
                        }

                        jQuery.each(optgroups, function(groupName, options) {
                            var coption = jQuery('<option />');
                            coption.attr('value', options.name).text(options.name);
                            coption.attr('country', options.id);
                            if(presel) {
                                if (presel.toUpperCase() == options.id) {
                                    coption.attr('selected', 'selected');
                                }
                            }
                            coption.appendTo($optgroup);
                        });
                    });
                }
                else
                {
                    jQuery.each(data['result'], function(key, val) {
                        var option = jQuery('<option />');
                        option.attr('value', val).text(val);
                        option.attr('country', key);
                        if(presel)
                        {
                            if(presel.toUpperCase() ==  key)
                            {
                                option.attr('selected', 'selected');
                            }
                        }
                        jQuery('.countries').append(option);
                    });
                }
                if(presel)
                {
                    jQuery('.countries').trigger('change');
                }
                jQuery(".countries").prop("disabled",false);
            }
            else{
                alert(data.msg);
            }
        });
    };

}

jQuery(function() {
    var loc = new locationInfo();
    loc.getCountries();
    jQuery(".countries").on("change", function(ev) {
        var country = jQuery("option:selected", this).attr('country');
        if(country != ''){
            loc.getStates(country);
        }
        else{
            jQuery(".states option:gt(0)").remove();
        }
    });
    jQuery(".states").on("change", function(ev) {
        var state = jQuery("option:selected", this).attr('state');
        if(state != ''){
            loc.getCities(state);
        }
        else{
            jQuery(".cities option:gt(0)").remove();
        }
    });

    jQuery(".cities").on("change", function(ev) {
        var city = jQuery("option:selected", this).val();
        if(city != ''){
            loc.confCity(city);
        }
    });
});
</script>


<?php include("footer.php") ?>