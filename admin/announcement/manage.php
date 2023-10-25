manage.php
<?php
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `announcement` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update " : "Create New " ?>Create Announcement</h3>
	</div>
	<div class="card-body">
		<form action="" id="act-form">
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
			<div class="form-group">
				<label for="about" class="control-label">About</label>
                <textarea name="about" id="" cols="30" rows="2" class="form-control form no-resize"><?php echo isset($about) ? $about : ''; ?></textarea>
			</div>
            <div class="form-group">
				<label for="announcements" class="control-label">Announcement</label>
                <textarea name="announcements" id="" cols="30" rows="2" class="form-control form no-resize summernote"><?php echo isset($announcements) ? $announcements : ''; ?></textarea>
			</div>
            <div class="form-group">
				<label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select select">
                    <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : ''; ?>>Done</option>
                    <option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : ''; ?>>Upcoming</option>
                </select>
			</div>
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-lg btn-primary" form="act-form">Save</button>
		<a class="btn btn-lg btn-default" href="?page=announcement" style="background-color:red;color:white;">Cancel</a>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('#act-form').submit(function (e) {
			e.preventDefault();
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=save_announcement",
				data: new FormData($(this)[0]),
				cache: false,
				contentType: false,
				processData: false,
				method: 'POST',
				type: 'POST',
				dataType: 'json',
				error: err => {
					console.log(err);
					alert_toast("An error occurred", 'error');
					end_loader();
				},
				success: function (resp) {
					if (typeof resp == 'object' && resp.status == 'success') {
						location.href = "./?page=announcement";
					} else {
						alert_toast("An error occurred", 'error');
						end_loader();
						console.log(resp);
					}
				}
			});
		});

		$('.summernote').summernote({
			height: 200,
			toolbar: [
				['style', ['style']],
				['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
				['fontname', ['fontname']],
				['fontsize', ['fontsize']],
				['color', ['color']],
				['para', ['ol', 'ul', 'paragraph', 'height']],
				['table', ['table']],
				['view', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
			]
		});
	});
</script>