<!-- Tingle tiny content -->
        <div class="tingle-demo tingle-demo-tiny">
        <div class="row">
        <h2 style="color: purple"><center>Add Booking Images</center></h2>
           
             <div class="col-md-4">

               
<label class="switchBtn">
    <input type="checkbox" name="filter" id="filter">
    <div class="slide round">On/Off</div>
</label>
</br>
 <span id="message1"></span> 
<form method="post" id="uploadimagee"  enctype="multipart/form-data" class="form-horizontal">
<!-- ALTER DATABASE my_database CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci -->
      <!-- ALTER TABLE table_name CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci -->
         
           <input class="form-control " type="text" name="image_description" id="image_description"  placeholder="Description" >
            <input class="form-control " type="hidden" name="room_id" id="room_id"  placeholder="id" value="<?php echo $edit_row['id'];?>">
            <input class="form-control " type="hidden" name="room_code" id="  " value="<?php echo $edit_row['roomID'];?>" placeholder="code" >
            <input class="form-control " type="hidden" name="room_price" id="room_price" value="<?php echo $edit_row['roomPrice'];?>" placeholder="code" >
            <input class="form-control " type="hidden" name="room_capacity" id="room_capacity" value="<?php echo $edit_row['roomCapacity'];?>" placeholder="code" >
            <input class="form-control " type="hidden" name="room_name" id="room_name" value="<?php echo $edit_row['roomName'];?>" placeholder="code" >
         

       
      </br>
        <input  type="file" name="file" class="btn btn-success" accept="image/*" />
         </br>
        <button type="submit" name="btnsavee" value="send" class="btn btn-success">
        <span class="glyphicon glyphicon-save"></span>save
        </button>
       
</form>    
     
</div>
<div class="col-md-8">
               <div class="panel-body">
                 <h4 style="color: black"><center><strong>Image Display</strong></center></h4>
               </div>
             </div>

               </div>
            
          </div>    
           
        <!-- /Tingle tiny content -->