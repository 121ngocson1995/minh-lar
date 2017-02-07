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
		var rowOfSemesterAdd = 0;
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
			rowOfSemesterAdd = rowOfSemesterAdd + 1;
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
			cell1.innerHTML = '<input type="text" name="semesterAdd'+rowOfSemesterAdd+'" value="'+semesterNumber+'" readonly>';
			checkSemester.push(semesterNumber);
			if (startDate == undefined ||endDate == undefined) {
				cell2.innerHTML = '<input type="date" name="startDateAdd'+rowOfSemesterAdd+'" >';
				cell3.innerHTML = '<input type="date" name="endDateAdd'+rowOfSemesterAdd+'" >';
			} else {
				cell2.innerHTML = '<input type="date" name="startDateAdd'+rowOfSemesterAdd+'" value="'+startDate+'" readonly>';
				cell3.innerHTML = '<input type="date" name="endDateAdd'+rowOfSemesterAdd+'" value="'+endDate+'" readonly>';
			};
			cell4.innerHTML = '<input type="text" name="semesterAdd'+semesterNumber+'MathGrade" >';
			cell5.innerHTML = '<input type="text" name="semesterAdd'+semesterNumber+'ChemistryGrade" >';
			cell6.innerHTML = '<input type="text" name="semesterAdd'+semesterNumber+'PhysicsGrade" >';

			document.getElementById("hiddenSemester").innerHTML = '<input type="text" name="semesterCount" hidden="true" value="'+rowOfSemesterAdd+'">';
			document.getElementById("semesterNumber").value= "";
		}

		function deleteRow(btn) {
			var row = btn.parentNode.parentNode;
			row.parentNode.removeChild(row);
		}

		function updateRows() {
			var checked = $("input:checked");
			var nbChecked = checked.size();
			if (nbChecked == 1) {
				checked.parent().parent().css("background", "#FFFF33");
			}
		}

		function changeColor(o){
        document.getElementById(o).style.backgroundColor='red';
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
			@for($i=0; $i < count($grades) ; $i++)
			<tr id="{{ $grades[$i]->semester->semester}}">
				<td><input type="text" name="semester{{$i}}" value="{{ $grades[$i]->semester->semester}}" readonly=""></td>
				<td><input type="text" name="startDate{{$i}}" value="{{ $grades[$i]->semester->startDate}}" readonly=""></td>
				<td><input type="text" name="endDate{{$i}}" value="{{ $grades[$i]->semester->endDate}}" readonly=""></td>
				<td><input type="text" name="math{{ $grades[$i]->semester->semester}}" value="{{ $grades[$i]->math }}"></td>
				<td><input type="text" name="chemistry{{ $grades[$i]->semester->semester}}" value="{{ $grades[$i]->chemistry }} "></td>
				<td><input type="text" name="physics{{ $grades[$i]->semester->semester}}" value="{{ $grades[$i]->physics }} "></td>
				<td style='border-right:none;border-left:none;border-bottom:none;border-top:none'><button type="button" class="close" onclick="changeColor({{ $grades[$i]->semester->semester}})><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></td>
			</tr>	
			@endfor
		</table>
		<input type="text" id="semesterNumber" ><button type="button" onclick="javascript: addRow()" >Add Semester</button>
		<p id="hiddenSemester"></p>
		<input type="text" name="student_id" hidden="true" value="{{ $studentEdit[0]->id }}">
	</div>
	<br><button type="submit" class="btn btn-primary" type="button">Edit grade</button>
</form>
</body>
</html>