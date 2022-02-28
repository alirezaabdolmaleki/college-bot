<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">فهرست سوالات بدون پاسخ</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-bordered table-stripped text-right right" style="direction:rtl">
				<colgroup>
					<col width="15%">
					<col width="40%">
					<col width="25%">
					<col width="20%">
				</colgroup>
				<thead>
					<tr class=" text-center">
						<th>#</th>
						<th>سوال</th>
						<th>تعداد پرسش</th>
						<th>عملیات</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT * FROM `unanswered`  order by question asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['question'] ?></td>
							<td class="text-center"><?php echo number_format($row['no_asks']) ?></td>
							<td class=" text-center">
								 <button type="button" class="btn btn-flat btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		عملیات
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu text-center" role="menu">
				                    <a class="dropdown-item" href="?page=responses/manage&q=<?php echo $row['question'] ?>"><span class="fa fa-edit text-primary"></span> افزودن پاسخ</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> حذف</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("آیا از حذف مطمعن هستید؟","delete_question",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_question($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_unanswer",
			method:"POST",
			data:{id: $id},
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(resp == 1){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>