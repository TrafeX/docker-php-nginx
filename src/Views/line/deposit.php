<!DOCTYPE html>
<html lang="en">
    <?php $version="8";?>
    <head>
        <link rel="icon" type="image/x-icon" href="<?php echo base_url("public/favicon.ico"); ?>">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>ฝากเงิน</title>

       <!-- Or for RTL support -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

        <!-- Custom fonts for this template-->
        <link href="<?php echo base_url("public/bootstrap-admin/vendor/fontawesome-free/css/all.min.css"); ?>" rel="stylesheet" type="text/css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kanit&display=swap" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="<?php echo base_url("public/bootstrap-admin/css/sb-admin-2.min.css"); ?>" rel="stylesheet">

        <!-- Custom styles for this page -->
        <link href="<?php echo base_url("public/bootstrap-admin/vendor/datatables/dataTables.bootstrap4.min.css"); ?>" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="<?php echo base_url("public/jquery-file-upload/upload.css"); ?>">
         <!-- Styles -->
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJ4n1KerL8Qn0aNv3YvqTmaubgqVd_kps&callback=Function.prototype&libraries=&v=weekly"></script>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo base_url("public/custom/app.css"); ?>">
        <style>
            .required-field::before {
            content: "*";
            color: red;
            }
        </style>
    </head>
    <body id="page-top">
    <input type="hidden" name="base_url" id="base_url" value="<?=base_url()?>" />
    <!-- Page Wrapper -->
    <div class="container">

        <div class="row" style="display:none;" id="frm-register">
            <div class="col-12 mb-2 mt-5 text-center">
                 <h3>แนปสลิป</h3>
            </div>
            <div class="col-12 mb-2">
                 <div class="form-group">
                    <label for="name">เลขที่พอร์ต<span class="required-field"></span></label>
                    <input type="text" class="form-control" id="port" placeholder="เลขที่พอร์ต">
                    <small id="port-validate" class="form-text text-danger "></small>
                </div>
            </div>
           
            <div class="col-12 mb-2 text-center">
              
                 <button type="button" class="btn btn-primary" onclick="submitData();">ตกลง</button>
            </div>
        </div>

        <div class="row" style="display:none;" id="frm-detail">
            <div class="col-12 mb-2 mt-5 text-center">
                <h3>ท่านได้แนปสลิปเรียบร้อยแล้ว</h3>
            </div>
        </div>
    </div>
    <!-- End of Page Wrapper -->
    <div class="overlay" id="loading" style="display:none;">
        <div class="overlay__inner">
            <div class="overlay__content"><span class="spinner"></span></div>
        </div>
    </div>
   
    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url("public/bootstrap-admin/vendor/jquery/jquery.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/jquery-file-upload/upload.js"); ?>"></script>
    <script src="<?php echo base_url("public/bootstrap-admin/vendor/bootstrap/js/bootstrap.bundle.min.js"); ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url("public/bootstrap-admin/vendor/jquery-easing/jquery.easing.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/bootstrap-admin/js/sb-admin-2.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/bootstrap-admin/vendor/datatables/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url("public/bootstrap-admin/vendor/datatables/dataTables.bootstrap4.min.js"); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Custom -->
    <script src="<?php echo base_url("public/custom/validate.js?".$version); ?>"></script>
    <script src="<?php echo base_url("public/custom/init.datatable.js?".$version); ?>"></script>
    <script src="<?php echo base_url("public/custom/app.js?".$version); ?>"></script>
    <!-- Line LIFF -->
    <script charset="utf-8" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
    <script>
        var userProfile = "";
        $("#loading").show();
        document.addEventListener("DOMContentLoaded", function() {
            liff.init({ liffId: '2007230457-jPVJnZwg', withLoginOnExternalBrowser:true }).then(() => {
                liff.getProfile().then(profile => {
                userProfile = profile.userId;
                const displayName = profile.displayName;
                const statusMessage = profile.statusMessage;
                const pictureUrl = profile.pictureUrl;
                const urls = new URLSearchParams(window.location.search);
             
                document.getElementById('port-detail').value='';
             
                document.getElementById('port-validate').innerHTML="";

                document.getElementById('port').classList.remove("is-invalid");
                if(userProfile != ""){

                }
                // if(userProfile != ""){
                //     $.post("https://backend-api-chat.aslsecurities.com/lineconnect/apply/check/seminar/register",{userProfile: userProfile, seminar_id:urls.get('param')},
                //     function(data, status){
                //         if(data.data){
                //             document.getElementById('frm-register').style.display='none';
                //             document.getElementById('frm-detail').style.display='';
                //         }else{
                //             document.getElementById('frm-register').style.display='';
                //             document.getElementById('frm-detail').style.display='none';
                //         }
                        
                //         $("#loading").hide();
                //     });
                // }else{
                //     document.getElementById('frm-register').style.display='';
                //     document.getElementById('frm-detail').style.display='none';
                //     $("#loading").hide();
                // }
              
            }).catch((error) => {
                document.getElementById('frm-register').style.display='';
                document.getElementById('frm-detail').style.display='none';
                $("#loading").hide();
        });
        })
        .catch((error) => {
            document.getElementById('frm-register').style.display='';
            document.getElementById('frm-detail').style.display='none';
            $("#loading").hide();
        })
    });


    function submitData(){
        let validate = true;
        if(document.getElementById('port').value==""){
            validate = false;
            document.getElementById('port-validate').innerHTML="กรอก เลขที่พอร์ต";
            document.getElementById('port').classList.add("is-invalid");
        }else{
            document.getElementById('port-validate').innerHTML="";
            document.getElementById('port').classList.remove("is-invalid");
        }

        if(validate)
        {
            $("#loading").show();
            var formdata = new FormData();
            if($(this).prop('files').length > 0)
            {
                file =$(this).prop('files')[0];
                formdata.append("slip", file);
            }
            formdata.append("userProfile", userProfile);
            $.ajax({
                url: "https://backend-api-chat.aslsecurities.com/lineconnect/apply/uploadSlip",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(data)
                {
                    if(data=='invalid')
                    {
                        // show error message.
                        $("#err").html("Invalid File !").fadeIn();
                    }
                    else
                    {
                        // view uploaded file.
                        $("#preview").html(data).fadeIn();
                        $("#form")[0].reset(); 
                    }
                    $("#loading").hide();
                    document.getElementById('frm-register').style.display='none';
                    document.getElementById('frm-detail').style.display='';
                    document.getElementById('port').value='';
                },
                error: function(e) 
                {
                    $("#loading").hide();
                    console.log(e);
                }
            });
        }
    }
    </script>
    
</body>

</html>