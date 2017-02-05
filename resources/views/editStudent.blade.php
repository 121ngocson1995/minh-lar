<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
	<script src="{{ URL::asset('js/bootstrap.min') }}"></script>
</head>
<body>
	<script langauge="JavaScript">
		var checkSemester = new Array();
		function addRow()
		{
			var semesters = <?php echo json_encode($semesters->toArray()); ?>;
			var semesterNumber = document.getElementById('semesterNumber').value;
			if (semesterNumber.localeCompare('') == 0) {
				alert("you must enter semester number");
				return;
			}
			for (var i = 0; i < checkSemester.length; i++) {
				if(checkSemester[i] == semesterNumber){
					alert("you already insert grade for this semester");
					return;
				}
			}
			var arrTables = document.getElementById('gradeTable');
			var oRows = arrTables.rows;
			var numRows = oRows.length;
			var newRow = document.getElementById('gradeTable').insertRow( numRows );
			var cell1 = newRow.insertCell(0);
			var cell2 = newRow.insertCell(1);
			var cell3 = newRow.insertCell(2);
			var cell4 = newRow.insertCell(3);
			var cell5 = newRow.insertCell(4);
			var cell6 = newRow.insertCell(5);
			var startDate;
			var endDate;
			for (var i = 0; i < semesters.length; i++) {
				if(semesterNumber == semesters[i].semester){
					startDate = semesters[i].startDate.toString();
					endDate = semesters[i].endDate.toString();
				}
			}
			cell1.innerHTML = '<input type="text" name="semester'+numRows+'" value="'+semesterNumber+'" readonly>';
			checkSemester.push(semesterNumber);
			if (startDate == undefined ||endDate == undefined) {
				cell2.innerHTML = '<input type="date" name="startDate'+numRows+'" >';
				cell3.innerHTML = '<input type="date" name="endDate'+numRows+'" >';
			} else {
				cell2.innerHTML = '<input type="date" name="startDate'+numRows+'" value="'+startDate+'" readonly>';
				cell3.innerHTML = '<input type="date" name="endDate'+numRows+'" value="'+endDate+'" readonly>';
			};
			cell4.innerHTML = '<input type="text" name="semester'+semesterNumber+'MathGrade" >';
			cell5.innerHTML = '<input type="text" name="semester'+semesterNumber+'ChemistryGrade" >';
			cell6.innerHTML = '<input type="text" name="semester'+semesterNumber+'PhysicsGrade" >';

			document.getElementById("hiddenSemester").innerHTML = '<input type="text" name="semesterCount" hidden="true" value="'+numRows+'">';
			document.getElementById("semesterNumber").value= "";
		}

	</script>
	
	<form action="EditStudent" method="get">
		<table>
			<tr>
				<th text align="left">Name:</th>
				<th><input type="text" name="name" value="{{ $studentEdit[0]->name }}"></th>
			</tr>
			<tr>
				<th text align="left">Age:</th>
				<th><input type="text" name="age" value="{{ $studentEdit[0]->age }}"></th>
			</tr>
		</table>
		<table id="gradeTable" border="1">
			<tr>
				<td>Semester</td>
				<td>Start date</td>
				<td>End date</td>
				<td>Math</td>
				<td>Chemistry</td>
				<td>Physics</td>
			</tr>
			<?php $grades = $studentEdit[0]->grades; ?>
			@foreach($grades as $grade)
			<tr>
				<td><input type="text" name="semester" value="{{ $grade->semester->semester}}"></td>
				<td><input type="text" name="startDate" value="{{ $grade->semester->startDate}}"></td>
				<td><input type="text" name="endDate" value="{{ $grade->semester->endDate}}"></td>
				<td><input type="text" name="math" value="{{ $grade->math }}"></td>
				<td><input type="text" name="chemistry" value="{{ $grade->chemistry }} "></td>
				<td><input type="text" name="physics" value="{{ $grade->physics }} "></td>
			</tr>	
			@endforeach
		</table>
		<input type="text" id="semesterNumber" ><button type="button" onclick="javascript: addRow()" >Add Semester</button>
		<p id="hiddenSemester"></p>
	</div>
	<br><button type="submit" class="btn btn-primary" type="button">Edit grade</button>
</form>
</body>
</html>