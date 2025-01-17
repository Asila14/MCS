<?php
  if (isset($_GET['measure_id']))
      $measure_id = $_GET['measure_id'];
  else
      $measure_id = 0;
  
  include 'includes/connect.php';
  
  $query = "SELECT * FROM measurement inner join process ON measurement.process_id=process.process_id inner join package ON measurement.pack_id=package.pack_id inner join machine ON measurement.mc_id=machine.mc_id inner join material ON measurement.material_id=material.material_id inner join customer ON measurement.cust_id=customer.cust_id  inner join partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = $measure_id";
  $result = sqlsrv_query($con,$query) or die('Database connection eror');
  $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

?>
<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Lot Information</h4>
      <form class="forms-sample" action="" method="post">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Part No</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="pn_no" value="<?php echo $row['pn_no'] ?>" readonly/>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Package Size</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="pack_name" value="<?php echo $row['pack_name'] ?>" readonly/>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Lot No</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="measure_lot" value="<?php echo $row['measure_lot'] ?>" readonly/>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Customer</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="cust_name" value="<?php echo $row['cust_name'] ?>" readonly/>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Emp#</label>
              <div class="col-sm-9">
                <input class="form-control" name="measure_emp" value="<?php echo $row['measure_emp'] ?>" readonly/>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Machine#</label>
              <div class="col-sm-9">
                <input class="form-control" name="mc_name" value="<?php echo $row['mc_name'] ?>" readonly/>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>