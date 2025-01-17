 <?php
            include 'includes/connect.php';
            if (isset($_POST['ins']) && isset($_GET['measure_id']) && isset($_GET['id']) && isset($_GET['spec_id']) && isset($_GET['item_id'])&& isset($_GET['attempt']) ) {

            $measure_id = $row["measure_id"];
            $spec_id = $row["spec_id"];
            $spec_id = $row["spec_id"];
            $item_id = $row["item_id"];
            $id = $row["id"];
            $status_judge = $_POST['status_judge'];
            $count = 1;
            $attempt = $_POST['attempt'];
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $data_datetime = date("Y-m-d H:i:s");
            for ($i=1; $i <= $row['spec_spl_point']; $i++) { 
            for ($d=1; $d<=$row['spec_data_spl']; $d++){
            $data = $_POST[$i.$d."data"];
            if($data <=$row['spec_usl'] && $data >=$row['spec_lsl'])
            {
              $data_result = 'O';
            }
            else
            {
              $data_result = 'X';
            }
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $data_date = date("d-M-Y  H:i");
            $sql_data = "INSERT INTO spec_data (data,spec_id,measure_id,status_judge,data_result,item_id,id,attempt,data_datetime) VALUES ('$data','$spec_id','$measure_id','$status_judge','$data_result','$item_id','$id','$attempt','$data_datetime')";
            $result_sql_data = sqlsrv_query ($con,$sql_data);

            if($result_sql_data > 0){
                   // Use Sweetalert to show a success message
                        echo '
                          <script>
                            swal({
                              title: "Done!",
                              text: "Data has been succesfully registered.",
                              icon: "success",
                              button: "OK",
                            });
                          </script>
                        ';

                      } else {
                        // Use Sweetalert to show an error message
                        echo '
                          <script>
                            swal({
                              title: "Failed!",
                              text: "The operation failed.",
                              icon: "error",
                              button: "OK",
                            });
                          </script>
                        ';
                }
                }
              }
            }
          ?>