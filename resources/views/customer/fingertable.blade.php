
<?php
    $mdbFilename =  $_SERVER["DOCUMENT_ROOT"]."/hyatt/timekeeper/timekeeper.mdb";
    if (file_exists($mdbFilename)) {
        $user = "";
        $password = "";
        $db = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=$mdbFilename; Uid=; Pwd=;");
    }else{
        echo $_SERVER["DOCUMENT_ROOT"]."/hyatt/timekeeper/timekeeper.mdb";
    }

    $sql  = "SELECT * FROM fingerprint";
    $result = $db->query($sql);
    dd(count($result));
    if (count($result) > 0) {
        while ($row = $result->fetch()) {
            $inSql = "SELECT * FROM employee WHERE employeeid = ".$row["employeeid"];
            $inResult = $db->query($inSql);
            while ( $childRow = $inResult->fetch()) {
                $finger = \App\Fingerprint::updateOrCreate(['customer_id' => $childRow["idno"], 'finger' => $row['finger']], ['templates' => $row['template'], 'hash' => $row['hash']]);    
            }
        }
    }
?>

<div class="row">
	<div class="col-md-12">
		<table class="table table-bordered">
			<thead>
				<th class="text-center">Finger</th>
				<th class="text-center">Status</th>
			</thead>
			<tbody>
				<tr>
					<td><strong>LEFT PINKIE: </strong></td>
					<td>{{ ( $info->fingerPrint()->where('finger','=','LEFT PINKIE')->count() > 0  ) ? 'COMPLETE' : 'NOT YET' }}</td>
				</tr>
				<tr>
					<td><strong>LEFT RING: </strong></td>
					<td>{{ ( $info->fingerPrint()->where('finger','=','LEFT RING')->count() > 0  ) ? 'COMPLETE' : 'NOT YET' }}</td>
				</tr>
				<tr>
					<td><strong>LEFT MIDDLE: </strong></td>
					<td>{{ ( $info->fingerPrint()->where('finger','=','LEFT MIDDLE')->count() > 0  ) ? 'COMPLETE' : 'NOT YET' }}</td>
				</tr>
				<tr>
					<td><strong>LEFT INDEX: </strong></td>
					<td>{{ ( $info->fingerPrint()->where('finger','=','LEFT INDEX')->count() > 0  ) ? 'COMPLETE' : 'NOT YET' }}</td>
				</tr>
				<tr>
					<td><strong>LEFT THUMB: </strong></td>
					<td>{{ ( $info->fingerPrint()->where('finger','=','LEFT THUMB')->count() > 0  ) ? 'COMPLETE' : 'NOT YET' }}</td>
				</tr>
				
				<tr>
					<td><strong>RIGHT THUMB: </strong></td>
					<td>{{ ( $info->fingerPrint()->where('finger','=','RIGHT THUMB')->count() > 0  ) ? 'COMPLETE' : 'NOT YET' }}</td>
				</tr>
				<tr>
					<td><strong>RIGHT INDEX: </strong></td>
					<td>{{ ( $info->fingerPrint()->where('finger','=','RIGHT INDEX')->count() > 0  ) ? 'COMPLETE' : 'NOT YET' }}</td>
				</tr>
				<tr>
					<td><strong>RIGHT MIDDLE: </strong></td>
					<td>{{ ( $info->fingerPrint()->where('finger','=','RIGHT MIDDLE')->count() > 0  ) ? 'COMPLETE' : 'NOT YET' }}</td>
				</tr>
				<tr>
					<td><strong>RIGHT RING: </strong></td>
					<td>{{ ( $info->fingerPrint()->where('finger','=','RIGHT RING')->count() > 0  ) ? 'COMPLETE' : 'NOT YET' }}</td>
				</tr>
				<tr>
					<td><strong>RIGHT PINKIE: </strong></td>
					<td>{{ ( $info->fingerPrint()->where('finger','=','RIGHT PINKIE')->count() > 0  ) ? 'COMPLETE' : 'NOT YET' }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>


