<style>
  .form-control-label{text-align:left !important; }
  .header{background: #4db848;font-size:20px;color:white;border-bottom: none !important;}
  .header p{color:white; }
  .card .header h2{color:white; }
  h4{font-weight:bold;font-size:16px;padding:5px;/*background:#4db848*/;color:#ffffff;}
  .label_text{margin-left: 10px;}
</style>

<div class="row"  id="project_add_dev">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="body">
        <div class="tab-content">
          <div role="tabpanel" class="tab-pane fade in active" id="home" style=" background-color: #fff; margin-top: 20px; margin-bottom: 20px">
            <div class="row clearfix">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="header"  style="background-color: #fff">
                  <h4 style="padding:12px ;background-color: #476785; color: #fff; margin-top: -10px; text-align: center;font-size: 19px;font-family: emoji;">BG Search With RC No./Project name</h4>
                </div>
                <div class="col-sm-8"></div>
                <div class="col-sm-4" style="margin-bottom: -46px;">
                  <div class="form-group" style="margin-left: 175px;">
                    <input type="text" id="seach_proj" class="form-control" placeholder="BG Search" style="float: left; background: #cfcfcf42;line-height: 2;border-radius: 5px;border: 1px solid #34313126;width: 55%;  ">
                    <button type="button" id="bttn" value="Search" name="bttn" class="btn btn-lg btn-primary" style="padding: 8px; font-size: 15px" />Search</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div id="mypar" style="margin: 10px; background-color: #fff!important;">
    
        </div>
        <script>                          
          $(document).ready(function(){                             
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

              $("#bttn").click(function(){
                var search = $('#seach_proj').val();                               
                $.ajax({
                  url : "<?= base_url('Project_rc_details/SearchBg'); ?>",
                  type: 'POST',
                  data : {search:search},
                  beforeSend: function() {
                    $("#overlay").fadeIn(300);
                  },
                  success: function (data) {
                    console.log(data);
                    setTimeout(function(){
                      $("#overlay").fadeOut(300);
                    },500);                                 
                    $("#mypar").html(data);
                  },
                  error: function (data) {
                    console.log(data);
                    setTimeout(function(){
                      $("#overlay").fadeOut(300);
                    },500);
                    toastr.error("failed");
                  }
                });
              });


              $("#seach_proj").keyup(function(){
                var search = $('#seach_proj').val();                               
                $.ajax({
                  url : "<?= base_url('Project_rc_details/SearchBg'); ?>",
                  type: 'POST',
                  data : {search:search},
                  success: function (data) {                              
                    $("#mypar").html(data);
                  },
                  error: function (data) {
                    toastr.error("failed");
                  }
                });
              });
          });
        </script>
      </div>
    </div>
  </div>
</div>

