@extends('layout')

@section('title')
<h1 style="font-size: 400%" align="center">All Students</h1>

@stop

@section('table')
@if (session('msg'))
    <div class="alert alert-success">
        {{ session('msg') }}
    </div>
@endif
<form action="ListByRequest" method="post">
{{ csrf_field() }}
<h2 align="center">Choose a semester
<select name="combobox" onchange="this.form.submit()">
	<option value="All semester" >All semester</option>
	@foreach($semesters as $semester)
		<?php echo($semester); ?>
	<option value="{{ $semester->semester }}"

	<?php if(strcmp($combobox, $semester->semester) == 0) echo 'selected'; ?>
		>Semester {{$semester->semester}}</option>
	@endforeach
</select>
</h2>
@if (Auth::guest())
@else
<a href="/AddStudentForm">
   <button type="button" class="btn btn-primary btn-sm" style="margin: 10px;">Add student</button>
</a>
<a href="/DeleteStudent">
   <button type="submit" class="btn btn-danger btn-sm"  value="Delete" name = "delete" style="margin: 10px;">Delete student</button>
</a>
@endif
<table class="table table-hover"  align="center">
	@if(strcmp($combobox, 'All semester') == 0)
		<tr>
			<th> </th>
			<th>Student ID</th>
			<th>Name</th> 
			<th>Age</th>
			@foreach($semesters as $semester)
			<th>Semester {{ $semester->semester}}</th>
			@endforeach
			<th>Average</th>
		</tr>
		@foreach ($student as $student)
		<tr>
			<th><input type="checkbox" name="{{ $student->id }}" value="checked"></th>
			@if (isset($_GET['{{ $student->id }}'])) {
			
			} 
			@endif
			
			<th>{{ $student->id }} </th>
			@if (Auth::guest())
			<th><a>{{ $student->name }}</a></th>
			@else
			<th><a href="students/{{ $student->id }}/edit">{{ $student->name }}</a></th>
			@endif
			<th>{{ $student->age }}</th>
			<?php $grade = $student->grades; ?>
			@foreach($semesters as $semester)
			<th>@for ($i=0; $i < count($grade) ; $i++) 
					@if ($grade[$i]->semester_id == $semester->id)
						Math: {{ $grade[$i]->math }} <br>
						Chemistry: {{ $grade[$i]->chemistry }} <br>
						Physic: {{ $grade[$i]->physics }} <br>
						Average: {{ round (($grade[$i]->physics + $grade[$i]->math + $grade[$i]->chemistry)/3, 1)}}
					@endif
				@endfor</th>
			@endforeach
			<th>
			<?php $sum = 0;?>
			@for ($i=0; $i < count($grade) ; $i++)
				<?php $sum = $sum + ($grade[$i]->physics + $grade[$i]->math + $grade[$i]->chemistry)/3 ?>
			@endfor
			<?php if (count($grade) != 0) {
				$semesterNumber = count($grade);
			}else{
				$semesterNumber = 1;
			}
			echo round(($sum/$semesterNumber),1);?>
				
			</th>
		</tr>
		@endforeach
	@endif
	@for ($i=0; $i < count($semesters); $i++)
		@if(strcmp($semesters[$i]->semester, $combobox) == 0)
	<tr>
			<th> </th>
			<th>Student ID</th>
			<th>Name</th> 
			<th>Age</th>
			<th>Semester {{$semesters[$i]->semester}}</th>
		</tr>
		@foreach ($student as $student)
		<tr>
			<th><input type="checkbox" name="" value=""></th>
			<th>{{ $student->id }} </th>
			<th>{{ $student->name }}</th> 
			<th>{{ $student->age }}</th>
			<?php $grade = $student->grades; ?>
			<th>@for ($j=0; $j < count($grade) ; $j++) 
					@if ($grade[$j]->semester_id == $semesters[$i]->id)
						Math: {{ $grade[$j]->math }} <br>
						Chemistry: {{ $grade[$j]->chemistry }} <br>
						Physics: {{ $grade[$j]->physics }} <br>
						Average: {{ round (($grade[$j]->physics + $grade[$j]->math + $grade[$j]->chemistry)/3, 1)}}
					@endif
				@endfor</th>
		</tr>
		@endforeach
	@endif
	
	@endfor
	
</table>
</form>


<script type="text/javascript">
    
    var form = document.forms[1];
    $(form).find("button[value='Delete']").click(function() {
        form.operation = this.value;
        form.action = 'DeleteStudent' ;
        form.submit();
    });
</script>
@stop