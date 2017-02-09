<!DOCTYPE html>
<html>
<head>
	<title></title>

	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
	<script src="{{ URL::asset('js/bootstrap.min') }}"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
	<style type="text/css">
		.inputtrans {
			background-color: transparent;
		}

		input.inputtrans {
			padding: 10px;
			border: none;
			border-bottom: solid 2px #f7f7f7;
			transition: border 0.3s;
			text-align: center;
		}

		.inputtrans:focus {
			outline: none;
			color: cornflowerblue;
			border-bottom: solid 2px #c9c9c9;
		}

		.toBeDel {
			background-color: rgba(255, 0, 0, 0.5) !important;
		}

		.toBeDel>td>input {
			color: white;
			border-bottom: solid 2px transparent;
			transition: color 0.3s;
		}
	</style>

	<script langauge="JavaScript">
		var checkSemester = new Array();
		var rowOfSemesterAdd = 0;
		var deleteSemester = new Array();
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
			cell1.innerHTML = '<input type="text" name="semesterAdd'+rowOfSemesterAdd+'" value="'+semesterNumber+'" style="width: 30px; margin-left: 15px;" readonly required>';
			checkSemester.push(semesterNumber);
			if (startDate == undefined ||endDate == undefined) {
				cell2.innerHTML = '<input type="date" name="startDateAdd'+rowOfSemesterAdd+'" style="width: 95px;" required>';
				cell3.innerHTML = '<input type="date" name="endDateAdd'+rowOfSemesterAdd+'" style="width: 95px;" required>';
			} else {
				cell2.innerHTML = '<input type="date" name="startDateAdd'+rowOfSemesterAdd+'" value="'+startDate+'" readonly required>';
				cell3.innerHTML = '<input type="date" name="endDateAdd'+rowOfSemesterAdd+'" value="'+endDate+'" readonly required>';
			};
			cell4.innerHTML = '<input type="text" name="semesterAdd'+semesterNumber+'MathGrade" maxlength="4" style="width: 50px;" required>';
			cell5.innerHTML = '<input type="text" name="semesterAdd'+semesterNumber+'ChemistryGrade" maxlength="4" style="width: 50px;" required>';
			cell6.innerHTML = '<input type="text" name="semesterAdd'+semesterNumber+'PhysicsGrade" maxlength="4" style="width: 50px;" required>';

			document.getElementById("hiddenSemester").innerHTML = '<input type="text" name="semesterCount" hidden="true" value="'+rowOfSemesterAdd+' required">';
			document.getElementById("semesterNumber").value= "";
		}



		function changeColor(o, delBtn){
			// if (document.getElementById('row'+o).style.backgroundColor==="transparent" || document.getElementById('row'+o).style.backgroundColor==="") {
			// 	document.getElementById('row'+o).style.backgroundColor='rgba(255, 0, 0, 0.5)';
			// 	deleteSemester.push(o);
			// }else{
			// 	document.getElementById('row'+o).style.backgroundColor='transparent';
			// 	var index = deleteSemester.indexOf(o);
			// 	deleteSemester.splice(index, 1 );

			// }


			$(delBtn).closest('tr').toggleClass("toBeDel");
			deleteSemester.includes(o) ? deleteSemester.splice(deleteSemester.indexOf(o), 1) : deleteSemester.push(o);
        }

        
	</script>
	
	
	<form id="EditStudent" action="EditStudent" method="get">
		<table class="table table-hover">
			<tr>
				<th text align="left">Name:</th>
				<th><input type="text" class="inputtrans" name="name" value="{{ $studentEdit[0]->name }}"></th>
			</tr>
			<tr>
				<th text align="left">Age:</th>
				<th><input type="text" name="age" class="inputtrans" value="{{ $studentEdit[0]->age }}"></th>
			</tr>
		</table>
		<table class="table table-hover" id="gradeTable">
			<tr>
				<th>Semester</th>
				<th>Start date</th>
				<th>End date</th>
				<th>Math</th>
				<th>Chemistry</th>
				<th>Physics</th>
				<th></th>
			</tr>
			<?php $grades = $studentEdit[0]->grades; ?>
			@for($i=0; $i < count($grades) ; $i++)
			<tr id="row{{$i}}">
				<td><input type="text" class="inputtrans" name="semester{{$i}}" value="{{ $grades[$i]->semester->semester}}" style="width: 30px; margin-left: 15px;" readonly="" required=""></td>
				<td><input type="text" class="inputtrans" name="startDate{{$i}}" value="{{ $grades[$i]->semester->startDate}}" style="width: 95px;" readonly="" required=""></td>
				<td><input type="text" class="inputtrans" name="endDate{{$i}}" value="{{ $grades[$i]->semester->endDate}}" style="width: 95px;" readonly="" required=""></td>
				<td><input type="text" class="inputtrans" name="math{{ $grades[$i]->semester->semester}}" value="{{ $grades[$i]->math }}" maxlength="4" style="width: 50px;" required=""></td>
				<td><input type="text" class="inputtrans" name="chemistry{{ $grades[$i]->semester->semester}}" value="{{ $grades[$i]->chemistry }}" maxlength="4" style="width: 50px;" required=""></td>
				<td><input type="text" class="inputtrans" name="physics{{ $grades[$i]->semester->semester}}" value="{{ $grades[$i]->physics }}" maxlength="4" style="width: 50px;" required=""></td>
				<td style="vertical-align: middle;"><button type="button" class="close" onclick="changeColor({{$i}}, this)"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button></td>
			</tr>	
			@endfor
		</table>
		<input type="text" id="semesterNumber" ><button type="button" onclick="javascript: addRow()" >Add Semester</button>
		<p id="hiddenSemester"></p>
		<input type="text" name="student_id" hidden="true" value="{{ $studentEdit[0]->id }}">
		<br><button type="submit" class="btn btn-primary" type="button">Edit grade</button>
	</form>

	<script type="text/javascript">
		$("#EditStudent").submit( function(eventObj) {
				$('<input />').attr('type', 'hidden')
					.attr('name', "semesterDelete")
					.attr('value', deleteSemester.toString())
					.appendTo('#EditStudent');
				return true;
			});
	</script>

</body>
</html>