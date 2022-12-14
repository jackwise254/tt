<?php if($user_data == 'admin'): 

include('template/header.php');

else:
    include('template/head.php');

endif;

?>
<?php include('inc/db_connect.php'); ?>

<?php  $random = rand(10000, 99999); ?>
    <div class="row mx-3 pt-5 mt-4">
    <h5 class="text-center"><u>Credit note</u></h5>
    <div class="col-6 ">
 <form name="test" class="col-10" action="<?php echo  base_url('ProductsCrud/creditsub1'); ?>" method="POST">
<a href="<?php echo site_url('credit-create') ?>" class="btn btn-dark btn-sm bi bi-chevron-left">back</a>

            <label >Customer:</label>
            <select class="form-select form-control w-25 d-inline"  name="username" >
                <option selected></option>
                    <?php foreach($customers as $user): ?>
                    <option value="<?php echo $user->username; ?>"><?php echo $user->username; ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="w-25 d-inline">
            <label class=""></label>
                <input type="text" class=" w-25 d-inline " name="credit" placeholder="Credit No:" required>
            </div>
                <input class="form-control my-3 d-none" id="barcodeValue" value="<?= $random; ?>" name="random">

                <?php foreach($masterlist as $user): ?>
              <input class="form-control my-3 d-none" id="barcodeValue" value="<?=  $user->random; ?>" name="random1">
              <?php endforeach; ?>
             
            <button type ="submit" class="bi bi-search" id="myBtn1" onchange="this.form.submit()"></button>

        </form>
        </div>
        <div class="col-6">
            
        <form name="test" class="col-10" action="<?php echo  base_url('ProductsCrud/creditsub'); ?>" method="POST">
        <a href="<?php echo  base_url('ProductsCrud/creditclear'); ?>" class=" btn btn-danger bi bi-trash-fill float-end btn-sm">Clear</a>

            <label class="label">Serial no.</label>
            <input type="text" class="col-4 " id="serialno" name="assetid" autofocus >
            <!--  -->
            <button type ="submit" class="d-none" id="myBtn" onchange="this.form.submit()">Submit</button>
        </form>
        </div>
       
    </div>


<script src="https://code.jquery.com/jquery-2.2.4.js"></script>

<script>
  $('#serialno').keyup(function(){
      if(this.value.length >= 6){
      $('#myBtn').click();
      }
  });
</script> 
<?php
    if(session()->getFlashdata('status')) {
        echo "<h4 class=' alert alert-success d-flex align-items-center bi flex-shrink-0 me-2' width='24' height='24' role='alert' style='font-family:'Airal', Arial, Arial; font-size:60%'>" . session()->getFlashdata('status') . "</h4>"; 
    }
?>  

<hr/>
<h5 class="d-flex justify-content-end" style='font-family:"Airal", Arial, Arial; font-size:60%'><?php echo $count_tcredit; ?> Item(s) added </h5>

<form method="post" id="invoice_create" name="invoice_create" action="<?php echo base_url('ProductsCrud/cout'); ?>">
<div class="row">

<div class="col-3">
<div class="container">
        <div class=" form-row">
            <div class="col-sm-12 mx-auto bg-light rounded ">
                <h4 class="text-center" style="font-family: arial, arial, arial; font-size: 14px ">Customer details </h4>
                
                        <?php foreach($customer as $user): ?>

                    <div class="row px-3">
                        <div class="col">
                        <label  class="col-sm-6 col-form-label" style="font-family: arial, arial, arial; font-size: 13px ">F.name:</label>
                        <input type="text" class="form-control" name="fname" style="font-family: arial, arial, arial; font-size: 13px " placeholder="<?=  $user->fname; ?> "readonly>
                        </div>
                        <div class="col">
                        <label for="inputPassword3" class="col-sm-6 col-form-label" style="font-family: arial, arial, arial; font-size: 13px ">L.name:</label>
                        <input type="text" class="form-control" name="lname" style="font-family: arial, arial, arial; font-size: 13px " placeholder="<?=  $user->lname; ?>" readonly>
                        </div>
                        
                    </div>
                    <div class="row px-3">
                        <div class="col">
                        <label for="inputPassword3" class="col-sm-2 col-form-label" style="font-family: arial, arial, arial; font-size: 13px ">Phone</label>
                        <input type="text" class="form-control" name="phone"  style="font-family: arial, arial, arial; font-size: 13px " placeholder="<?=  $user->phone; ?>" readonly>
                        </div>
                        <div class="col">
                        <label for="inputPassword3" class="col-sm-2 col-form-label" style="font-family: arial, arial, arial; font-size: 13px ">Location</label>
                        <input type="text" class="form-control" name="location" style="font-family: arial, arial, arial; font-size: 13px " placeholder="<?=  $user->location; ?> " required readonly >
                        </div>
                        
                    </div>
                    <div class="row px-3 ">
                        <div class="col">
                        <label  class="col-sm-2 col-form-label " style="font-family: arial, arial, arial; font-size: 13px ">Email</label>
                        <input type="text" class="form-control mb-4" style="font-family: arial, arial, arial; font-size: 13px " name="email" placeholder="<?=  $user->email; ?>" readonly>
                        </div>
                        <div class="col">
                        <label  class="col-sm-2 col-form-label " style="font-family: arial, arial, arial; font-size: 13px ">Id_No.</label>
                        <input type="text" class="form-control mb-4" style="font-family: arial, arial, arial; font-size: 13px " name="id_no" placeholder="<?=  $user->id_no; ?>" readonly>
                        </div>
                    </div>
                    



                    <?php endforeach; ?>
                    <?php foreach($customer as $user): ?>
                    <input class="form-control my-3 d-none" id="barcodeValue" value="<?=  $user->random; ?>" name="random">
                    <?php endforeach; ?>
                    
            </div>
        </div>
    </div>

    <!-- //*********************************************************************************************** */  -->

</div>

<div class="col-9">

<div class="container">
        <div class=" form-row">
            <div class="col-sm-12 mx-auto bg-light rounded ">
                <h4 class="text-center" style="font-family: arial, arial, arial; font-size: 13px ">Products details </h4>
                <input type="date" class=" px-2  " name="datedelivered" style="font-family: arial, arial, arial; font-size: 14px required>

                <div class="table-responsive">
                <?php if($masterlist): ?>
                    <table class="table table-fixed table-striped " style='font-family:"Airal", Arial, Arial; font-size:60%'>
                        <thead >
                            <tr>
                            <th scope="col" class="col-3"></th>
                            <th scope="col" class="col-3">Asset_Id</th>
                            <th scope="col" class="col-3">Type</th>
                            <th scope="col" class="col-3">Condition</th>
                            <th scope="col" class="col-3">Generation</th>
                            <th scope="col" class="col-3">Ram</th>
                            <th scope="col" class="col-3">Screen</th>
                            <th scope="col" class="col-3">Part</th>
                            <th scope="col" class="col-3">Serial_No.</th>
                            <th scope="col" class="col-3">Model_Id</th>
                            <th scope="col" class="col-3 px-5">Model</th>
                            <th scope="col" class="col-3 px-5">CPU</th>
                            <th scope="col" class="col-3">Speed</th>
                            <th scope="col" class="col-3">Price</th>
                            <th scope="col" class="col-3">Odd</th>
                            <th scope="col" class="col-3">Comment</th>
                            <th scope="col" class="col-3">HDD</th>
                            <th scope="col" class="col-3">Date_Recieved</th>
                            <th scope="col" class="col-3">Customer</th>
                            <th scope="col" class="col-3">List</th>
                            <th scope="col" class="col-3">Status</th>
                            </tr>
                        </thead>
                        <?php foreach($masterlist as $user):
                            $datereceived = substr($user->daterecieved,0,10);
                            $datedelivered = substr($user->datedelivered,0,10);
                            ?>
                        <tbody>
                            <tr>
                            <td class="">  
                            <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="#myModal" class="trigger-btn" data-toggle="modal" class="pr-2">[del]</a>
                        </div>
                            <td class="col-5"><?=  $user->assetid; ?></td>
                            <td class="col-5"><?=  $user->type; ?></td>
                            <td class="col-5"><?=  $user->conditions; ?></td>
                            <td class="col-5"><?=  $user->gen; ?></td>
                            <td class="col-5"><?=  $user->ram; ?></td>
                            <td class="col-5"><?=  $user->screen; ?></td>
                            <td class="col-5"><?=  $user->part; ?></td>
                            <td class="col-5"><?=  $user->serialno; ?></td>
                            <td class="col-5"><?=  $user->modelid; ?></td>
                            <td class="col-5"><?=  $user->model; ?></td>
                            <td class="col-5"><?=  $user->cpu; ?></td>
                            <td class="col-5"><?=  $user->speed; ?></td>
                            <td class="col-5"><?=  $user->price; ?></td>
                            <td class="col-5"><?=  $user->odd; ?></td>
                            <td class="col-5"><?=  $user->comment; ?></td>
                            <td class="col-5"><?=  $user->hdd; ?></td>
                            <td class="col-5"><?=  $datereceived; ?></td>
                            <td class="col-5"><?=  $user->customer; ?></td>
                            <td class="col-5"><?=  $user->list; ?></td>
                            <td class="col-5"><?=  $user->status; ?></td>

                            </tr>
                        </tbody>
                     
                        <!-- Modal HTML -->
                            <div id="myModal" class="modal fade">
                                    <div class="modal-dialog modal-confirm">
                                        <div class="modal-content">
                                            <div class="modal-header flex-column">
                                                <div class="icon-box">
                                                    <i class="material-icons">&#xE5CD;</i>
                                                </div>
                                                <h4 class="modal-title w-100">Are you sure?</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Do you really want to delete these records? This process cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                <a href="<?php echo base_url('ProductsCrud/delete/'.$user->id);?> " class="btn btn-danger deletebtn" >Delete</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <?php endforeach; ?>
                    </table>
                    <?php endif; ?>

                </div>
                
            </div>
        </div>
        
    </div>

    <?php foreach($customer as $user): ?>
<input type="text" class=" d-none" name="lname" value="<?php echo  $user->lname; ?>">
<?php endforeach ?>
</div>
<div class="py-4 px-5">
<button type="submit" class="btn btn-primary  col-12">Create</button>
                        </div>

</div>

 
</div>
</form>

    </div>
    </div>
    
 <script type="text/javascript">

/// Onclick scrpt

   var input = document.getElementById("serialno");
          function selectText() {
          const input = document.getElementById('serialno');
          input.focus();
          input.select();
        }
        input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("myBtn").click();
        }
        });
    
    </script>

<script type="text/javascript">

/// Onclick scrpt

   var input = document.getElementById("serialno");
          function selectText() {
          const input = document.getElementById('fname');
          input.focus();
          input.select();
        }
        input.addEventListener("keyup", function(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            document.getElementById("myBtn").click();
        }
        });
    
    </script>
  
    




 






