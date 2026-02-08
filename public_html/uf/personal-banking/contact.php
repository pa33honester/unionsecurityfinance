<?php 
include("header.php");
?>
<div class="nk-content nk-content-fluid">
                    <div class="container-xl wide-lg">
                        <div class="nk-content-body">
                            <div class="nk-block-head">
                                <div class="nk-block-head-sub">
                                </div>
                                <div class="nk-block-between-md g-4 card-bordered">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title fw-normal">Customer care Desk.</h4>
                                        <div class="nk-block-des">
                                            <p>Our customer Care representatives are always committed in giving you the best banking experience.</p>
                                        </div>
                                    </div><!-- .nk-block-head-content -->
                                    <div class="nk-block-head-content">
                                        <ul class="nk-block-tools gx-3">
                                            <li><a href="transfer" class="btn btn-secondary btn-light text-light"><span>Transfer Fund</span><em class="icon ni ni-wallet-out"></em></a></li>
                                        </ul>
                                    </div><!-- .nk-block-head-content -->
                                </div><!-- .nk-block-between -->
                            </div><!-- .nk-block-head -->
                        </div>
                    </div>
                    <div class="card card-bordered card-preview">
                     <div class="card-header font-weight-bold text-light" style="background-color:#033d75;">
                       <h5 class="text-white"> <em class="icon ni ni-question"></em> Create a support ticket </h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                         <div class="row">
                           <div class="form-group col-lg-12">

                            <select class="form-control form-control-xl" name="department" id="department">
                             <option  value="" selected="" disabled="">Please Select Customer Service Department</option>
                                <option  value="Customer Services Department">Customer Services Department</option>
                                <option  value="Account Department">Account Department</option>
                                <option  value="Transfer Department">Transfer Department</option>
                                <option  value="Card Services Department">Card Services Department</option>
                                <option  value="Loan Department">Loan Department</option>
                                <option  value="Bank Deposit Department">Bank Deposit Department</option>
                            </select>
                          </div>  
                          <div class="form-group col-lg-12">
                           <textarea class="form-control form-control-xl" name="message" id="message" placeholder="Type your complaints"></textarea>
                          </div>
                          <div class="createResult"></div>
                          <div class="form-group col-lg-12">
                              <button class="btn btn-primary ticketBtn" type="submit" id="btn">Submit</button>
                          </div>
                    </div>
                </form>
                  </div>  
              </div>
 <!-------Previous tickets---->
    <div class="card card-bordered card-preview">
                     <div class="card-header font-weight-bold text-light" style="background-color:#033d75;">
                       <h5 class="text-white"> <em class="icon ni ni-question-alt"></em> Previous support tickets </h5>
                    </div>
                    <div class="card-body">
                      <table class="datatable-init table">
                  <thead>
                    <tr>
                     <th>Department</th>
                       <th>Ticket ID</th>
                      <th>Date</th>
                      <th>Comments</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                 <tbody>
                    <?php 
                    $query = $conn->query("SELECT * FROM support WHERE userid = '$userid' ORDER BY id ASC");
                     while ($rows = mysqli_fetch_array($query)) {
                        if($rows['status'] == "closed"){
                            $stat = "<strong class='text-danger'>Closed</strong>";
                        }else{ $stat = "<strong class='text-success'>Active</strong>"; }
                         $ticket = $rows['ticketid'];
                         $id = $rows['id'];
                    ?>
                    <tr>
                      <td><?php echo$rows['department']; ?></td>    
                      <td><?php echo$rows['ticketid']; ?></td>  
                      <td><?php echo$rows['datecreated'] ?></td>
                      <td><?php $sql = $conn->query("SELECT * FROM reply WHERE ticketid = '$ticket'");
                       echo "(".mysqli_num_rows($sql).")";
                       ?></td>
                      <td><?php echo$stat; ?></td> 
                      <td><button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#replyModal<?php echo$rows['id'] ?>">View</button></td>
                      </tr> 

<!-- Modal Content Code -->
<div class="modal fade" tabindex="-1" id="replyModal<?php echo$rows['id'] ?>" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close text-white" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header text-white" style="background-color:#033d75; color: white;">
                <h5 class="modal-title"><?php echo$ticket?></h5>
            </div>
            <div class="modal-body bg-light">
                <p class="card-bordered rounded-sm p-1 bg-white"><?php echo$rows['message'] ?></p>
                <hr style="height:3px; background-color: #033d75; border-radius:3px;">
                <strong class="text-center" style="text-align: center;">Discussion</strong>
                <div id="chatSection<?php echo$id?>">
                <?php 
                $queryy = $conn->query("SELECT * FROM reply WHERE ticketid = '$ticket'");
                while($r = mysqli_fetch_assoc($queryy)){
                    $reply = $r['message'];
                    $dated = $r['datecreated'];
                    if ($r['userid'] == 1) {
                        $alert = "alert-success";
                        $by = "Customer care";
                    }else{$alert = "alert-pro"; $by = "$fullname";}
                    if (mysqli_num_rows($queryy) < 1) {
                        echo "<center>No response so far</center>";
                    }
                ?>
                <div class="alert <?php echo$alert ?> w-100 p-1"> <?php  echo "$reply";?><br>
                    <small class="text-muted"><?php  echo "$dated";?></small><br>
                     <small class="text-muted"><?php  echo "$by";?></small>
                     </div>
                  <?php } ?>  
              </div>
            </div> 
            <?php if($rows['status'] == "closed"){ } else{ ?>                                   
            <form action="" method="post" id="sendForm<?php echo$rows['id'] ?>">
             <div class="nk-chat-editor" style="border-color:black;">
                   <div class="nk-chat-editor-upload  ml-n1">
                    <a href="#" class="btn btn-round btn-primary btn-icon"><em class="icon ni ni-plus-circle-fill"></em></a>
                     </div>
                     <div class="chatResult"></div>
                        <div class="nk-chat-editor-form">
                          <div class="form-control-wrap">
                            <input type="hidden" name="ticketid<?php echo$id ?>" id="ticketid<?php echo$id ?>" value="<?php echo$ticket?>">
                          <textarea name="reply<?php echo$id ?>" class="form-control form-control-simple no-resize" rows="1" id="reply<?php echo$id ?>" placeholder="Type your message..."></textarea>
                          </div>
                            </div>
                            <ul class="nk-chat-editor-tools g-2">
                             <li>
                                <div class="sendResult<?php echo$rows['id'] ?>"></div>
                              <button class="btn btn-round btn-primary btn-icon sendMsg<?php echo$rows['id'] ?>" id="btn<?php echo$rows['id'] ?>"><em class="icon ni ni-send-alt"></em></button>
                           </li>
                        </ul>
                     </div>
                 </form>
             <?php } ?>
                 <script src="../js/jquery.min.js"></script>
         <script type="text/javascript">
     $(document).ready(function () {
    $('.sendMsg<?php echo$rows['id'] ?>').click(function (e) {
        document.getElementById("btn<?php echo $rows['id'] ?>").disabled = true;
      e.preventDefault();
      var reply<?php echo$id ?> = $('#reply<?php echo$id ?>').val();
      var ticketid<?php echo$id ?> = $('#ticketid<?php echo$id ?>').val();
      $.ajax
        ({
          type: "POST",
          url: "../scripts/send_reply.php?id=<?php echo$id ?>",
          data: {"reply<?php echo$id ?>": reply<?php echo$id ?>, "ticketid<?php echo$id ?>": ticketid<?php echo$id ?>},
          success: function (data) {
             document.getElementById("btn<?php echo $rows['id'] ?>").disabled = false;
            $('.sendResult<?php echo$rows['id'] ?>').html(data);
            $('#sendForm<?php echo$rows['id'] ?>')[0].reset();
          }
        });
    });
  });
                  </script>
                  <div class="modal-footer bg-light">
                <span class="sub-text btn btn-danger btn-sm text-white" data-dismiss="modal">Close</span>
            </div>
        </div>
    </div>
</div>
              <?php   }   ?>
          </tbody>
      </table>
                  </div>  
              </div>

          </div>
<script src="../js/jquery.min.js"></script>
 <script type="text/javascript">                
 $(document).ready(function() {
 $('.ticketBtn').on('click', function() {
 var $this = $(this);
 var loadingText = '<i class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></i>&nbsp;Processing...';
 if ($(this).html() !== loadingText) {
 $this.data('original-text', $(this).html());
 $this.html(loadingText);
 }
 setTimeout(function() {
 $this.html($this.data('original-text'));
 },2000);
 });
 })
$(document).ready(function () {
    $('.ticketBtn').click(function (e) {
      document.getElementById("btn").disabled = true;
      e.preventDefault();
      var department = $('#department').val();
      var message = $('#message').val();
      $.ajax
        ({
          type: "POST",
          url: "../scripts/create_support_ticket.php",
          data: {"department": department, "message": message},
          success: function (data) {
            document.getElementById("btn").disabled = false;
            $('.createResult').html(data);
            $('#form')[0].reset();
          }
        });
    });
  });
  </script>
  <script src="../assets/js/apps/chats.js?ver=2.4.0"></script>
<?php 
include("footer.php");
?>