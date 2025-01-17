<div class="modal" id="myModal">
        <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Register New Measurement</h4>    
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div><div class="container"></div>
                <div class="modal-body">
                  <form action="" method="POST">
                    <h6 class="text-danger">If PROCESS is not listed, please REGISTER. </h6>
                    <div class="row">
                      <div class="form-group row">
                        <div class="col-md-6">
                          <label>Select Process</label>
                          <?php
                                include 'includes/connect.php';
                                $pro = sqlsrv_query($con,"SELECT * FROM process ");
                          ?>
                              <input type="hidden" id="process_id" name="process_id" value="<?php if(isset($_POST['process_id'])){echo $_POST['process_id'];} ?>" class="form-control" />
                              <select data-live-search="true" name="process_id" class="form-control selectpicker">
                                <option>- Please Select -</option>
                                <?php 
                                if($pro > 0) {
                                 while($pc = sqlsrv_fetch_array($pro,SQLSRV_FETCH_ASSOC)){
                                
                                ?>
                                  <option name="process_id" value="<?php echo $pc['process_id']?> "><?php echo $pc['process_name']; ?>
                                    <?php } } ?></option>
                              </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <div class="input-group-append">
                        <button type="submit" data-bs-toggle="modal" href="#myModal2" name="search" class="btn btn-sm btn-primary">Search</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <script type="text/javascript">
                var select_box_element = document.querySelector('#select_box');
                deselect(select_box_element, {
                  search:true
                });
              </script>
                </div>
              </div>
            </div>
        </div>
        <div class="modal" id="myModal2" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Register New Measurement</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div><div class="container"></div>
                <div class="modal-body">
                  <form action="" method="POST">
                    <h6 class="text-danger">If PN is not listed, please REGISTER PART NO</h6>
                    <br>
                      <div class="row">
                        <div class="form-group row">
                          <div class="col-md-6">
                            <label>Select Part No.</label>
                            <?php
                            if (isset($_POST['search'])){
                                  $process_id = $_POST['process_id'];

                              $query = "SELECT * FROM partnumber WHERE process_id = '$process_id' ";
                              $query_run = sqlsrv_query($con,$query);

                              /*If process registered success , directly go to register item*/
                              if($query_run)
                              {
                                  $part = sqlsrv_query($con,"SELECT * FROM partnumber WHERE process_id = '$process_id' ");
                            ?>
                                <input type="hidden" id="id" name="id" value="<?php if(isset($_POST['id'])){echo $_POST['id'];} ?>" class="form-control" />
                                <select data-live-search="true" name="id" class="form-control selectpicker">
                                  <option>- Please Select -</option>
                                  <?php 
                                  if($part > 0) {
                                   while($pt = sqlsrv_fetch_array($part,SQLSRV_FETCH_ASSOC)){
                                  
                                  ?>
                                    <option name="id" value="<?php echo $pt['id']?> "><?php echo $pt['pn_no']; ?>
                                      <?php } } } } ?></option>
                                </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="input-group-append">
                              <input type="hidden" name="process_id" value="<?php echo $process_id ?>" />
                          <button type="submit" data-bs-toggle="modal" href="#myModal3"  name="S" class="btn btn-sm btn-primary">Search</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
            </div>
          </div>
        </div>
    </div>
    <div class="modal" id="myModal3" data-bs-backdrop="static">
        <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Register New Measurement</h4>
                  <?php
                  if (isset ($_POST['S']))
                {
                  $id = $_POST['id'];
                  $process_id = $_POST['process_id'];
                  /*To list customer data*/
                  $cust = sqlsrv_query($con,"SELECT * FROM partnumber inner join customer ON partnumber.cust_id=customer.cust_id inner join package ON partnumber.pack_id=package.pack_id inner join process ON partnumber.process_id=process.process_id WHERE id='$id' ");
                  $rowC = sqlsrv_fetch_array($cust,SQLSRV_FETCH_ASSOC);
                ?>
                  <h3 class="text-dark">Process: <?php echo $rowC['process_name']; ?> </h3><h3 class="text-primary">(<?php echo $rowC['pn_no']; ?>)</h3>
                <br>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div><div class="container"></div>
                <div class="modal-body">
                  <form action="" method="POST">
                  <div class="form-group row">
                    <input type="hidden" name="id" value="<?php if(isset($_POST['id'])){echo $_POST['id'];} ?>" class="form-control" />
                    <?php
                    date_default_timezone_set('Asia/Kuala_Lumpur');
                    $measure_datetime = date("Y-m-d H:i:s");
                    ?>
                    
                    <div class="col">
                      <label>Lot No.</label>
                      <div id="bloodhound"> 
                        <input class="typeahead" type="text" name="measure_lot" value="<?php if(isset($_POST['measure_lot'])){echo $_POST['measure_lot'];} ?>" class="form-control" autocomplete="off" required />
                      </div>
                    </div>
                    <div class="col">
                      <label>Customer</label>
                      <div id="the-basics">
                        <input class="typeahead" type="hidden" name="cust_id" value="<?php echo $rowC['cust_id']; ?>"/>
                        <input class="typeahead" type="text" value="<?php echo $rowC['cust_name'] ?>" readonly/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="col">
                      <label>Employee No.</label>
                      <div id="the-basics">
                        <input class="typeahead" type="text" autocomplete="off" name="measure_emp" value="<?php if(isset($_POST['measure_emp'])){echo $_POST['measure_emp'];} ?>" class="form-control" required />
                      </div>
                    </div>
                    <div class="col">
                      <label>Package</label>
                      <div id="bloodhound">
                        <input class="typeahead" type="hidden" name="pack_id" value="<?php echo $rowC['pack_id']; ?>"/>
                        <input class="typeahead" type="text" value="<?php echo $rowC['pack_name'] ?>" readonly/>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col">
                      <label>Select Machine</label>
                      <?php
                            include 'includes/connect.php';
                            /*To list machine data*/
                          $machine = sqlsrv_query($con,"SELECT * FROM machine WHERE process_id='$process_id' ");
                          
                      ?>
                          <input type="hidden" id="mc_id" name="mc_id" value="<?php if(isset($_POST['mc_id'])){echo $_POST['mc_id'];} ?>" class="form-control" />
                          <select data-live-search="true" name="mc_id" class="form-control selectpicker">
                            <?php 
                            if($machine > 0) {
                             while($rowM = sqlsrv_fetch_array($machine,SQLSRV_FETCH_ASSOC)){
                            
                            ?>
                              <option name="mc_id" value="<?php echo $rowM['mc_id']?> "><?php echo $rowM['mc_name']; ?>
                                <?php } } ?></option>
                          </select>
                    </div>
                  </div>

                  <div class="form-group row">
                    <div class="col">
                      <label>Select Material</label>
                      <?php
                            include 'includes/connect.php';
                            /*To list machine data*/
                          $material = sqlsrv_query($con,"SELECT * FROM material WHERE process_id='$process_id' ");
                          
                      ?>
                          <input type="hidden" id="material_id" name="material_id" value="<?php if(isset($_POST['material_id'])){echo $_POST['material_id'];} ?>" class="form-control" />
                          <select data-live-search="true" name="material_id" class="form-control selectpicker">
                            <?php 
                            if($material > 0) {
                             while($rowMe = sqlsrv_fetch_array($material,SQLSRV_FETCH_ASSOC)){
                            
                            ?>
                              <option name="material_id" value="<?php echo $rowMe['material_id']?> "><?php echo $rowMe['material_part']; ?>
                                <?php } } ?></option>
                          </select>
                    </div>
                    <div class="col">
                      <label>Material Lot</label>
                      <div id="bloodhound">
                        <input class="typeahead" type="text" autocomplete="off" name="measure_mate_lot" value="<?php if(isset($_POST['measure_mate_lot'])){echo $_POST['measure_mate_lot'];} ?>" class="form-control" required />
                      </div>
                    </div>
                  </div>
                  <div id="bloodhound">
                    <input type="hidden" name="process_id" value="<?php echo $process_id ?>" />
                    <button type="submit" name="submitmeasure" class="btn btn-sm btn-primary">Submit</button>
                  </div>
                </form>
                 <?php 
              }       
              ?>
            </div>
          </div>
        </div>
    </div>