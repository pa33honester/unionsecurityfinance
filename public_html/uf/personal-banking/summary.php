<?php 
include("header.php");

?>
<div class="nk-content">
	<?php echo$stockrate ?>
 <div class="card card-preview ">
              <div class="card-inner p-0">
                <table class="datatable-init table">
                  <thead>
                    <tr>
                    <th>Ref </th>
                     <th>Type</th>
                       <th>Scope</th>
                      <th>Amount</th>
                      <th>Date </th>
                      <th>Description</th>
                      <th>Status</th>
                  </tr>
                </thead>
                 <tbody>
                    <?php 
                    $query = $conn->query("SELECT * FROM transactions WHERE userid = '$userid' ORDER BY id DESC");
                     while ($rows = mysqli_fetch_array($query)) {
                        if($rows['status'] == 1){
                            $stat = "<strong class='text-success'>Completed</strong>";
                        }else{ $stat = "<strong class='text-danger'>Pending</strong>"; }
                         
                    ?>
                    <tr>
                      <td><?php echo$rows['refNumber']; ?></td>    
                      <td><?php echo$rows['type']; ?></td>  
                      <td><?php echo$rows['scope']; ?></td> 
                      <td><b><?php echo$money; ?></b> <?php echo$rows['amount'] ?></td>    
                      <td><?php echo$rows['dated']; ?></td>  
                     <td><?php echo$rows['description']; ?></td>     
                      <td><?php echo$stat; ?></td> 
                      </tr> 
              <?php   }   ?>
          </tbody>
      </table>
      </div>
  </div>
</div>
<?php 
include("footer.php");

?>