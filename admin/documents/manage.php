<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `documents` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="card card-outline card-info">
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?>Document</h3>
    </div>
    <div class="card-body">
        <form action="" id="act-form">
            <input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
            <div class="form-group">
                <label for="" class="control-label">Document</label>
                <div class="custom-file">
                <input type="file" class="custom-file-input" id="customFile" name="doc[]" multiple accept=".pdf, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .txt, .jpg,.png, .jpeg" onchange="displayDocs(this, $(this))" required>
                  <label class="custom-file-label" for="customFile">Choose Document</label>
                </div>
            </div>
           
            <div class="form-group" id="docu_title_group" style="display: none;">
    <label for="docu_description" class="control-label">Document Title</label>
    <input type="text" name="docu_title" class="form-control" id="docu_title">
</div>

            <div class="form-group">
                <label for="docu_description" class="control-label">Description</label>
                <textarea name="docu_description" id="" cols="30" rows="2" class="form-control form no-resize summernote"><?php echo isset($docu_description) ? $docu_description : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="custom-select selevt">
                <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Uploaded</option>
                <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>To Update</option>
                </select>
            </div>
            
            <?php if (isset($upload_path) && is_dir(base_app.$upload_path)): ?>
            <?php 
            $files = scandir(base_app.$upload_path);
                foreach ($files as $doc):
                 if (in_array($doc, array('.', '..')))
                 continue;
             ?>
                  <div class="d-flex w-100 align-items-center file-item">
                 <span><a href="<?php echo base_url.$upload_path.'/'.$doc ?>" target="_blank"><?php echo $doc ?></a></span>
                 <span class="ml-4"><button class="btn btn-sm btn-default text-danger rem_doc" type="button" data-path="<?php echo base_app.$upload_path.'/'.$doc ?>"><i class="fa fa-trash"></i></button></span>
                 </div>
            <?php endforeach; ?>
            <?php endif; ?>

        </form>
    </div>
    <div class="card-footer">
        <button class="btn btn-lg btn-primary" form="act-form">Upload</button>
        <a class="btn btn-lg btn-default" href="?page=documents" style="background-color:red;color:white;">Cancel</a>
    </div>
</div>
<script>
  
  function displayDocs(input, _this) {
    var docNames = [];
    Object.keys(input.files).map(function (k) {
        docNames.push(input.files[k].name);
    });

    var docTitleField = $('#docu_title');
    var chooseDocumentLabel = $('.custom-file-label');

    if (docNames.length > 0) {
        docTitleField.val(docNames.join(', '));
        chooseDocumentLabel.text(docNames.join(', '));
        $('#docu_title_group').show();
    }
}

function delete_doc($path){
        start_loader()
        
        $.ajax({
            url: _base_url_+'classes/Master.php?f=delete_d_doc',
            data:{path:$path},
            method:'POST',
            dataType:"json",
            error:err=>{
                console.log(err)
                alert_toast("An error occured while deleting the File.","error");
                end_loader()
            },
            success:function(resp){
                $('.modal').modal('hide')
                if(typeof resp =='object' && resp.status == 'success'){
                    $('[data-path="'+$path+'"]').closest('.doc-item').hide('slow',function(){
                        $('[data-path="'+$path+'"]').closest('.doc-item').remove()
                    })
                    alert_toast("File Successfully Deleted","success");
                }else{
                    console.log(resp)
                    alert_toast("An error occured while deleting the File","error");
                }
                end_loader()
            }
        })
    }
	$(document).ready(function(){
		$('.rem_doc').click(function(){
            _conf("Are sure to delete this file permanently?",'delete_doc',["'"+$(this).attr('data-path')+"'"])
        })
		$('#act-form').submit(function(e){
			e.preventDefault();
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=upload_document",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=documents";
					}else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

        $('.summernote').summernote({
                height: 200,
                toolbar: [
                    [ 'style', [ 'style' ] ],
                    [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                    [ 'fontname', [ 'fontname' ] ],
                    [ 'fontsize', [ 'fontsize' ] ],
                    [ 'color', [ 'color' ] ],
                    [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                    [ 'table', [ 'table' ] ],
                    [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                ]
            })
    })
</script>
