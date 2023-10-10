<!DOCTYPE html>
<html>
<head>
	<title>PHP REST API CRUD</title>
	<link rel="stylesheet" type="text/css" href="css/style.css"></li>
</head>
<body>
	<table id="main" border="0" cellspacing="0">
		<tr>
			<td id="header">
				<h1>PHP REST API CRUD</h1>
				<div id="search-bar">
					<label>Search :</label>
					<input type="text" id="search" autocomplete="off">
				</div>
			</td>
		</tr>
		<tr>
			<td id="table-form">
				<form id="addform" enctype="multipart/form-data">
					Firstname: 
					<input type="text" name="fname" id="fname">
					Lastname: 
					<input type="text" name="lname" id="lname">
					<input type="submit" id="save-button" value="Save">
				</form>
			</td>
		</tr>
		<tr>
			<td id="table-data">
				<table width="100%" cellpadding="10px">
					<tr>
						<th width="40px">ID</th>
						<th>Firstname</th>
						<th width="50px">Lastname</th>
						<th width="60px">Edit</th>
						<th width="70px">Delete</th>
					</tr>
					<tbody id="load-table">
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tbody>
				</table>
			</td>
		</tr>
	</table>
	<div id="error-message" class="message"></div>
	<div id="success-message" class="message"></div>

	<!-- popup modal box for update records -->
	<div id="modal">
		<div id="modal-form">
			<h2>Edit Form</h2>
			<form id="edit-form">
				<table cellpadding="10px" width="100%">
					<tr>
						<td width="90px">First Name</td>
						<td>
							<input type="text" name="fname" id="edit-fname">
							<input type="text" name="fid" id="edit-id" hidden="">
						</td>
					</tr>
					<tr>
						<td>Last Name</td>
						<td>
							<input type="text" name="lname" id="edit-lname">
						</td>
					</tr>
					<tr>
						<td></td>
						<td>
							<input type="button" value="Update" id="edit-submit">
						</td>
					</tr>
				</table>
			</form>
			<div id="close-btn">X</div>
		</div>
	</div>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			//fetch all records
			function loadTable(){
				$('#load-table').html("");
				$.ajax({
					url: 'http://localhost/Rest_Api_Tut/api_fetch_all.php',
					type: 'POST',
					success: function(data){
						if(data.status == false){
							$('#load-table').append("<tr><td colspan='5'>"+data.message+"</td></tr>");
						}else{
							$.each(data, function(key, value){
								$('#load-table').append("<tr>"
																					+"<td>"+value.id+"</td>"
																					+"<td>"+value.firstname+"</td>"
																					+"<td>"+value.lastname+"</td>"
																					+"<td><button class='edit-btn' data-eid='"+value.id+"'>Edit</button></td>"
																					+"<td><button class='delete-btn' data-id='"+value.id+"'>Delete</button></td>"
																				+"</tr>");
							});
						}
					}
				})
			}
			loadTable();

			//fetch single data
			$(document). on("click", ".edit-btn", function(){
				$("#modal").show();
				var user_id=$(this).data('eid');
				$.ajax({
					url: 'http://localhost/Rest_Api_Tut/api_fetch_single.php',
					type: 'POST',
					data :JSON.stringify({"id":user_id}),
					success : function(data){
						console.log(data);
						$('#edit-id').val(data[0].id);
						$('#edit-fname').val(data[0].firstname);
						$('#edit-lname').val(data[0].lastname);
					}
				});
			});

			//show success or error message
			function message(message, status){
				if(status==false){
					$('#error-message').html(message).slideDown();
					setTimeout(function(){
						$('#error-message').slideUp();
					}, 1000)
				}else if(status==true){
					$('#success-message').html(message).slideDown();
					setTimeout(function(){
						$('#success-message').slideUp();
					}, 1000)
				}
			}
			//insert record
			$(document). on("click", "#save-button", function(e){
				e.preventDefault();
				var fname=$('#fname').val();
				var lname=$('#lname').val();
				if(fname == '' || lname == ''){
					message("All fields required", false);
				}else{
					$.ajax({
						url: 'http://localhost/Rest_Api_Tut/api_insert.php',
						type: 'POST',
						data :JSON.stringify({"firstname":fname, "lastname":lname, "flag":1}),
						success : function(data){
							message(data.message, data.status);
							if(data.status == true){
								loadTable();
								$('#addform').trigger("reset");
							}
						},
						error: function(data){
							console.log(data);
						}
					});
				}
			});

			//update record
			$(document). on("click", "#edit-submit", function(e){
				e.preventDefault();
				var id=$('#edit-id').val();
				var fname=$('#edit-fname').val();
				var lname=$('#edit-lname').val();
				if(fname == '' || lname == ''){
					message("All fields required", false);
				}else{
					$.ajax({
						url: 'http://localhost/Rest_Api_Tut/api_update.php',
						type: 'POST',
						data :JSON.stringify({"firstname":fname, "lastname":lname, "id":id}),
						success : function(data){
							message(data.message, data.status);
							if(data.status == true){
								loadTable();
							}
						},
						error: function(data){
							console.log(data);
						}
					});
				}
			});

			//delete record
			$(document). on("click", ".delete-btn", function(){
				if(confirm("Do you really want to delete this record")){
					var row=this;
					var user_id=$(this).data('id');
					$.ajax({
						url: 'http://localhost/Rest_Api_Tut/api_delete.php',
						type: 'POST',
						data :JSON.stringify({"id":user_id}),
						success : function(data){
							message(data.message, data.status);
							if(data.status == true){
								$(row).closest("tr").hide();
							}
						}
					});
				}
			});

			//search records
			$(document). on("keyup", "#search", function(){					
				var search=$(this).val();
				$.ajax({
					url: 'http://localhost/Rest_Api_Tut/api_search.php?search=' +search,
					type: 'GET',
					data :{"search":search},
					success : function(data){
						if(data.status == false){

							$('#load-table').html("");
							$('#load-table').append("<tr><td colspan='5'>"+data.message+"</td></tr>");
						}else{
							$('#load-table').html("");
							$.each(data, function(key, value){
								$('#load-table').append("<tr>"
																					+"<td>"+value.id+"</td>"
																					+"<td>"+value.firstname+"</td>"
																					+"<td>"+value.lastname+"</td>"
																					+"<td><button class='edit-btn' data-eid='"+value.id+"'>Edit</button></td>"
																					+"<td><button class='delete-btn' data-id='"+value.id+"'>Delete</button></td>"
																				+"</tr>");
							});
						}
					}
				});
			});
			$(document). on("click", "#close-btn", function(){
				$("#modal").hide();
			});
		});
	</script>
</body>
</html>