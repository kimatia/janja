<div class="row">
<div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-body" style="position: fixed;">
    <span id="message"></span> 
    <form method="post" id="uploadimage"  enctype="multipart/form-data" class="form-horizontal">

        <!-- room name -->
        <input class="form-control" type="text" name="room_name" id="user_content" placeholder="Enter room name" />
         <!-- room ID -->
         
       <input class="form-control" type="hidden" name="room_code" id="user_content" placeholder="Enter room code" />
        <!-- room description -->
         </br>
        <input class="form-control" id="charInput" type="text" name="room_description"  placeholder="Enter room description" />
         <!-- room capacity -->
          </br>
        <input class="form-control" type="text" name="room_capacity" id="user_content" placeholder="Enter room capacity" />
        <!-- room Image -->
       </br>
       <!-- room price -->
       <input class="form-control " type="text" name="room_price" id="room_price"  placeholder="Enter room room_price" >
       </br>
        <input  type="file" name="file" class="btn btn-default" accept="image/*" />
        </br>
        <button type="submit" name="btnsave" value="send" class="btn btn-default">
        <span class="glyphicon glyphicon-save"></span>save record
        </button>
        
</form> 
  

  </div>
</div>
</div>