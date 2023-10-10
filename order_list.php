<?php if (count($BG_Order)>0) { ?>
  <center style="padding:1px ;background-color: #476785; color: #fff;"> <h4 style="font-family: emoji;font-size:19px;">  Order Upload</h4> </center> 
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead>
            <tr style="background-color: #BBDEFB">
              <th style="width: 12%;">Project RC</th>
              <th style="width: 18%;">Project Name</th>
              <th style="width: 18%;"> Promoter Name</th>
              <th style="width: 10%;">Hearing Date</th>
              <th style="width: 10%;">Next Hearing Date</th>
              <th style="width: 12%;"> Order File</th>
              <th> Remarks </th>
              <th style="width: 8%"> Upload </th>
            </tr> 
          </thead>
          <tbody>                    
            <?php $i = 0; foreach ($BG_Order as $pro_detail) { $i++; ?>
              <tr>     
                <form method="post" class="form-horizontal" enctype="multipart/form-data" id="BG_order_upload">                                    
                  <td><?=$pro_detail->project_rc; ?></td>
                  <td><?=$pro_detail->project_name; ?> </td>
                  <td><?=$pro_detail->permoter_name; ?> </td>
                  <td><?=std_date($pro_detail->current_hearing_date); ?> </td>
                  <td><?=std_date($pro_detail->hearing_date); ?> </td>
                  <td><input type="file" class="form-control order_upload" name="order_upload" style="float: left; width: 70%; margin-right: 10px;"></td>
                  <td>
                    <textarea class="form-control remarks"  name="remarks" placeholder="Remarks.."></textarea>
                  </td> 
                  <td>
                    <input type="hidden" name="edit_id" class="edit_id" value="<?= $pro_detail->id ?>">
                    <input type="submit" class="btn btn-lg btn-success waves-effect bgbtn" value="Upload" style="font-size: 15px;">
                  </td>
                </form>           
              </tr> 
            <?php } ?>
          </tbody>
        </table>      
      </div>                          
<?php } else{  ?>
  <h4 style="color: #000000a3;text-align: center;font-size:15px;">No Records Found..</h4>
<?php } ?>

<script>
  $(document).ready(function(){    
    function bg_load(){
      $.ajax({
        url : "<?= base_url('Project_rc_details/SearchBg'); ?>",
        type: 'POST',
        beforeSend: function() {
          $("#overlay").fadeIn(300);
        },
        success: function (data) {
          setTimeout(function(){
            $("#overlay").fadeOut(300);
          },500);                                 
          $("#mypar").html(data);
        },
        error: function (data) {
          setTimeout(function(){
            $("#overlay").fadeOut(300);
          },500);
        }
      });
    }

    $(".bgbtn").click(function(event){
      event.preventDefault();
      current=$(this).closest('tr');
      var edit_id = current.find('.edit_id').val();
      var remarks = current.find('.remarks').val();
      var file    = current.find('.order_upload').prop('files')[0]; 
      var form_data = new FormData();
      form_data.append('order_upload', file);
      form_data.append('edit_id', edit_id);
      form_data.append('remarks', remarks);
      $.ajax({
        url : "<?= base_url('Project_rc_details/Upload_BGorder'); ?>",
        type: 'POST',
        contentType: 'multipart/form-data',
        data : form_data,
        processData: false,
        contentType: false,
        cache:false,
        beforeSend: function() {
          $("#overlay").fadeIn(300);
        },
        success: function (data) { 
          console.log(data);
          if(data=='error 1'){
            toastr.error("Pls. select files..");
          }else if(data=='error 2'){
            toastr.error("Pls upload pdf file.. ");
          }else{
            toastr.success("Upload successful");
          }
          setTimeout(function(){
            $("#overlay").fadeOut(300);
          },500);
          bg_load();
        },
        error: function (data) {
          console.log(data);
          toastr.error("Upload failed");
          setTimeout(function(){
            $("#overlay").fadeOut(300);
          },500);
        }
      })
    });
  });
</script>