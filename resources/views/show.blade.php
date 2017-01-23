@extends('layout')

@section('title')
<h1 style="font-size: 400%" align="center">All Students</h1>

@stop

@section('table')
<form action="ListByRequest" method="get">
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
<table class="table table-hover"  align="center">
	@if(strcmp($combobox, 'All semester') == 0)
		<tr>
			<th> </th>
			<th>Student ID</th>
			<th>Name</th> 
			<th>Age</th>
			<th>Semester 1</th>
			<th>Semester 2</th>
			<th>Semester 3</th>
			<th>Average</th>
		</tr>
		@foreach ($student as $student)
		<tr>
			<th><input type="checkbox" name="" value=""></th>
			<th>{{ $student->id }} </th>
			<th>{{ $student->name }}</th> 
			<th>{{ $student->age }}</th>
			<?php $grade = $student->grades; ?>
			<th>@for ($i=0; $i < count($grade) ; $i++) 
					@if ($grade[$i]->semester == 1)
						Math: {{ $grade[$i]->math }} <br>
						Chemistry: {{ $grade[$i]->chemistry }} <br>
						Physic: {{ $grade[$i]->physics }} <br>
						Average: {{ round (($grade[$i]->physics + $grade[$i]->math + $grade[$i]->chemistry)/3, 1)}}
					@endif
				@endfor</th>
			<th>@for ($i=0; $i < count($grade) ; $i++) 
				@if ($grade[$i]->semester == 2)
					Math: {{ $grade[$i]->math }} <br>
					Chemistry: {{ $grade[$i]->chemistry }} <br>
					Physic: {{ $grade[$i]->physics }} <br>
					Average: {{ round (($grade[$i]->physics + $grade[$i]->math + $grade[$i]->chemistry)/3, 1)}}
				@endif
			@endfor</th>
			<th>@for ($i=0; $i < count($grade) ; $i++) 
				@if ($grade[$i]->semester == 3)
					Math: {{ $grade[$i]->math }} <br>
					Chemistry: {{ $grade[$i]->chemistry }} <br>
					Physic: {{ $grade[$i]->physics }} <br>
					Average: {{ round (($grade[$i]->physics + $grade[$i]->math + $grade[$i]->chemistry)/3, 1)}}
				@endif
			@endfor</th>
			<th><?php $sum = 0;?>
			@for ($i=0; $i < count($grade) ; $i++)
				<?php $sum = $sum + ($grade[$i]->physics + $grade[$i]->math + $grade[$i]->chemistry)/3 ?>
			@endfor
			<?php echo round(($sum/count($grade)),1)?></th>
		</tr>
		@endforeach
	@endif
	@if(strcmp($combobox, '1') == 0)
	<tr>
			<th> </th>
			<th>Student ID</th>
			<th>Name</th> 
			<th>Age</th>
			<th>Semester 1</th>
		</tr>
		@foreach ($student as $student)
		<tr>
			<th><input type="checkbox" name="" value=""></th>
			<th>{{ $student->id }} </th>
			<th>{{ $student->name }}</th> 
			<th>{{ $student->age }}</th>
			<?php $grade = $student->grades; ?>
			<th>@for ($i=0; $i < count($grade) ; $i++) 
					@if ($grade[$i]->semester == 1)
						Math: {{ $grade[$i]->math }} <br>
						Chemistry: {{ $grade[$i]->chemistry }} <br>
						Physic: {{ $grade[$i]->physics }} <br>
						Average: {{ round (($grade[$i]->physics + $grade[$i]->math + $grade[$i]->chemistry)/3, 1)}}
					@endif
				@endfor</th>
		</tr>
		@endforeach
	@endif
	@if(strcmp($combobox, '2') == 0)
	<tr>
			<th> </th>
			<th>Student ID</th>
			<th>Name</th> 
			<th>Age</th>
			<th>Semester 2</th>
		</tr>
		@foreach ($student as $student)
		<tr>
			<th><input type="checkbox" name="" value=""></th>
			<th>{{ $student->id }} </th>
			<th>{{ $student->name }}</th> 
			<th>{{ $student->age }}</th>
			<?php $grade = $student->grades; ?>
			<th>@for ($i=0; $i < count($grade) ; $i++) 
					@if ($grade[$i]->semester == 2)
						Math: {{ $grade[$i]->math }} <br>
						Chemistry: {{ $grade[$i]->chemistry }} <br>
						Physic: {{ $grade[$i]->physics }} <br>
						Average: {{ round (($grade[$i]->physics + $grade[$i]->math + $grade[$i]->chemistry)/3, 1)}}
					@endif
				@endfor</th>
					</tr>
		@endforeach
	@endif
	@if(strcmp($combobox, '3') == 0)
	<tr>
			<th> </th>
			<th>Student ID</th>
			<th>Name</th> 
			<th>Age</th>
			<th>Semester 3</th>
	</tr>
		@foreach ($student as $student)
		<tr>
			<th><input type="checkbox" name="" value=""></th>
			<th>{{ $student->id }} </th>
			<th>{{ $student->name }}</th> 
			<th>{{ $student->age }}</th>
			<?php $grade = $student->grades; ?>
			<th>@for ($i=0; $i < count($grade) ; $i++) 
					@if ($grade[$i]->semester == 3)
						Math: {{ $grade[$i]->math }} <br>
						Chemistry: {{ $grade[$i]->chemistry }} <br>
						Physic: {{ $grade[$i]->physics }} <br>
						Average: {{ round (($grade[$i]->physics + $grade[$i]->math + $grade[$i]->chemistry)/3, 1)}}
					@endif
				@endfor</th>
					</tr>
		@endforeach
	@endif
</table>
</form>
@stop

