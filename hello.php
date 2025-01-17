<div class="col-md-12">
  <form action="" method="GET">
  <div class="card shadow mt-3">
  <div class="card-title">
    <h5>
      Filter
      <button type="submit" class="btn btn-primary" >Search</button>
    </h5>
  </div>
<div class="card-body">
<h6> Process List </h6>
<hr>
<?php
include 'includes/connect.php';

$process_query = "SELECT * FROM process";
$process_query_run = sqlsrv_query($con, $process_query);

if ($process_query_run > 0) {
    $process_list = [];
    while ($row = sqlsrv_fetch_array($process_query_run, SQLSRV_FETCH_ASSOC)) {
        $process_list[] = $row;
    }

    foreach ($process_list as $processlist) {
        $checked = [];
        if (isset($_GET['process'])) {
            $checked = $_GET['process'];
        }

        ?>
        <div>
            <input type="checkbox" name="process[]" value="<?= $processlist['process_id']; ?>"
                <?php if (in_array($processlist['process_id'], $checked)) {
                    echo "checked";
                } ?>
            />
            <?php echo $processlist['process_name']; ?>
        </div>
    <?php
    }
} else {
    echo "No process found...";
}

?>

</div>
</form>
</div>
</div>

<!-- Process Item -->
<div class="col-md-12">
  <div class="card">
    <div class="card-body">
      <?php
      if(isset($_GET['process']))
      {
        $processcheck = [];
        $processcheck = $_GET['process'];
        foreach($processcheck as $rowprocess){
          $item_pro = "SELECT * FROM item WHERE process_id IN ($rowprocess)";
        $item_pro_run = sqlsrv_query($con, $item_pro);

        if($item_pro_run > 0) {
          $item_list = [];
          while ($row = sqlsrv_fetch_array($item_pro_run, SQLSRV_FETCH_ASSOC)) {
            $item_list[] = $row;
          }

          foreach ($item_list as $itempro) {
        ?>
            <div class="col-md-4">
              <div class="border p-2">
                <h6><?= $itempro['item_name']; ?></h6>
              </div>
            </div>
        <?php
          }
        } else {
          echo "No item found...";
        }
        }

      }else
      {

        $item_pro = "SELECT * FROM item";
        $item_pro_run = sqlsrv_query($con, $item_pro);

        if($item_pro_run > 0) {
          $item_list = [];
          while ($row = sqlsrv_fetch_array($item_pro_run, SQLSRV_FETCH_ASSOC)) {
            $item_list[] = $row;
          }

          foreach ($item_list as $itempro) {
        ?>
            <div class="col-md-4">
              <div class="border p-2">
                <h6><?= $itempro['item_name']; ?></h6>
              </div>
            </div>
        <?php
          }
        } else {
          echo "No item found...";
        }

      }
      ?>
    </div>
  </div>
</div>


