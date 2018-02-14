


             <?php

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php'; 
//get the logged in user credentials and validate
 

    $stmt = $DB_con->prepare('SELECT * FROM tbl_hostelbook ORDER BY id DESC');
    $stmt->execute();
    

    if($stmt->rowCount() > 0)
    {
        while($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            extract($row);
           
       
            ?>

           <?php
if($row['roomUpdate']==0){
    ?>
     <div class="row">
              <div class="col-md-1">
               <button type="button" class="btn btn-large btn-primary">&nbsp;&nbsp;New&nbsp;&nbsp;</button>
              </div>
              <div class="col-md-2">
              <?php echo "<h6><strong>Code:</strong></h6> ". $row['roomID']; ?>
              </div>
               <div class="col-md-2">
              <?php echo "<h6><strong>Name:</strong></h6> ". $row['roomName']; ?>
              </div>
               <div class="col-md-2">
              <?php echo "<h6><strong>Capacity:</strong></h6> ". $row['roomCapacity']; ?>
              </div>
              <div class="col-md-2">  
               <!-- input javascript popup for insert field of this appropriate ID -->
              <a  href="?add_id=<?php echo $row['id']; ?>" title="click to add different views of this image" > <img src="upload/<?php echo  $row['roomImage']; ?>"  width="50px" height="50px" class="img-rounded"  /></a>
             <!-- popups ->
        <button class="btn btn--primary btn-demo js-tingle-modal-1">A simple modal</button>
        <button class="btn btn--secondary btn-demo js-tingle-modal-2">Need buttons?</button>
        <button class="btn btn--secondary btn-demo js-tingle-modal-3">Big content? No problem!</button>
        <button class="btn btn--secondary btn-demo js-tingle-modal-4">Stick to me!</button>
        <button class="btn btn--secondary btn-demo js-tingle-modal-5">Close with footer button only</button>
        <button class="btn btn--secondary btn-demo js-tingle-modal-6">?</button>
        <!-- popups -->
              </div>
               <div class="col-md-2">
               <div class="row">
               <div class="col-md-6">
     <a class="btn btn-success" href="?edit_id=<?php echo $row['id']; ?>" title="click for Edit" ><span class="glyphicon glyphicon-cog"></span></a>
                </div>
                 <div class="col-md-6">
     <a class="btn btn-danger" href="?delete_id=<?php echo $row['id']; ?>" title="click for Delete" ><span class="glyphicon glyphicon-remove-circle"></span></a>
              </div>
              </div>
              </div>
              <div class="col-md-1">
              <!-- suppliment javascript popup for different views -->
                 <a   href="?view_id=<?php echo $row['id']; ?>" title="click to view different views of this image" class=" js-tingle-modal-2"><img src="images/more.png" alt="Post" style="height: 40px ;width: 40px ;"></a>
              </div>
            </div>
           <hr>
           <?php
}else if($row['roomUpdate']==1){
    ?>
 <div class="row">
               <div class="col-md-1">
              <button type="button" class="btn btn-large btn-danger">Edited</button>
              </div>
              <div class="col-md-2">
              <?php echo "<h6><strong>Code:</strong></h6> ". $row['roomID']; ?>
              </div>
               <div class="col-md-2">
              <?php echo "<h6><strong>Name:</strong></h6> ". $row['roomName']; ?>
              </div>
               <div class="col-md-2">
              <?php echo "<h6><strong>Capacity:</strong></h6> ". $row['roomCapacity']; ?>
              </div>
              <div class="col-md-2">  
               <!-- input javascript popup for insert field of this appropriate ID -->
              <a  href="?add_id=<?php echo $row['id']; ?>" title="click to add different views of this image" > <img src="upload/<?php echo  $row['roomImage']; ?>"  width="50px" height="50px" class="img-rounded"  /></a>
             <!-- popups ->
        <button class="btn btn--primary btn-demo js-tingle-modal-1">A simple modal</button>
        <button class="btn btn--secondary btn-demo js-tingle-modal-2">Need buttons?</button>
        <button class="btn btn--secondary btn-demo js-tingle-modal-3">Big content? No problem!</button>
        <button class="btn btn--secondary btn-demo js-tingle-modal-4">Stick to me!</button>
        <button class="btn btn--secondary btn-demo js-tingle-modal-5">Close with footer button only</button>
        <button class="btn btn--secondary btn-demo js-tingle-modal-6">?</button>
        <!-- popups -->
              </div>
               <div class="col-md-2">
               <div class="row">
               <div class="col-md-6">
     <a class="btn btn-success" href="?edit_id=<?php echo $row['id']; ?>" title="click for Edit" ><span class="glyphicon glyphicon-cog"></span></a>
                </div>
                 <div class="col-md-6">
     <a class="btn btn-danger" href="?delete_id=<?php echo $row['id']; ?>" title="click for Delete" ><span class="glyphicon glyphicon-remove-circle"></span></a>
              </div>
              </div>
              </div>
              <div class="col-md-1">
              <!-- suppliment javascript popup for different views -->
                 <a   href="?view_id=<?php echo $row['id']; ?>" title="click to view different views of this image" class=" js-tingle-modal-2"><img src="images/more.png" alt="Post" style="height: 40px ;width: 40px ;"></a>
              </div>
            </div>
           <hr>
    <?php
}
           ?>

            <?php
        }
    }

?>

   <!-- /Tingle big content -->

   
    <script type="text/javascript">

    /**
    * Modal Tiny no footer
    */

    var modalTinyNoFooter = new tingle.modal({
        onClose: function() {
            console.log('close');
        },
        onOpen: function() {
            console.log('open');
        },
        beforeOpen: function() {
            console.log('before open');
        },
        beforeClose: function() {
            console.log('before close');
            return true;
        },
        cssClass: ['class1', 'class2']
    });
    var btn = document.querySelector('.js-tingle-modal-1');
    btn.addEventListener('click', function(){
        modalTinyNoFooter.open();
    });
    modalTinyNoFooter.setContent(document.querySelector('.tingle-demo-tiny').innerHTML);

    /**
    * Modal tiny with btn
    */

    var modalTinyBtn = new tingle.modal({
        footer: true
    });
    var btn2 = document.querySelector('.js-tingle-modal-2');

    btn2.addEventListener('click', function(){
        modalTinyBtn.open();
    });

    modalTinyBtn.setContent(document.querySelector('.tingle-demo-tiny').innerHTML);

    modalTinyBtn.addFooterBtn('Primary action', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function() {
        alert('click on primary button!');
    });

    modalTinyBtn.addFooterBtn('Cancel', 'tingle-btn tingle-btn--default tingle-btn--pull-right', function(){
        modalTinyBtn.close();
    });

    modalTinyBtn.addFooterBtn('Danger!', 'tingle-btn tingle-btn--danger', function(){
        alert('click on danger button!');
    });

    /**
    * Modal big
    */

    var modalBigContent = new tingle.modal();
    var btn3 = document.querySelector('.js-tingle-modal-3');
    btn3.addEventListener('click', function(){
        modalBigContent.open();
    });
    modalBigContent.setContent(document.querySelector('.tingle-demo-big').innerHTML);

    /**
    * Modal big with sticky footer
    */
    var modalStickyFooter = new tingle.modal({
        footer: true,
        stickyFooter: true
    });
    var btn4 = document.querySelector('.js-tingle-modal-4');
    btn4.addEventListener('click', function(){
        modalStickyFooter.open();
    });


    modalStickyFooter.addFooterBtn('I agree', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function(){
        modalStickyFooter.close();
    });

    modalStickyFooter.addFooterBtn('Cancel', 'tingle-btn tingle-btn--default tingle-btn--pull-right', function(){
        modalStickyFooter.close();
    });

    modalStickyFooter.setContent(document.querySelector('.tingle-demo-sticky').innerHTML);

    /**
    *   Force close button
    */

    var modalButtonOnly = new tingle.modal({
        closeMethods: [],
        footer: true,
        stickyFooter: true
    });
    var btn5 = document.querySelector('.js-tingle-modal-5');
    btn5.addEventListener('click', function(){
        modalButtonOnly.open();
    });
    modalButtonOnly.setContent(document.querySelector('.tingle-demo-force-close').innerHTML);

    modalButtonOnly.addFooterBtn('I agree', 'tingle-btn tingle-btn--primary tingle-btn--pull-right', function(){
        modalButtonOnly.close();
    });

    modalButtonOnly.addFooterBtn('Cancel', 'tingle-btn tingle-btn--default tingle-btn--pull-right', function(){
        modalButtonOnly.close();
    });

    /**
    *   Modal suprise
    */
    var btn6 = document.querySelector('.js-tingle-modal-6');
    btn6.addEventListener('click', function(){
        var modalSurprise = new tingle.modal({
            onClose: function(){
                modalSurprise.destroy();
            }
        });
        modalSurprise.setContent('<iframe width="100%" height="400" src="https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1" frameborder="0" allowfullscreen></iframe>');
        modalSurprise.open();
    });

    </script>
    
    
