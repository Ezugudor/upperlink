<?php 
session_start();
// header("Content-Type:application/json");
// require_once("../../../settings/global_config.php");
include_once("../settings/connect.php");
require_once("../settings/config.php");
// include_once(AUTHROOTFULL."session_cpus.php");
include_once("../settings/functions.php");


   //// CHECK if maxmum no of users reached
            $test = $con->prepare("SELECT count(id) FROM user_profile") or die($con->error); 
			$test->execute()  or die($con->error);
			$test->bind_result($totalUsers);
			// $test->store_result()  or die($con->error);
			//check if query returns any result
			$test->fetch();
			if($totalUsers >= 4) {
					     $mainResult = array('success' =>13); // where 13 is maximum users reached flag
  						 echo json_encode($mainResult);
  						 die();
					   			// echo "some information submitted already exist";
				
			   }

$passportName = '';
$resumeName = '';

// we first upload the file to the server 
foreach ($_FILES as $file => $like_FILES) {
	// echo $like_FILES['tmp_name'];
	if($file == 'passport'){
		//process passport
		if($like_FILES['size'] > 100000){ //100kb
			$mainResult = array('success' =>7); //where 7  = is code for passport exceeded
            echo json_encode($mainResult);
            die();
		}else{
			move_uploaded_file($like_FILES['tmp_name'], PASSPORT_PATH.$like_FILES['name']);
			$passportName = $like_FILES['name'];
		}

	}elseif($file == 'resume'){
		//process resume
		if($like_FILES['size'] > 2000000){ //2MB
			$mainResult = array('success' =>8); //where 8  = is code for resume exceeded
            echo json_encode($mainResult);
            die();
		}else{
			move_uploaded_file($like_FILES['tmp_name'], RESUME_PATH.$like_FILES['name']);
			$resumeName = $like_FILES['name'];
		}
	}
}

 if(  (isset($_POST['fname']) && !empty($_POST['fname'])) &&
      (isset($_POST['email']) && !empty($_POST['email']))&&
      (isset($_POST['phone']) && !empty($_POST['phone']))
 	){



		 
		 $firstname= mysql_prep($_POST['fname']);
		 $surname= mysql_prep($_POST['surname']);
		 $phone= mysql_prep($_POST['phone']);
		 $email= mysql_prep($_POST['email']);
		 $cover= mysql_prep($_POST['cover']);
		 
	
		
		     $con->begin_transaction();
			 
			 //////////////////////   insert into auth table    ////////////////////////////////////////////////////////
			 $stmt=$con->prepare(" INSERT into user_profile(surname,firstname,email,phone,cover,passport,cv) values(?,?,?,?,?,?,?)");			  
			 $stmt->bind_param("sssssss",$surname,$firstname,$email,$phone,$cover,$passportName,$resumeName);
			 $stmt->execute();
			 $userAuthID = $stmt->insert_id;

            
            ///////////////////////    check   ////////////////////////////////////////////////////////////////
			 if($stmt->insert_id <=0 ||  error_get_last() != NULL){
					$err = "sql error : ".$con->error.", php error : ".json_encode(error_get_last());
					 $mainResult = array('success' =>$err);
                     echo json_encode($mainResult);
			 	    $con->rollback();
			 }else{
			 	    

				 	// $_SESSION['uname'] = $username;
				 	// $_SESSION['pwd'] = $password;
				 	// $_SESSION['user_id'] = $userAuthID;

                    $mainResult = array('success' =>1);
                    echo json_encode($mainResult);
			
				 	$con->commit();
			 }
			 $stmt->close();
			 
			
   }else{
   	          $mainResult = array('success' =>2);
              echo json_encode($mainResult);
   			// echo "some information submitted already exist";
   }

     

?>