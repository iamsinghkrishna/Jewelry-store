<?php
if (isset($users)) {
    foreach ($users as $result) {
        ?>  
        <div class="modal fade" id="viewCandidateDetails_<?php echo $result->id ?>" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
               <div class="modal-content">
                    <?php //var_dump($result); ?>
                    <div class="modal-header all-padding-10">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        <h4 class="modal-title text-bold "><span ><?php echo $result->first_name ?></span></h4>
                    </div>
                    <!-- modal body here --> 
                    <div class="user-normal-slim">
                        <div class="modal-body">
                            <div class="candidate-timeline-bg">
                                <div class="row">


                                    <div class=""> 
                                        <table class="table-bordered candidate-info">
                                            <tr>
                                                <td>
                                                    <!--Candidate Name-->
                                                    <div class="cand-icon-left"> 
                                                        <i class="fa fa-fw fa-user" title="Candidate Name"></i>
                                                    </div>
                                                    <div class="emp-content-right"> 
                                                        <?php echo $result->first_name ?>
                                                    </div>
                                                    <!--Candidate Name-->


                                                </td>
                                                <td>
                                                    <!--Official Email-->
                                                    <div class="cand-icon-left"> 
                                                        <i class="fa fa-fw fa-envelope" title="Official Email"></i>
                                                    </div>
                                                    <div class="emp-content-right"> 
                                                        <a href="mailto: <?php echo $result->email ?>"> <?php echo $result->email ?></a>
                                                    </div>
                                                    <!--Official Email-->
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <!--Experience-->
                                                    <div class="cand-icon-left"> 
                                                        <i class="fa fa-fw fa-briefcase" title="Experience"></i>
                                                    </div>
                                                    <div class="emp-content-right"> 
                                                        <?php //echo $result['years_exp'] ?>.<?php //echo $result['months_exp'] ?> years
                                                    </div>
                                                    <!--Experience-->





                                                </td>
                                                <td>
                                                    <!--Education Email-->
                                                    <div class="cand-icon-left"> 
                                                        <i class="fa fa-fw fa-book" title="Education"></i>
                                                    </div>
                                                    <div class="emp-content-right"> 
                                                        <?php //echo $result['qualification'] ?>
                                                    </div>
                                                    <!--Education Email-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <!--Contact Number-->
                                                    <div class="cand-icon-left"> 
                                                        <i class="fa fa-fw fa-phone" title="Contact Number"></i>
                                                    </div>
                                                    <div class="emp-content-right"> 
                                                        <?php //echo $result['contact_number'] ?>
                                                    </div>
                                                    <!--Contact Number-->





                                                </td>
                                                <td>
                                                    <!--Location-->
                                                    <div class="cand-icon-left"> 
                                                        <i class="fa fa-fw fa-map-marker" title="Location"></i>
                                                    </div>
                                                    <div class="emp-content-right"> 
                                                        <?php //echo $result['cand_location'] ?>
                                                    </div>
                                                    <!--Location-->
                                                </td>
                                            </tr>

                                            <tr>

                                            </tr>
                                        </table>







                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  

        <?php
    }
}
?>