<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	
	function save_activity(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','description'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['description'])){
			if(!empty($data)) $data .=",";
				$data .= " `description`='".addslashes(htmlentities($description))."' ";
		}
		if(empty($id)){
			$sql = "INSERT INTO `activities` set {$data} ";
			$save = $this->conn->query($sql);
			$id = $this->conn->insert_id;
		}else{
			$sql = "UPDATE `activities` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			if(isset($_FILES['img']) && count($_FILES['img']['tmp_name']) > 0){
				if(!is_dir(base_app.'uploads/activity_'.$id)){
					mkdir(base_app.'uploads/activity_'.$id);
					$data = " `upload_path`= 'uploads/activity_{$id}' ";
				}else{
					$data = " `upload_path`= 'uploads/activity_{$id}' ";
				}
				$this->conn->query("UPDATE `activities` set {$data} where id = '{$id}' ");
				foreach($_FILES['img']['tmp_name'] as $k =>$v){
					move_uploaded_file($_FILES['img']['tmp_name'][$k],base_app.'uploads/activity_'.$id.'/'.$_FILES['img']['name'][$k]);
				}
			}

			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"New Activity successfully saved.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}

	function delete_p_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'unlink file failed.';
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'unlink file failed. File do not exist.';
		}
		return json_encode($resp);
	}

	function delete_activity(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `activities` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			if(is_dir(base_app.'uploads/activity_'.$id)){
				$file = scandir(base_app.'uploads/activity_'.$id);
				foreach($file as $img){
					if(in_array($img,array('..','.')))
						continue;
					unlink(base_app.'uploads/activity_'.$id.'/'.$img);
				}
				rmdir(base_app.'uploads/activity_'.$id);
			}
			$this->settings->set_flashdata('success',"Activity successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function act_registration(){
    extract($_POST);
    $user_id = $this->settings->userdata('id');
    $address = $this->conn->real_escape_string($address); // Sanitize user input
				$contact = $this->conn->real_escape_string($contact);
	
    // Handle "Gender" and "Status" as arrays
    $gender = implode(', ', $gender);
    $status = implode(', ', $status); 
				$category = implode(', ', $category);

    $query = "INSERT INTO `registration_list` (user_id, activity_id, address, gender, category, contact, schedule, status) VALUES ('$user_id', '$activity_id', '$address', '$gender','$category','$contact', '$schedule', '$status')";
    
    $save = $this->conn->query($query);

    if($save){
        $resp['status'] = 'success';
    } else {
        $resp['status'] = 'failed';
        $resp['error'] = $this->conn->error;
    }

    return json_encode($resp);
}

function act_attendance() {
	extract($_POST);
	$user_id = $this->settings->userdata('id');
	$registration_id = $this->settings->userdata('id');
	$status = implode(', ', $status);
	

	$query = "INSERT INTO `attendance_list` (user_id, activity_id, registration_id, attendance_date, date_created, status) 
											VALUES ('$user_id', '$activity_id', '$registration_id', '$attendance_date', NOW(), '$status')";

	$save = $this->conn->query($query);

	if ($save) {
					$resp['status'] = 'success';
	} else {
					$resp['status'] = 'failed';
					$resp['error'] = $this->conn->error;
	}

	return json_encode($resp);
}


	function register(){
		extract($_POST);
		$data = "";
		$_POST['password'] = md5($password);
		foreach($_POST as $k =>$v){
				if(!empty($data)) $data .=",";
					$data .= " `{$k}`='{$v}' ";
		}
		$check = $this->conn->query("SELECT * FROM `users` where username='{$username}' ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Username already taken.";
			return json_encode($resp);
			exit;
		}
		$save = $this->conn->query("INSERT INTO `users` set $data ");
		if($save){
			foreach($_POST as $k =>$v){
				$this->settings->set_userdata($k,$v);
			}
			$this->settings->set_userdata('id',$this->conn->insert_id);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function update_account(){
		extract($_POST);
		$data = "";
		if(!empty($password)){
			$_POST['password'] = md5($password);
			if(md5($cpassword) != $this->settings->userdata('password')){
				$resp['status'] = 'failed';
				$resp['msg'] = "Current Password is Incorrect";
				return json_encode($resp);
				exit;
			}

		}
		$check = $this->conn->query("SELECT * FROM `users`  where `username`='{$username}' and `id` != $id ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Username already taken.";
			return json_encode($resp);
			exit;
		}
		foreach($_POST as $k =>$v){
			if($k == 'cpassword' || ($k == 'password' && empty($v)))
				continue;
				if(!empty($data)) $data .=",";
					$data .= " `{$k}`='{$v}' ";
		}
		$save = $this->conn->query("UPDATE `users` set $data where id = $id ");
		if($save){
			foreach($_POST as $k =>$v){
				if($k != 'cpassword')
				$this->settings->set_userdata($k,$v);
			}
			
			$this->settings->set_userdata('id',$this->conn->insert_id);
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}


	function save_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
				if(!empty($data)) $data .=",";
					$data .= " `{$k}`='{$v}' ";
		}
		$save = $this->conn->query("INSERT INTO `users` set $data");
		if($save){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	
	function rate_review(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if($k=='review')
			$v = addslashes(htmlentities($v));
				if(!empty($data)) $data .=",";
					$data .= " `{$k}`='{$v}' ";
		}
		$data .= ", `user_id`='".$this->settings->userdata('id')."' ";
		$save = $this->conn->query("INSERT INTO `rate_review` set $data");
		if($save){
			$resp['status'] = 'success';
			// $this->settings->set_flashdata("success","Rate & Review submitted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function delete_user(){
		$del = $this->conn->query("DELETE FROM `users` where id='{$_POST['id']}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success","User Deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_review(){
		$del = $this->conn->query("DELETE FROM `rate_review` where id='{$_POST['id']}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success","Feedback Deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function delete_registration(){
		$del = $this->conn->query("DELETE FROM `registration_list` where id='{$_POST['id']}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success","Registration Deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function delete_attendance(){
		$del = $this->conn->query("DELETE FROM `attendance_list` where id='{$_POST['id']}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success","Attendance Deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function delete_video() {
		$del = $this->conn->query("DELETE FROM `video` where id='{$_POST['id']}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success","Video Deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function delete_staff() {
		$del = $this->conn->query("DELETE FROM `staff` where id='{$_POST['id']}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata("success","Staff Deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}


	function upload_document() {
		extract($_POST);
		$data = "";

		foreach ($_POST as $k => $v) {
			if (!in_array($k, array('id', 'docu_description'))) {
				if (!empty($data)) $data .= ",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
	
		if (isset($_POST['docu_description'])) {
			if (!empty($data)) $data .= ",";
			$data .= " `docu_description`='" . addslashes(htmlentities($docu_description)) . "' ";
		}
	
		if (empty($id)) {
			$sql = "INSERT INTO `documents` SET {$data}";
			$save = $this->conn->query($sql);
			$id = $this->conn->insert_id;
		} else {
			$sql = "UPDATE `documents` SET {$data} WHERE id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
	
		if ($save) {
			if (isset($_FILES['doc']) && count($_FILES['doc']['tmp_name']) > 0) {
				if (!is_dir(base_app . 'uploads/document_' . $id)) {
					mkdir(base_app . 'uploads/document_' . $id);
					$data = " `upload_path`= 'uploads/document_{$id}' ";
				} else {
					$data = " `upload_path`= 'uploads/document_{$id}' ";
				}
				$this->conn->query("UPDATE `documents` SET {$data} WHERE id = '{$id}' ");
	
				foreach ($_FILES['doc']['tmp_name'] as $k => $v) {
					move_uploaded_file($_FILES['doc']['tmp_name'][$k], base_app . 'uploads/document_' . $id . '/' . $_FILES['doc']['name'][$k]);
				}
			}
	
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success', "New Document successfully saved.");
		} else {
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error . "[{$sql}]";
		}
		return json_encode($resp);
	}
	 
	function delete_d_doc(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'unlink file failed.';
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'unlink file failed. File do not exist.';
		}
		return json_encode($resp);
	}
	
	function delete_document(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `documents` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			if(is_dir(base_app.'uploads/document_'.$id)){
				$file = scandir(base_app.'uploads/document_'.$id);
				foreach($file as $img){
					if(in_array($img,array('..','.')))
						continue;
					unlink(base_app.'uploads/document_'.$id.'/'.$img);
				}
				rmdir(base_app.'uploads/document_'.$id);
			}
			$this->settings->set_flashdata('success',"File successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

	function save_announcement(){
		extract($_POST);
		$data = "";
		
		foreach($_POST as $k => $v){
						if (!in_array($k, array('id', 'announcements'))) {
										if (!empty($data)) $data .= ",";
										$data .= " `{$k}`='{$v}' ";
						}
		}
		
		if (isset($_POST['announcements'])) {
						if (!empty($data)) $data .= ",";
						$data .= " `announcements`='".addslashes(htmlentities($announcements))."' ";
		}
		
		if (empty($id)){
						$sql = "INSERT INTO `announcement` SET {$data}";
						$save = $this->conn->query($sql);
						$id = $this->conn->insert_id;
		} else {
						$sql = "UPDATE `announcement` SET {$data} WHERE id = '{$id}'";
						$save = $this->conn->query($sql);
		}
		
		if ($save){
						$resp['status'] = 'success';
						$this->settings->set_flashdata('success', "Announcement successfully saved.");
		} else {
						$resp['status'] = 'failed';
						$resp['err'] = $this->conn->error . " [{$sql}]";
		}
		
		return json_encode($resp);
}

	function delete_announcement(){
			$del = $this->conn->query("DELETE FROM `announcement` where id='{$_POST['id']}'");
			if($del){
				$resp['status'] = 'success';
				$this->settings->set_flashdata("success","Announcement Deleted.");
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = $this->conn->error;
			}
			return json_encode($resp);
		}


}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_activity':
		echo $Master->save_activity();
	break;
	case 'delete_activity':
		echo $Master->delete_activity();
	break;
	case 'delete_p_img':
		echo $Master->delete_p_img();
	break;
	case 'act_registration':
		echo $Master->act_registration();
	break;
	case 'act_attendance':
		echo $Master->act_attendance();
	break;
	case 'register':
		echo $Master->register();
	break;
	case 'update_account':
		echo $Master->update_account();
	break;
	case 'save_user':
		echo $Master->save_user();
	break;
	case 'save_announcement':
		echo $Master->save_announcement();
	break;
	case 'rate_review':
		echo $Master->rate_review();
	break;
	case 'delete_announcement':
		echo $Master->delete_announcement();
	break;
	case 'delete_user':
		echo $Master->delete_user();
	break;
	case 'delete_registration':
		echo $Master->delete_registration();
	break;
	case 'delete_attendance':
		echo $Master->delete_attendance();
	break;
	case 'delete_review':
		echo $Master->delete_review();
	break;
	case 'upload_document':
		echo $Master->upload_document();
	break;
	case 'delete_d_doc':
		echo $Master->delete_d_doc();
	break;
	case 'delete_document':
		echo $Master->delete_document();
	break;
	case 'delete_announcement':
		echo $Master->delete_announcement();
	break;
	case 'delete_video':
		echo $Master->delete_video();
	break;
	case 'delete_staff':
		echo $Master->delete_staff();
	break;
	default:
		// echo $sysset->index();
		break;
}