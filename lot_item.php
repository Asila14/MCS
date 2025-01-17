<div class="col-lg-6 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">List Of Measurement Item</h4>
      <div class="table-responsive pt-3">
        <table class="table table-bordered">
          <thead>
              <tr class="table-light">
                <th class='text-center mt-3'>View</th>
                <th class='text-center mt-3'>Action</th>
                <th class='text-center mt-3'>Item</th>
                <th class='text-center mt-3'>Judgement</th>
              </tr>
            </thead>
            <tbody class="table table-sm">
              <?php
              $sqls = "SELECT * FROM measurement INNER JOIN partnumber ON measurement.id=partnumber.id inner join specification ON partnumber.id=specification.id inner join item ON specification.item_id=item.item_id WHERE measure_id = '$measure_id'";
              $results = sqlsrv_query($con,$sqls) or die('Database connection error');
              while ($rows = sqlsrv_fetch_array($results,SQLSRV_FETCH_ASSOC)) {
                      echo "<tr>";
                      echo "<td class='text-center mt-3'><a class=btn btn-primary href=measure_view.php?measure_id=".$rows['measure_id']."><i class=ti-view-list-alt></i></a></td>";
                      echo "<td class='text-center mt-3'><a class=btn btn-primary href=measure_by_item_index.php?spec_id=".$rows['spec_id']."><i class=ti-pencil></i></a></td>";
                      echo "<td class='text-center mt-3'>".$rows['item_name']."</td>";

                      $sqlcek="SELECT * FROM spec_data WHERE measure_id = '$measure_id'";
                      $result_cek = sqlsrv_query($con,$sqlcek) or die('Database connection error');
                      $row_check = sqlsrv_fetch_array($result_cek,SQLSRV_FETCH_ASSOC);

                      if ($row_check == null) {
                        echo "<td class='text-center mt-3'><label class='badge badge-danger'>Failed</label></td>";
                      } else if ($row_check['status_judge'] == 'in') {
                        echo "<td class='text-center mt-3'><label class='badge badge-success'>Pass</label></td>";
                      } else {
                        echo "<td class='text-center mt-3'><label class='badge badge-danger'>Failed</label></td>";
                      }
                    echo "</tr>";

                  }
              ?>
            </tbody>
          </head>
        </table>
      </div>
    </div>
  </div>
</div>