<?php 
session_start();
    include_once("settings/connect.php");
    require_once("settings/config.php");
    // include_once("auth/session_others.php");
// include_once("../../settings/user_info.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edges">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#690005">
    <link rel="stylesheet" type="text/css" href="/style/fonts.css">
    
    <link rel="stylesheet" type="text/css" href="/style/drawer.css">
    <link rel="stylesheet" type="text/css" href="/style/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/style/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="/style/main.css">
    <link rel="stylesheet" type="text/css" href="/style/responsive.css">
    <title>cscc</title>

</head>
<body style="background:-webkit-linear-gradient(top,#600086,#6E0057)">
    
    
    <!--//////////////////////////////////////////////////-->
    <!--////////////   Header and Navbar  START    /////////////////-->
    <!--//////////////////////////////////////////////////-->
    
             <?php  include "include/global/header.php"; ?>
    
    <!--//////////////////////////////////////////////////-->
    <!--////////////    Navbar  END    ///////////////////-->
    <!--//////////////////////////////////////////////////-->
    
    
    <main class="container-fluid" style="height:600px;">
      <section class="row" style="padding-top:20px;">
        
       <div class="col-md-6">
        <div style="padding:100px;background:#fff;">
          <form action="#" id="register" enctype="multipart/form-data">
          <div class="row field-cont">
              <label class="">Firstname:<span class="tip">Good title makes it easier for people to locate your track faster</span></label><br>
              <input id="new-upload-title" class="form-control" type="text" name="fname" placeholder="Firstname">
          </div>
          <div class="row field-cont">
              <label class="">Surname:<span class="tip">Good title makes it easier for people to locate your track faster</span></label><br>
              <input id="new-upload-title" class="form-control" type="text" name="surname" placeholder="Surname">
          </div>
          <div class="row field-cont">
              <label class="">Phone No:<span class="tip">Good title makes it easier for people to locate your track faster</span></label><br>
              <input id="new-upload-title" class="form-control" type="text" name="phone" placeholder="Phone No">
          </div>
          <div class="row field-cont">
              <label class="">Email:<span class="tip">Good title makes it easier for people to locate your track faster</span></label><br>
              <input id="new-upload-title" class="form-control" type="text" name="email" placeholder="Email">
          </div>
          <div class="row field-cont">
              <label class="">Cover Letter:<span class="tip">Make your description clear and informative </span></label>
              <textarea id="new-upload-desc" class="form-control" name="cover" placeholder="Cover Letter"></textarea>
          </div>
           <div class="row field-cont">
            <label class="">Passport:<span class="tip">Make your description clear and informative </span></label>
            <input type="file" name="passport">
              <!-- <div class="form-control dropzone" id="upload_dz_passport"> </div> -->
          </div>
          <div class="row field-cont">
            <label class="">Resume:<span class="tip">Make your description clear and informative </span></label>
              <input type="file" name="resume">
          </div>
          <button type="submit" class="btn btn-default">Submit</button>
          </form>
        </div>

       </div>


      </section>     
    </main>
    <!-- <footer></footer> -->

   <script type="text/javascript" src="/scripts/jquery/jquery.min.js"></script>
   <script type="text/javascript" src="/style/bootstrap/js/bootstrap.min.js"></script>
   <script type="text/javascript" src="/scripts/sticky-kit/dist/sticky-kit.min.js"></script>
   <script type="text/javascript" src="/scripts/form-to-json/form-to-json.js"></script>
   <script type="text/javascript" src="/scripts/bootstrap-notify/bootstrap-notify.min.js"></script>
   <script type="text/javascript">
 $(document).ready(function(){



           $('[data-toggle="tooltip"]').tooltip();
           $('.sticky').stick_in_parent({offset_top:-90});
           $('.sticky2').stick_in_parent({offset_top:38});



		$('form').on('submit',function(e){
		                e.preventDefault();
		        var formData = new FormData($(this)[0]);

		            var _this = $(this);
		            window.allFields = JSON.parse(formToJson(this)) ;
		            var error = [];
		            var requiredFields = ['surname','fname','phone'];
		                 for(var a in requiredFields){
		                    var field = requiredFields[a];
		                    if(typeof allFields[field] =='undefined'){
		                        $.notify({ message:`${field} field is required` },{ type:'danger',z_index:10000})
		                        return false;

		                     }
		                 }

		                 formData.append('others',allFields);
		                  // allFields.author = $('.token-author').val();
                       $.ajax({
                                url:'/cpu/registration.php',
                                data:formData,
                                type:'POST',
                                dataType:'json',
                                processData:false,
                                contentType:false,
                                success:function(data, status){
                                  if(data.success==1){
                                      
                                      $.notify({ title:'<span>Success</span>:',message:'You have registered successfully...',icon:'fa fa-check-circle' },{ 
                                               type:'success',delay:2000,onClose:function(){ 
                                                
                                               }})
                                    }else if(data.success==7){
                                      $.notify({ title:'<span>Error</span>:',message:'Passport size Exceeded',icon:'fa fa-' },{ 
                                               type:'danger',delay:2000,onClose:function(){ 
                                                
                                               }})
                                    }else if(data.success==8){
                                      $.notify({ title:'<span>Error</span>:',message:'Resume size Exceeded',icon:'fa fa-' },{ 
                                               type:'danger',delay:2000,onClose:function(){ 
                                                
                                               }})
                                    }else if(data.success==13){
                                      $.notify({ title:'<span>Application Closed!</span>:',message:'You can no longer register.',icon:'fa fa-' },{ 
                                               type:'warning',delay:2000,onClose:function(){ 
                                                
                                               }})
                                    }
                                  }
                     })
		 })
 
        


}) //Document.Ready Function
   </script>
</body>
</html>