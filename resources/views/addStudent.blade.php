@extends('layout')

@section('title')
<h1 style="font-size: 400%" align="center">Add Student</h1>


@stop

@section('table')
<style type="text/css">
	#div1 {
		width: 70px;
		height: 70px;
		padding: 10px;
		border: 1px solid #aaaaaa;
		background-image: url("{{ URL::asset('image/garbage bin.jpeg') }}");
		background-size: Auto 70px;
	}
	.img_bin{
		width:80px;height:80px;
		position: relative;
		left: 35%;
	}
</style>
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
		newRow.id = numRows;
		newRow.setAttribute('draggable', "true");
		newRow.setAttribute('ondragstart', "javascript: drag(event)");
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
		cell1.innerHTML = '<input id="semesterName" type="text" name="semesterAdd'+numRows+'" value="'+semesterNumber+'" readonly>';
		checkSemester.push(semesterNumber);
		if (startDate == undefined ||endDate == undefined) {
			cell2.innerHTML = '<input type="date" name="startDateAdd'+numRows+'" >';
			cell3.innerHTML = '<input type="date" name="endDateAdd'+numRows+'" >';
		} else {
			cell2.innerHTML = '<input type="date" name="startDateAdd'+numRows+'" value="'+startDate+'" readonly>';
			cell3.innerHTML = '<input type="date" name="endDateAdd'+numRows+'" value="'+endDate+'" readonly>';
		};
		cell4.innerHTML = '<input type="text" name="semesterAdd'+semesterNumber+'MathGrade" >';
		cell5.innerHTML = '<input type="text" name="semesterAdd'+semesterNumber+'ChemistryGrade" >';
		cell6.innerHTML = '<input type="text" name="semesterAdd'+semesterNumber+'PhysicsGrade" >';

		document.getElementById("hiddenSemester").innerHTML = '<input id="semesterCount" type="text" name="semesterCount" hidden="true" value="'+numRows+'">';
		document.getElementById("semesterNumber").value= "";
	}
	function allowDrop(event){
		event.preventDefault();
	}

	function drag(event) {
		var semesterNumber;
		for (var i = 0; i < event.target.childNodes.length; i++) {
			for (var j = 0; j < event.target.childNodes[i].children[0].attributes.length; j++) {
				if (event.target.childNodes[i].children[0].attributes[j].value.localeCompare('semesterAdd'+event.target.id)==0) {
					semesterNumber = checkSemester.indexOf(event.target.childNodes[i].children[0].attributes[j].value);
				}
			}
			
		}event.dataTransfer.setData("text", event.target.id+','+semesterNumber);


	}

	function drop(event) {
		event.preventDefault();
		var data = event.dataTransfer.getData("text").split(",");
		document.getElementById("addGradeTable").deleteRow(data[0]);
		semesterCount = document.getElementById("semesterCount").getAttribute("value");
		semesterCount = parseInt(semesterCount)-1;
		document.getElementById("semesterCount").setAttribute("value", semesterCount);
		checkSemester.splice(checkSemester.indexOf(data[1],1));
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
	<div class="row">
		<div class="col-sm-3 col-md-6 col-lg-4"><button type="button" class="btn btn-info" data-toggle="collapse" data-target="#addGrade">Add grade</button></div>
		<div class="col-sm-9 col-md-6 col-lg-8"><div id="div1" ondrop="javascript: drop(event)" ondragover="javascript: allowDrop(event)" class="img_bin"></div></div>
	</div>
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