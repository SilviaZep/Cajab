<div class="section group">
    <div class="col span_1_of_2">
        <div align="center" style="padding:30px;"> <img src="images/logo-principal.png" width="230" alt=""/> </div> 

        <h2 class="titulosuperior">
            <p>   THANK YOU FOR DOING <br/>
                BUSINESS WITH US.</p>
        </h2>

        <p class="descriptivo">
            McKesson/MedTrainer Sales Account Manager Page
        </p>   

        <p class="contenidomayuscula3">
            What do you want to do?
        </p>
        <div style="padding:50px 0 0 0p;" align="center">  <a href="#" class="Open-modal dwnld" id="openBtn6" >  <img src="mrepsvideo.svg" alt="" width="230"/>  </a> </div>

        <div id="accordion">

            <a id="link1" href="#" style="text-decoration:none; color: #ffffff;"><h4 class="titulodesplegable">Submit Your Lead  <div style="float:right;"> </h4> </a>
            <div id="leadd">



                <div class="contenidointerno"> 
                    <form method="post" name="myForm" id="register-form">

                        <label class="hdng">Enter interested client information here</label>

                        <div class="form-group">
                            <input type="text" class="form-control ur-name" placeholder="First Name" name="first_name" id="first_name" required>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control ur-name" placeholder="Last Name" name="last_name" id="last_name" required>
                        </div>

                        <div class="form-group">
                            <input type="email" class="form-control email-add" placeholder="Email Address" name="email" id="email">    
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control cmpny-name" placeholder="Company Name" name="company_name" id="company_name" required>
                        </div>

                        <div class="form-group">
                            <select class="form-control cmpny-name" placeholder="" name="industry" id="industry" required>
                                <option value="">Practice Type</option>
                                <option value="Cardiology">Cardiology</option>
                                <option value="Community Health Center">Community Health Center</option>
                                <option value="Dental">Dental</option>
                                <option value="Dermatology">Dermatology</option>
                                <option value="Healthcare">Healthcare</option>
                                <option value="Hospice">Hospice</option>
                                <option value="Hospital">Hospital</option>
                                <option value="Laboratory">Laboratory</option>
                                <option value="Nursing Home">Nursing Home</option>
                                <option value="Oncology">Oncology</option>
                                <option value="Orthopaedic">Orthopaedic</option>
                                <option value="Pharmacy">Pharmacy</option>
                                <option value="Primary Care">Primary Care</option>
                                <option value="Radiology">Radiology</option>
                                <option value="Surgery Center">Surgery Center</option>
                                <option value="Urgent Care">Urgent Care</option>
                                <option value="Veterinary">Veterinary</option>
                                <option value="Wound Care">Wound Care</option>
                                <option value="Opthalmology">Opthalmology</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control phn-number" placeholder="Phone Number" name="phone" id="phone">
                        </div>

                        <div class="form-group" >
                            <input type="text" class="form-control nos-users" placeholder="Number of Users (optional)" name="no_employees" id="no_employees">
                        </div>

                        <div class="form-group" >
                            <input type="text" class="form-control quote" placeholder="Quoted Price (optional)" name="mck_quoted_price" id="mck_quoted_price">
                        </div>

                        <div class="form-group" >
                            <textarea class="form-control" rows="3" placeholder="Additional comments- Please put demo date and time in this field if you have scheduled it" name="additional_comments"></textarea>
                        </div>

                        <label class="hdng">McKesson Account Manager Information</label>

                        <div class="form-group">
                            <select class="form-control ur-name" placeholder="Your First Name And Last Name" name="mck_name" id="mck_name" required>

                            </select>
                        </div>

                        <div class="form-group other_mck_name" style="display:none;">
                            <input type="email" class="form-control ur-name" placeholder="Sales Rep Full Name" name="mck_sr_other_name" id="mck_sr_other_name">
                        </div>

                        <div class="form-group other_mck_name" style="display:none;">
                            <input type="email" class="form-control email-add" placeholder="Sales Rep Full Email" name="mck_sr_other_email" id="mck_sr_other_email">
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control mck-eid" placeholder="McKesson Ship To Account Number (optional)" name="mck_ship_to_acct" id="mck_ship_to_acct">
                        </div>
                        <div class="form-group">
                            <label class="hdng">Select one of the options below: </label>
                            <div class="checkbox" style="position: static;">
                                <label>
                                    <input   type="radio" name="mck_check_contact" id="optionsRadios1" style="width:30px;" value="Contact Client"  checked> I have discussed the product with the client and a MedTrainer representative can reach out to client directly 
                                </label>
                            </div>

                            <div class="checkbox" style="position: static;">
                                <label>
                                    <input type="radio" name="mck_check_contact" id="optionsRadios2" style="width:30px;" value="Contact Rep"> Please contact the sales rep (myself) regarding this lead
                                </label>
                            </div>
                        </div>

                        <div id="error_display_msg" class="alert alert-danger" role="alert" style="display:none;">
                            <p id="e_display_msg_p"></p>
                        </div>
                        <div id="success_display_msg" class="alert alert-danger" role="alert" style="display:none;">
                            <p id="s_display_msg_p"></p>
                        </div>

                        <div align="center" class="text-center">
                            <button type="submit" class="btn btn-default submit-btn" id="btn-lead">Submit Lead</button> <!-- span class="or">or</span>
                            <button type="submit" class="btn btn-default sgnup-btn" id="btn-account">Sign Up Account</button -->
                            <span class="ir-arriba fa fa-arrow-up"></span>
                        </div>

                        <!--div class="note">
                        <p>*Is your client ready to sign up now? If so use the sign up button and we will prioritize this lead</p>
                        </div-->
                    </form>
                    <div class="col-md-12 text-right">
                        <a  href = "javascript:colMenu('leadd','link1')" style="color:#ffffff"><i class="fa fa-arrow-up fa-2x" aria-hidden="false"></i></a>
                    </div>

                </div> 
            </div>

            <a id="useful" style="text-decoration:none; color: #ffffff;"><h4 class="titulodesplegable">Send Materials to Customers</h4></a>

            <div id="usefulMaterials">

                <div class="contenidointerno">

                    <p class="contenidomayuscula">Check the box next to the material(s) you would like to send to your customer, select your name from the drop-down menu, and enter the customer’s email address at the bottom. Click "Send Info" to have the material(s) sent to the customer.</p>

                    <div class="elementosdescarga">
                        <form method="post" name="myFormMail" id="mail-form"> 

                            <div style="width:30px; " class="checkbox">
                                <input   id="check_sales_sheet" name="check_sales_sheet" type="checkbox" value="1">
                                <label class="chkbx" for="check_sales_sheet"> </label>
                            </div>


<!-- <span class="glyphicon glyphicon-envelope msg-icon" aria-hidden="true"></span>-->

                            <div class="content">
                                <h3 class="contenidomayuscula2">MedTrainer Sales Sheet</h3>
                                <p>Explains the MedTrainer program and  gives general overview of features</p>

                            </div>

                            <div style="padding: 18px">
                                <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                    <a id="down-sheet" href="http://lms-qa.medtrainer.com/resources/MT_General_Sales_Sheet.pdf" target="_blank" class="dwnld" > 
                                     <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                                </div> <!--termina este es botton naranja de descarga-->
                            </div>
                    </div>


                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div style="width:30px; " class="checkbox">
                            <input id="check_course_list" name="check_course_list" type="checkbox" value="1">
                            <label class="chkbx" for="check_course_list"> </label>
                        </div>


<!-- <span class="glyphicon glyphicon-envelope msg-icon"aria-hidden="true" ></span>
<span class="glyphicon glyphicon-play-circle list-icon" aria-hidden="true"></span>-->


                        <div  class="content">
                            <h3 class="contenidomayuscula2">Course List</h3>
                            <p>Up to date listing of courses including in the<br /> MedTrainer system</p>

                        </div>

                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="down-sheet" href="http://lms-qa.medtrainer.com/resources/MedTrainer_Course_List.pdf" target="_blank" class="dwnld" > 
                                 <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton">Download</p><p><!--<i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i>--></p></a>

                            </div> <!--termina este es botton naranja de descarga-->
                        </div>
                    </div> <!--fin elemento de descarga-->















                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div style="width:30px; " class="checkbox">
                            <input id="check_whiteboard" name="check_whiteboard" type="checkbox" value="1">
                            <label class="chkbx" for="check_whiteboard"> </label>

                        </div>


<!--<span class="glyphicon glyphicon-envelope msg-icon" aria-hidden="true"></span>
<span class="glyphicon glyphicon-play-circle list-icon" aria-hidden="true"></span>-->


                        <div  class="content">
                            <h3 class="contenidomayuscula2">Explainer Video</h3>
                            <p>This is a link to the explainer video which gives a visual overview of MedTrainer</p>

                        </div>

                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a href="#" class="Open-modal dwnld" id="openBtn" > 
                                 <img style="padding-top: 2px;" class="flotador" src="images/preview-video.png"/><p class="flotadorboton" style="margin-left: 34px;" >Preview</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                            </div> <!--termina este es botton naranja de descarga-->
                        </div>
                    </div> <!--fin elemento de descarga-->


                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div style="width:30px;" class="checkbox">
                            <input id="check_faq" name="check_faq" type="checkbox" value="1">
                            <label class="chkbx" for="check_faq"> </label>
                        </div>

<!-- <span class="glyphicon glyphicon-envelope msg-icon" aria-hidden="true"></span>-->



                        <div  class="content">
                            <h3 class="contenidomayuscula2">Frequently Asked Questions (FAQ)</h3>
                            <p>Frequently asked questions and answers about the MedTrainer system</p>

                        </div>

                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="down-faq" href="http://lms-qa.medtrainer.com/resources/MedTrainer_FAQs.pdf" target="_blank" class="dwnld" > 
                                 <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                            </div> <!--termina este es botton naranja de descarga-->
                        </div>
                    </div> <!--fin elemento de descarga-->
                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div style="width:30px; " class="checkbox">
                            <input id="check_tutorials" name="check_tutorials" type="checkbox" value="1">
                            <label class="chkbx" for="check_tutorials"> </label>
                        </div>


<!-- <span class="glyphicon glyphicon-envelope msg-icon"aria-hidden="true" ></span>
<span class="glyphicon glyphicon-play-circle list-icon" aria-hidden="true"></span>-->


                        <div  class="content">
                            <h3 class="contenidomayuscula2">Tutorials and Support Information</h3>
                            <p>Will send a link to our support page for client support</p>

                        </div>
                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="down-tutorials" href="http://medtrainer.com/support/video-tutorials/" target="_blank" class="dwnld" > 
                                 <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>    
                            </div> <!--termina este es botton naranja de descarga-->
                        </div>
                    </div> <!--fin elemento de descarga-->


                    <div class="form-group">
                        <select class="form-control ur-name" placeholder="Your First Name And Last Name" name="mrep" id="mrep" required>
                        </select>
                    </div>




                    <div class="form-group">
                        <input name="res_email" id="res_email" type="email" class="form-control enter-email " placeholder="Enter Customer Email Address">
                        <div align="center"> <input  type="button" id="btn-send-info" class="btn btn-default send-info sendinfo" style="font-family: AvenirNextLTPro-Regular;
                                                     padding: 0.9em; width: 26%;"  value="SEND INFO"></div> </div>
                    <div class="clearfix"></div>

                    </form>


                    <div id="mail_error_display_msg" class="alert alert-danger" role="alert" style="display:none;">
                        <p id="mail_e_display_msg_p"></p>
                    </div>
                    <div id="mail_success_display_msg" class="alert alert-success" role="alert" style="display:none;">
                        <p id="mail_s_display_msg_p">Success! The resources have been sent</p>
                    </div>


                    <div class="col-md-12 text-right">
                        <a  href = "javascript:colMenu('usefulMaterials','useful')" style="color:#ffffff"><i class="fa fa-arrow-up fa-2x" aria-hidden="false"></i></a>
                    </div>




                </div>

            </div>


            <a id="mtTitle" style="text-decoration:none; color: #ffffff;"><h4 class="titulodesplegable">MedTrainer Segment Sales Sheets</h4></a>

            <div id="mtContent">

                <div class="contenidointerno">

                    <p class="contenidomayuscula">Check the box next to the sales sheet(s) you would like to send to your customer, select your name from the drop-down menu, and enter the customer’s email address at the bottom. Click "Send Info" to have the sales sheet(s) sent to the customer.</p>

                    <div class="elementosdescarga">

                        <form method="post" name="myFormMailBranded" id="mail-form">      
                            <div style="width:30px; " class="checkbox">
                                <input   id="check_asc_med" name="check_asc_med" type="checkbox" value="1">
                                <label class="chkbx" for="check_asc_med"> </label>
                            </div>


<!-- <span class="glyphicon glyphicon-envelope msg-icon" aria-hidden="true"></span>-->

                            <div class="content">
                                <h3 class="contenidomayuscula2">Ambulatory Surgery Centers (ASCs) MedTrainer</h3>

                            </div>

                            <div style="padding: 18px">
                                <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                    <a id="down-sheet" href="http://lms-qa.medtrainer.com/resources/MT_REGTRAIN_SURG.pdf" target="_blank" class="dwnld" > 
                                     <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                                </div> <!--termina este es botton naranja de descarga-->
                            </div>
                    </div>


                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div style="width:30px; " class="checkbox">
                            <input id="check_asc_med1" name="check_asc_med1" type="checkbox" value="1">
                            <label class="chkbx" for="check_asc_med1"> </label>
                        </div>


<!-- <span class="glyphicon glyphicon-envelope msg-icon"aria-hidden="true" ></span>
<span class="glyphicon glyphicon-play-circle list-icon" aria-hidden="true"></span>-->


                        <div  class="content">
                            <h3 class="contenidomayuscula2">Ambulatory Surgery Centers (ASCs) McKesson</h3>

                        </div>

                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="down-sheet" href="http://lms-qa.medtrainer.com/resources/McK_REGTRAIN_SURG.pdf" target="_blank" class="dwnld" > 
                                 <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton">Download</p><p><!--<i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i>--></p></a>

                            </div> <!--termina este es botton naranja de descarga-->
                        </div>
                    </div> <!--fin elemento de descarga-->


                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div style="width:30px; " class="checkbox">
                            <input id="check_chc_sheet" name="check_chc_sheet" type="checkbox" value="1">
                            <label class="chkbx" for="check_chc_sheet"> </label>

                        </div>


<!--<span class="glyphicon glyphicon-envelope msg-icon" aria-hidden="true"></span>
<span class="glyphicon glyphicon-play-circle list-icon" aria-hidden="true"></span>-->


                        <div  class="content">
                            <h3 class="contenidomayuscula2">Community Health Centers MedTrainer</h3>

                        </div>

                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="down-sheet" href="http://lms-qa.medtrainer.com/resources/MT_REGTRAIN_CHC.pdf" target="_blank" class="dwnld" >
                                  <img style="padding-top: 2px;" class="flotador" src="images/ico-descarga.png"/><p class="flotadorboton" style="margin-left: 34px;" >Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                            </div> <!--termina este es botton naranja de descarga-->
                        </div>
                    </div> <!--fin elemento de descarga-->


                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div style="width:30px;" class="checkbox">
                            <input id="check_chc_sheet1" name="check_chc_sheet1" type="checkbox" value="1">
                            <label class="chkbx" for="check_chc_sheet1"> </label>
                        </div>

<!-- <span class="glyphicon glyphicon-envelope msg-icon" aria-hidden="true"></span>-->



                        <div  class="content">
                            <h3 class="contenidomayuscula2">Community Health Centers McKesson</h3>    
                        </div>

                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="down-faq" href="http://lms-qa.medtrainer.com/resources/McK_REGTRAIN_CHC.pdf" target="_blank" class="dwnld" > 
                                 <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                            </div> <!--termina este es botton naranja de descarga-->
                        </div>
                    </div> <!--fin elemento de descarga-->

                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div style="width:30px;" class="checkbox">
                            <input id="check_ucc_sheet" name="check_ucc_sheet" type="checkbox" value="1">
                            <label class="chkbx" for="check_ucc_sheet"> </label>
                        </div>

<!-- <span class="glyphicon glyphicon-envelope msg-icon" aria-hidden="true"></span>-->



                        <div  class="content">
                            <h3 class="contenidomayuscula2">Urgent Care Centers MedTrainer</h3>    
                        </div>

                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="down-faq" href="http://lms-qa.medtrainer.com/resources/MT_REGTRAIN_URG.pdf" target="_blank" class="dwnld" > 
                                 <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                            </div> <!--termina este es botton naranja de descarga-->
                        </div>
                    </div> <!--fin elemento de descarga-->

                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div style="width:30px;" class="checkbox">
                            <input id="check_ucc_sheet1" name="check_ucc_sheet1" type="checkbox" value="1">
                            <label class="chkbx" for="check_ucc_sheet1"> </label>
                        </div>

<!-- <span class="glyphicon glyphicon-envelope msg-icon" aria-hidden="true"></span>-->



                        <div  class="content">
                            <h3 class="contenidomayuscula2">Urgent Care Centers McKesson</h3>    
                        </div>

                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="down-faq" href="http://lms-qa.medtrainer.com/resources/McK_REGTRAIN_URG.pdf" target="_blank" class="dwnld" > 
                                 <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                            </div> <!--termina este es botton naranja de descarga-->
                        </div>
                    </div> <!--fin elemento de descarga-->

                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div style="width:30px;" class="checkbox">
                            <input id="check_po_sheet" name="check_po_sheet" type="checkbox" value="1">
                            <label class="chkbx" for="check_po_sheet"> </label>
                        </div>

<!-- <span class="glyphicon glyphicon-envelope msg-icon" aria-hidden="true"></span>-->


                        <div  class="content">
                            <h3 class="contenidomayuscula2">Physicians Offices MedTrainer</h3>    
                        </div>


                        <div class="botondescarga"> <!--este es botton naranja de descarga-->
                            <a id="down-faq" href="http://lms-qa.medtrainer.com/resources/MT_SIMPLIFY.pdf" target="_blank" class="dwnld" > 
                             <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                        </div> <!--termina este es botton naranja de descarga-->

                    </div> <!--fin elemento de descarga-->

                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div style="width:30px;" class="checkbox">
                            <input id="check_po_sheet1" name="check_po_sheet1" type="checkbox" value="1">
                            <label class="chkbx" for="check_po_sheet1"> </label>
                        </div>

<!-- <span class="glyphicon glyphicon-envelope msg-icon" aria-hidden="true"></span>-->



                        <div  class="content">
                            <h3 class="contenidomayuscula2">Physicians Offices McKesson</h3>    
                        </div>


                        <div class="botondescarga"> <!--este es botton naranja de descarga-->
                            <a id="down-faq" href="http://lms-qa.medtrainer.com/resources/McK_SIMPLIFY.pdf" target="_blank" class="dwnld" > 
                             <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                        </div> <!--termina este es botton naranja de descarga-->

                    </div> <!--fin elemento de descarga-->

                    <div class="form-group">
                        <select class="form-control ur-name" placeholder="Your First Name And Last Name" name="mrep1" id="mrep1" required>
                        </select>
                    </div>




                    <div class="form-group">
                        <input name="res_email1" id="res_email1" type="email" class="form-control enter-email " placeholder="Enter Customer Email Address">
                        <div align="center"> <input  type="button" id="btn-send-info-branded" class="btn btn-default send-info sendinfo" style="
                                                     font-family: AvenirNextLTPro-Regular;
                                                     padding: 0.9em;
                                                     width: 26%;"  value="SEND INFO"></div>
                    </div>
                    <div class="clearfix"></div>    
                    </form>


                    <div id="mail_error_display_msg1" class="alert alert-danger" role="alert" style="display:none;">
                        <p id="mail_e_display_msg_p1"></p>
                    </div>
                    <div id="mail_success_display_msg1" class="alert alert-success" role="alert" style="display:none;">
                        <p id="mail_s_display_msg_p1">Success! The resources have been sent</p>
                    </div>

                    <div class="col-md-12 text-right">
                        <a  href = "javascript:colMenu('mtContent','mtTitle')" style="color:#ffffff"><i class="fa fa-arrow-up fa-2x" aria-hidden="false"></i></a>
                    </div>





                </div>

            </div>


            <a style="text-decoration:none; color: #ffffff;" id="mkTitle"><h4 class="titulodesplegable">Mckesson Account Manager Center </h4></a>


            <div id="mkContent">



                <div class="contenidointerno">

                    <p class="contenidomayuscula">Internal documents for McKesson Employees Only
                    </p>

                    <div class="elementosdescarga"> <!--elemento de descarga -->

                        <div  class="content">
                            <h3 class="contenidomayuscula2">Medtrainer - McKesson Introduction Video</h3>


                        </div>

                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a href="#" class="Open-modal dwnld" id="openBtn5"> 
                                  <img style="padding-top: 3px;" class="flotador" src="images/movie.png"  /><p class="flotadorboton" style="margin-top: -13px;">Watch now</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                            </div> <!--termina este es botton naranja de descarga-->

                        </div>

                    </div> <!--fin elemento de descarga-->
                    <div class="elementosdescarga"> <!--elemento de descarga -->

                        <div  class="content">
                            <h3 class="contenidomayuscula2">Medtrainer - McKesson Training Video</h3>


                        </div>

                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a href="#" class="Open-modal dwnld" id="openBtn7"> 
                                  <img style="padding-top: 3px;" class="flotador" src="images/movie.png"  /><p class="flotadorboton" style="margin-top: -13px;">Watch now</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>    
                            </div> <!--termina este es botton naranja de descarga-->
                        </div>

                    </div> <!--fin elemento de descarga-->

                    <div class="elementosdescarga"> <!--elemento de descarga -->

                        <div  class="content">
                            <h3 class="contenidomayuscula2">Account Manager Cheat Sheet (Co-branded)</h3>


                        </div>



                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="cheat-sheet" href="http://lms-qa.medtrainer.com/resources/Account_Manage_Cheat.pdf" target="_blank" > 
                                 <img class="flotador" src="images/ico-descarga.png" width="22"  /><p class="flotadorboton" style="margin-top: -17px;">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                            </div> <!--termina este es botton naranja de descarga-->

                        </div>




                    </div> <!--fin elemento de descarga-->



                    <div class="elementosdescarga"> <!--elemento de descarga -->



                        <div  class="content">
                            <h3 class="contenidomayuscula2">Account Manager System Tour</h3>


                        </div>



                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a href="#" class="Open-modal dwnld" id="openBtn1" > 
                                 <img style="padding-top: 3px;" class="flotador" src="images/movie.png"  /><p class="flotadorboton" style="margin-top: -13px;">Watch now</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>-->
                                </a>    
                            </div> <!--termina este es botton naranja de descarga-->

                        </div>








                    </div> <!--fin elemento de descarga-->

                    <div class="elementosdescarga"> <!--elemento de descarga -->



                        <div  class="content">
                            <h3 class="contenidomayuscula2">Use the Mreps page and Lead Submission</h3>


                        </div>



                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a href="#" class="Open-modal dwnld" id="openBtn2"> 
                                  <img style="padding-top: 3px;" class="flotador" src="images/movie.png"  /><p class="flotadorboton" style="margin-top: -13px;">Watch now</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                            </div> <!--termina este es botton naranja de descarga-->

                        </div>










                    </div> <!--fin elemento de descarga-->

                    <div class="elementosdescarga"> <!--elemento de descarga -->



                        <div  class="content">
                            <h3 class="contenidomayuscula2">ASC Training and Compliance Offering</h3>


                        </div>



                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="asc-training" href="http://lms-qa.medtrainer.com/resources/ASC_Training_and_Compliance Offering.pdf" target="_blank"> 
                                 <img style="padding-top: 2px;" class="flotador" src="images/ico-descarga.png" width="22" /><p class="flotadorboton" style="margin-top: -19px;">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                            </div> <!--termina este es botton naranja de descarga-->

                        </div>


                    </div> <!--fin elemento de descarga-->

                    <div class="elementosdescarga"> <!--elemento de descarga -->


                        <div  class="content">
                            <h3 class="contenidomayuscula2">Probing Questions and Rebuttals</h3>


                        </div>



                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="probing-que" href="http://lms-qa.medtrainer.com/resources/Probing_Questions_and_Rebuttals.pptx" target="_blank"> 
                                 <img class="flotador" src="images/ico-descarga.png" width="22"   /><p class="flotadorboton">Download</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>

                            </div> <!--termina este es botton naranja de descarga-->
                        </div>





                    </div> <!--fin elemento de descarga-->

                    <div class="elementosdescarga"> <!--elemento de descarga -->



                        <div  class="content">
                            <h3 class="contenidomayuscula2">Upload Customer SDS</h3>


                        </div>



                        <div style="padding: 18px">
                            <div class="botondescarga"> <!--este es botton naranja de descarga-->
                                <a id="btn-upload-Files" target="_blank" href=" http://mreps.medtrainer.com/setup/uploadFiles"> 
                                 <img class="flotador" src="images/uo-load.png" width="22"  /><p class="flotadorboton" style="margin-top: 3px; margin-left: 10px;">Upload</p><!--<p><i class="glyphicon glyphicon-eye-open eye-icon" aria-hidden="true"></i></p>--></a>    
                            </div> <!--termina este es botton naranja de descarga-->   

                        </div>




                    </div> <!--fin elemento de descarga-->
                    <div class="col-md-12 text-right">
                        <a  href = "javascript:colMenu('mkContent','mkTitle')" style="color:#ffffff"><i class="fa fa-arrow-up fa-2x" aria-hidden="false"></i></a>
                    </div>
                </div>

            </div>

        </div>


        <div>

            <!--<a href="http://www.google.com" target="_blank"> -->  <div align="center" class="primerboton propiedadboton">
                <img style="padding-bottom: 1px;" src="images/primer-boton.png" width="26" alt=""/> <br/>TRAINING </div>  <!--</a>-->


            <!--<a href="http://www.google.com" target="_blank">--> <div align="center" class="segundoboton propiedadboton">
                <img style="padding-bottom: 1px;" src="images/segundo-boton.png"  width="28" alt=""/><br/>
                MANAGE

            </div>   <!--</a>-->

            <!-- <a href="http://www.google.com" target="_blank"> --><div align="center" class="tercerboton propiedadboton">
                <img style="padding-bottom: 2px;" src="images/tercer-boton.png" width="18" alt=""/><br/>
                SAFETY

            </div>    <!--</a>-->

            <!--<a href="http://www.google.com" target="_blank">-->  <div align="center" class="cuartoboton propiedadboton">
                <img style="padding-bottom: 2px;" src="images/cuarto-boton.png" width="23" alt=""/><br/>
                SDS

            </div>   <!--</a>-->

            <!--<a href="http://www.google.com" target="_blank"> --> <div align="center" class="quintoboton propiedadboton">
                <img style="padding-bottom: 5px;" src="images/quinto-boton.png" width="29" alt=""/><br/>
                COMPLIANCE
            </div>  <!--</a>-->


        </div>




        <div class="piedepagina">
            <p style="font-family: helvetica; font-size: 1.4em;"><strong>
                    NEED IMMEDIATE ASSISTANCE?    
                </strong></p>
        </div>


        <p class="descriptivo2">
            Want a live person to walk you through getting started?<br/>    
            Call us now! <strong>844.596.6557</strong> or contact us at <a href="mailto:mck@medtrainer.com" style="text-decoration:none; color: #565656;"><strong>mck@medtrainer.com</strong></a> </p>    


    </div>



    <div class="col span_1_of_2">

        <!--<div class="redessociales">
            
          
        <a href="http://www.google.com" target="_blank">  <img src="images/twitter.png" width="19" alt=""/> medtrainer360  </a>
          
          
          
          <a href="http://www.google.com" target="_blank">  <img src="images/facebook-ico.png" width="19" alt=""/> medtrainer360  </a>
          
          
          
          <a href="http://www.google.com" target="_blank">  <img src="images/in.png" width="19" alt=""/> medtrainer360  </a>
          
          
          <a href="http://www.google.com" target="_blank">  <img src="images/blog.png" width="19" alt=""/> medtrainer360  </a>
          
          
          
          
          
          
           </div>
        -->
    </div>





</div>



<!------ lightbox----->

<!--<a href="#" class=" btn btn-default" id="openBtn">Open modal</a>-->

<div id="myModal" class="modal fade" tabindex="-1" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h3 class="modal-title"></h3>

            </div>
            <div class="modal-body">
                <iframe src="http://player.vimeo.com/video/155570559?color=ff7700&title=0&byline=0&portrait=0"; width="500" height="375" frameborder="0" style="margin-left:35px;" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div id="myModal5" class="modal fade" tabindex="-1" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h3 class="modal-title"></h3>

            </div>

            <div class="modal-body">
                <video  id="modal5" controls width="500" height="375" style="margin-left:35px;">
                    <source src = "NSC_VIDEO.mp4" type = "video/mp4"></source>
                </video>
            </div>

            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div id="myModal6" class="modal fade" tabindex="-1" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h3 class="modal-title"></h3>

            </div>

            <div class="modal-body">
                <video id="modal6" controls width="500" height="375" style="margin-left:35px;">
                    <source src = "04.20_training_v03.mov" type = "video/mp4"></source>
                </video>
                <p style="margin-left: 35px;">
                    McKesson Account Manager Training Video
                </p>

            </div>

            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div id="myModal1" class="modal fade" tabindex="-1" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h3 class="modal-title"></h3>

            </div>
            <div class="modal-body">
                <iframe src="http://player.vimeo.com/video/133787961?color=ff7700&title=0&byline=0&portrait=0"; width="500" height="375" frameborder="0" style="margin-left:35px;" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> <p style="margin-left:35px;"><a href="https://vimeo.com/133787961">MedTrainer Account Manager System Tour</a> from <a href="https://vimeo.com/user22426728">Steve Gallion</a> on <a href="https://vimeo.com">Vimeo</a></p>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div id="myModal2" class="modal fade" tabindex="-1" role="dialog">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">×</button>
                <h3 class="modal-title"></h3>

            </div>
            <div class="modal-body">
                <iframe   src="http://player.vimeo.com/video/130132267?color=ff7700&title=0&byline=0&portrait=0" width="500" height="375" frameborder="0" style="margin-left: 35px;" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                <p style="margin-left: 35px;">
                    <a href="https://vimeo.com/130132267">Use the Mreps page and Lead Submission</a> from <a href="https://vimeo.com/user22426728">Steve Gallion</a> on <a href="https://vimeo.com">Vimeo</a>
                </p>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>



<!-----/lightbox----->














<script src="js/bootstrap.min.js"></script>

