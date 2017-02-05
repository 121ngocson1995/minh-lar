@extends('layout')

@section('title')
<h1 style="font-size: 400%" align="center">Add Student</h1>

@stop

@section('table')
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
		var arrTables = document.getElementById('addGradeTable');
		var oRows = arrTables.rows;
		var numRows = oRows.length;
		var newRow = document.getElementById('addGradeTable').insertRow( numRows );
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

<form action="AddStudent" method="get">
	<table>
		<tr>
			<th text align="left">Name:</th>
			<th><input type="text" name="name" required="true"></th>
		</tr>
		<tr>
			<th text align="left">Age:</th>
			<th><input type="text" name="age" required="true"></th>
		</tr>
	</table>
	<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#addGrade">Add grade</button>
	<div id="addGrade" class="collapse">
		<table id="addGradeTable" border="1">
			<tr>
				<td>Semester</td>
				<td>Start date</td>
				<td>End date</td>
				<td>Math</td>
				<td>Chemistry</td>
				<td>Physics</td>
			</tr>
		</table>
		<input type="text" id="semesterNumber" ><button type="button" onclick="javascript: addRow()" >Add Semester</button>
		<p id="hiddenSemester"></p>
	</div>
	<br><input type="submit" value="Add">
</form>
@stop