<?php
 include 'includes/connect.php';
            if (isset($_GET['measure_id']) && isset($_GET['id'])) {
    $measure_id = $_GET['measure_id'];
           $id = $_GET['id'];
         
    $query = "SELECT
        *
    FROM
        spec_result
    INNER JOIN spec_data ON spec_result.measure_id = spec_data.measure_id
    INNER JOIN measurement ON spec_result.measure_id = measurement.measure_id
    INNER JOIN process ON process.process_id = measurement.process_id
    INNER JOIN partnumber ON partnumber.id = spec_result.id
    INNER JOIN specification ON specification.spec_id = spec_result.spec_id
    INNER JOIN item ON specification.item_id = item.item_id
    INNER JOIN machine ON measurement.mc_id = machine.mc_id
    INNER JOIN material ON measurement.material_id = material.material_id
    WHERE spec_result.result_judgement = 'pass' AND measurement.measure_id='$measure_id' AND partnumber.id='$id' ";
    
        $result = sqlsrv_query($con,$query) or die('SQL error');
        $row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC);
        $html='<table>';
        
        while ($row = sqlsrv_fetch_array($result,SQLSRV_FETCH_ASSOC)) {
            $html .= '<tr>
            <td>' . $row['pn_no'] . '</td>
            <td>' . $row['process_code'] . '</td>
            <td>' . $row['measure_lot'] . '</td>
            <td>' . $row['item_code'] . '</td>
            <td>0</td>
            <td></td>
            <td></td>
            <td>' . $row['data'] . '</td>
            <td>NG020402</td>
            <td>' . (strlen($row['measure_emp']) < 6 ? substr($row['measure_emp'], 0, 1) . '00' . substr($row['measure_emp'], 1) : $row['measure_emp']) . '</td>
        </tr>';
        // Generate a filename using the $pn_no and $measure_lot values.
        $filename = $row['pn_no'] . '-' . $row['measure_lot'] . '.xls';
        }
    }
        $html.='</table>';

        header('Content-Type:application/xls');
        header('Content-Disposition:attachment;filename='. $filename);
        echo $html;
    
?>