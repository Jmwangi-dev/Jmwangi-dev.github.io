<?php 
session_start();
require_once('DBConnection.php');

Class Actions extends DBConnection{
    function __construct(){
        parent::__construct();
    }
    function __destruct(){
        parent::__destruct();
    }
    function login(){
        extract($_POST);
        $sql = "SELECT * FROM user_list where username = '{$username}' and `password` = '".md5($password)."' ";
        @$qry = $this->query($sql)->fetchArray();
        if(!$qry){
            $resp['status'] = "failed";
            $resp['msg'] = "Invalid username or password.";
        }else{
            $resp['status'] = "success";
            $resp['msg'] = "Login successfully.";
            foreach($qry as $k => $v){
                if(!is_numeric($k))
                $_SESSION[$k] = $v;
            }
        }
        return json_encode($resp);
    }
    function logout(){
        session_destroy();
        header("location:./");
    }
    function save_user(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
        if(!in_array($k,array('id'))){
            if(!empty($id)){
                if(!empty($data)) $data .= ",";
                $data .= " `{$k}` = '{$v}' ";
                }else{
                    $cols[] = $k;
                    $values[] = "'{$v}'";
                }
            }
        }
        if(empty($id)){
            $cols[] = 'password';
            $values[] = "'".md5($username)."'";
        }
        if(isset($cols) && isset($values)){
            $data = "(".implode(',',$cols).") VALUES (".implode(',',$values).")";
        }
        

       
        @$check= $this->query("SELECT count(user_id) as `count` FROM user_list where `username` = '{$username}' ".($id > 0 ? " and user_id != '{$id}' " : ""))->fetchArray()['count'];
        if(@$check> 0){
            $resp['status'] = 'failed';
            $resp['msg'] = "Username already exists.";
        }else{
            if(empty($id)){
                $sql = "INSERT INTO `user_list` {$data}";
            }else{
                $sql = "UPDATE `user_list` set {$data} where user_id = '{$id}'";
            }
            @$save = $this->query($sql);
            if($save){
                $resp['status'] = 'success';
                if(empty($id))
                $resp['msg'] = 'New User successfully saved.';
                else
                $resp['msg'] = 'User Details successfully updated.';
            }else{
                $resp['status'] = 'failed';
                $resp['msg'] = 'Saving User Details Failed. Error: '.$this->lastErrorMsg();
                $resp['sql'] =$sql;
            }
        }
        return json_encode($resp);
    }
    function delete_user(){
        extract($_POST);

        @$delete = $this->query("DELETE FROM `user_list` where rowid = '{$id}'");
        if($delete){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'User successfully deleted.';
        }else{
            $resp['status']='failed';
            $resp['error']=$this->lastErrorMsg();
        }
        return json_encode($resp);
    }
    function update_credentials(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k,array('id','old_password')) && !empty($v)){
                if(!empty($data)) $data .= ",";
                if($k == 'password') $v = md5($v);
                $data .= " `{$k}` = '{$v}' ";
            }
        }
        if(!empty($password) && md5($old_password) != $_SESSION['password']){
            $resp['status'] = 'failed';
            $resp['msg'] = "Old password is incorrect.";
        }else{
            $sql = "UPDATE `user_list` set {$data} where user_id = '{$_SESSION['user_id']}'";
            @$save = $this->query($sql);
            if($save){
                $resp['status'] = 'success';
                $_SESSION['flashdata']['type'] = 'success';
                $_SESSION['flashdata']['msg'] = 'Credential successfully updated.';
                foreach($_POST as $k => $v){
                    if(!in_array($k,array('id','old_password')) && !empty($v)){
                        if(!empty($data)) $data .= ",";
                        if($k == 'password') $v = md5($v);
                        $_SESSION[$k] = $v;
                    }
                }
            }else{
                $resp['status'] = 'failed';
                $resp['msg'] = 'Updating Credentials Failed. Error: '.$this->lastErrorMsg();
                $resp['sql'] =$sql;
            }
        }
        return json_encode($resp);
    }
    function save_department(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k,array('id'))){
                $v = trim($v);
                $v = $this->escapeString($v);
            if(empty($id)){
                $cols[] = "`{$k}`";
                $vals[] = "'{$v}'";
            }else{
                if(!empty($data)) $data .= ", ";
                $data .= " `{$k}` = '{$v}' ";
            }
            }
        }
        if(isset($cols) && isset($vals)){
            $cols_join = implode(",",$cols);
            $vals_join = implode(",",$vals);
        }
        if(empty($id)){
            $sql = "INSERT INTO `department_list` ({$cols_join}) VALUES ($vals_join)";
        }else{
            $sql = "UPDATE `department_list` set {$data} where department_id = '{$id}'";
        }
        @$check= $this->query("SELECT COUNT(department_id) as count from `department_list` where `name` = '{$name}' ".($id > 0 ? " and department_id != '{$id}'" : ""))->fetchArray()['count'];
        if(@$check> 0){
            $resp['status'] ='failed';
            $resp['msg'] = 'Department already exists.';
        }else{
            @$save = $this->query($sql);
            if($save){
                $resp['status']="success";
                if(empty($id))
                    $resp['msg'] = "Department successfully saved.";
                else
                    $resp['msg'] = "Department successfully updated.";
            }else{
                $resp['status']="failed";
                if(empty($id))
                    $resp['msg'] = "Saving New Department Failed.";
                else
                    $resp['msg'] = "Updating Department Failed.";
                $resp['error']=$this->lastErrorMsg();
                $resp['sql']=$sql;
            }
        }
        return json_encode($resp);
    }
    function delete_department(){
        extract($_POST);

        @$delete = $this->query("DELETE FROM `department_list` where department_id = '{$id}'");
        if($delete){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Department successfully deleted.';
        }else{
            $resp['status']='failed';
            $resp['error']=$this->lastErrorMsg();
        }
        return json_encode($resp);
    }
    function save_designation(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k,array('id'))){
                $v = addslashes(trim($v));
            if(empty($id)){
                $cols[] = "`{$k}`";
                $vals[] = "'{$v}'";
            }else{
                if(!empty($data)) $data .= ", ";
                $data .= " `{$k}` = '{$v}' ";
            }
            }
        }
        if(isset($cols) && isset($vals)){
            $cols_join = implode(",",$cols);
            $vals_join = implode(",",$vals);
        }
        if(empty($id)){
            $sql = "INSERT INTO `designation_list` ({$cols_join}) VALUES ($vals_join)";
        }else{
            $sql = "UPDATE `designation_list` set {$data} where designation_id = '{$id}'";
        }
        @$check= $this->query("SELECT COUNT(designation_id) as count from `designation_list` where `name` = '{$name}' ".($id > 0 ? " and designation_id != '{$id}'" : ""))->fetchArray()['count'];
        if(@$check> 0){
            $resp['status'] ='failed';
            $resp['msg'] = 'Designation already exists.';
        }else{
            @$save = $this->query($sql);
            if($save){
                $resp['status']="success";
                if(empty($id))
                    $resp['msg'] = "Designation successfully saved.";
                else
                    $resp['msg'] = "Designation successfully updated.";
            }else{
                $resp['status']="failed";
                if(empty($id))
                    $resp['msg'] = "Saving New Designation Failed.";
                else
                    $resp['msg'] = "Updating Designation Failed.";
                $resp['error']=$this->lastErrorMsg();
            }
        }
        return json_encode($resp);
    }
    function delete_designation(){
        extract($_POST);

        @$delete = $this->query("DELETE FROM `designation_list` where designation_id = '{$id}'");
        if($delete){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Designation successfully deleted.';
        }else{
            $resp['status']='failed';
            $resp['error']=$this->lastErrorMsg();
        }
        return json_encode($resp);
    }
    function save_vacancy(){
        extract($_POST);
        $data = "";
        $_POST['description'] = htmlentities($_POST['description']);
        foreach($_POST as $k => $v){
            if(!in_array($k,array('id'))){
                $v = addslashes(trim($v));
            if(empty($id)){
                $cols[] = "`{$k}`";
                $vals[] = "'{$v}'";
            }else{
                if(!empty($data)) $data .= ", ";
                $data .= " `{$k}` = '{$v}' ";
            }
            }
        }
        if(isset($cols) && isset($vals)){
            $cols_join = implode(",",$cols);
            $vals_join = implode(",",$vals);
        }
        if(empty($id)){
            $sql = "INSERT INTO `vacancy_list` ({$cols_join}) VALUES ($vals_join)";
        }else{
            $sql = "UPDATE `vacancy_list` set {$data} where vacancy_id = '{$id}'";
        }
        @$check= $this->query("SELECT COUNT(vacancy_id) as count from `vacancy_list` where `designation_id` = '{$designation_id}' and status = 1 ".($id > 0 ? " and vacancy_id != '{$id}'" : ""))->fetchArray()['count'];
        if(@$check> 0){
            $resp['status'] ='failed';
            $resp['msg'] = 'Designation still have an Active Vacancy.';
        }else{
            @$save = $this->query($sql);
            if($save){
                $resp['status']="success";
                if(empty($id))
                    $resp['msg'] = "Vacancy successfully saved.";
                else
                    $resp['msg'] = "Vacancy successfully updated.";
            }else{
                $resp['status']="failed";
                if(empty($id))
                    $resp['msg'] = "Saving New Vacancy Failed.";
                else
                    $resp['msg'] = "Updating Vacancy Failed.";
                $resp['error']=$this->lastErrorMsg();
            }
        }
        return json_encode($resp);
    }
    function delete_vacancy(){
        extract($_POST);

        @$delete = $this->query("DELETE FROM `vacancy_list` where vacancy_id = '{$id}'");
        if($delete){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Vacancy successfully deleted.';
        }else{
            $resp['status']='failed';
            $resp['error']=$this->lastErrorMsg();
        }
        return json_encode($resp);
    }
    function save_settings(){
        extract($_POST);
        file_put_contents('./about.html',htmlentities($about));
        file_put_contents('./welcome.html',htmlentities($welcome));
        $resp['status'] = "success";
        $resp['msg'] = "Settings successfully updated.";
        return json_encode($resp);
    }
    function save_application(){
        extract($_POST);
        $data = "";
        foreach($_POST as $k => $v){
            if(!in_array($k,array('id')) && !is_array($_POST[$k])){
                $v = $this->escapeString(trim($v));
            if(empty($id)){
                $cols[] = "`{$k}`";
                $vals[] = "'{$v}'";
            }else{
                if(!empty($data)) $data .= ", ";
                $data .= " `{$k}` = '{$v}' ";
            }
            }
        }
        if(isset($cols) && isset($vals)){
            $cols_join = implode(",",$cols);
            $vals_join = implode(",",$vals);
        }
        if(empty($id)){
            $sql = "INSERT INTO `applicant_list` ({$cols_join}) VALUES ($vals_join)";
        }else{
            $sql = "UPDATE `applicant_list` set {$data} where vacancy_id = '{$id}'";
        }
        $save = $this->query($sql);
        if($save){
            $applicant_id = $this->query("SELECT last_insert_rowid()")->fetchArray()[0];
            if(isset($company_name)){
                $data="";
                foreach($company_name as $k=> $v){
                    if(!isset($still_active[$k])){
                        $still_active[$k] = 0;
                    }else{
                        $still_active[$k] = 1;
                    }
                    if(!empty($data)) $data .=", ";
                    $data .="('{$applicant_id}','{$company_name[$k]}','{$from[$k]}','{$to[$k]}','{$position[$k]}','{$brief_info[$k]}','{$still_active[$k]}')";
                }
                $ins = $this->query("INSERT INTO `employment` (`applicant_id`,`company_name`,`from`,`to`,`position`,`brief_info`,`still_active`) VALUES {$data}");
            }

            if(isset($school_name)){
                $data="";
                foreach($school_name as $k=> $v){
                    if(!empty($data)) $data .=", ";
                    $data .="('{$applicant_id}','{$school_name[$k]}','{$school_from[$k]}','{$school_to[$k]}','{$level[$k]}','{$school_address[$k]}')";
                }
                $ins = $this->query("INSERT INTO `educational` (`applicant_id`,`school_name`,`from`,`to`,`level`,`school_address`) VALUES {$data}");
            }
            if(isset($skills)){
                $data="";
                foreach($skills as $k=> $v){
                    if(!empty($data)) $data .=", ";
                    $data .="('{$applicant_id}','{$skills[$k]}')";
                }
                $ins = $this->query("INSERT INTO `skills` (`applicant_id`,`skill`) VALUES {$data}");
            }
            $resp['status']='success';
        }else{
            $resp['status']='failed';
        }
        
        return json_encode($resp);
    }
    function update_applicant_stats(){
        extract($_POST);
        $sql = "UPDATE `applicant_list` set `status` = '{$status}' where applicant_id = '{$id}'";
        $save = $this->query($sql);
        if($save){
            $resp['status']='success';
            $resp['msg'] = "Application status successfully updated";
        }else{
            $resp['status']='success';
            $resp['msg'] = "Application status failed to update. Error: ".$this->lastErrMsg();
        }
        return json_encode($resp);
    }
    function delete_applicant(){
        extract($_POST);

        @$delete = $this->query("DELETE FROM `applicant_list` where applicant_id = '{$id}'");
        if($delete){
            $resp['status']='success';
            $_SESSION['flashdata']['type'] = 'success';
            $_SESSION['flashdata']['msg'] = 'Application successfully deleted.';
        }else{
            $resp['status']='failed';
            $resp['error']=$this->lastErrorMsg();
        }
        return json_encode($resp);
    }
}
$a = isset($_GET['a']) ?$_GET['a'] : '';
$action = new Actions();
switch($a){
    case 'login':
        echo $action->login();
    break;
    case 'customer_login':
        echo $action->customer_login();
    break;
    case 'logout':
        echo $action->logout();
    break;
    case 'customer_logout':
        echo $action->customer_logout();
    break;
    case 'save_user':
        echo $action->save_user();
    break;
    case 'delete_user':
        echo $action->delete_user();
    break;
    case 'update_credentials':
        echo $action->update_credentials();
    break;
    case 'save_department':
        echo $action->save_department();
    break;
    case 'delete_department':
        echo $action->delete_department();
    break;
    case 'save_designation':
        echo $action->save_designation();
    break;
    case 'delete_designation':
        echo $action->delete_designation();
    break;
    case 'save_vacancy':
        echo $action->save_vacancy();
    break;
    case 'delete_vacancy':
        echo $action->delete_vacancy();
    break;
    case 'save_settings':
        echo $action->save_settings();
    break;
    case 'save_application':
        echo $action->save_application();
    break;
    case 'update_applicant_stats':
        echo $action->update_applicant_stats();
    break;
    case 'delete_applicant':
        echo $action->delete_applicant();
    break;
    default:
    // default action here
    break;
}
