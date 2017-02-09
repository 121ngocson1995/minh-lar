<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\GradeController;
use App\Student;
use App\Semester;
use App\Grade;
use DB;
class StudentController extends Controller
{
	
	public function show(Request $request)
	{
		$combobox;
		$isCombobox = array_key_exists( 'combobox', $request->all());
		if ($isCombobox) {
			$combobox = $request->all()['combobox'];
		}else{
			$combobox = 'All semester';
		}

		$semesters = Semester::all()->sortBy("semester");
		$student = Student::with('grades')->get();

		return view('show', compact(['student', 'combobox', 'semesters']));
		

	}

	public function preEdit($student)
	{
		$studentEdit = Student::with('grades')->where('id', '=', $student)->get();
		$semesters = Semester::all();
		return view('editStudent', compact(['studentEdit', 'semesters']));
	}

	public function edit(Request $request)
	{
		$student_id = $request->all()['student_id'];

		$studentEdit = Student::with('grades')->find($student_id);


		$name = $request->all()['name'];
		$age = $request->all()['age'];

		$semesterDelete = $request->all()['semesterDelete'];
		$semesterDelete = explode(",",$semesterDelete);

		$studentEdit->name = $name;
		$studentEdit->age = $age;
		$studentEdit->save();

		// for ($i=0; $i < count($studentEdit->grades) ; $i++) { 
		// 	for ($j=0; $j < count($semesterDelete) ; $j++) { 
		// 		if ($semesterDelete[$j] == $i) {
		// 			(new GradeController)->deleteGrade($i, $studentEdit, $studentEdit->grades[$semesterDelete[$j]]->semester_id);
		// 			continue;
		// 		}
		// 		(new GradeController)->editGrade($request,$i, $studentEdit, $studentEdit->grades[$i]->semester_id);
		// 	}
			
		// }



		for ($i=0; $i < count($studentEdit->grades) ; $i++) { 
			if (strcmp(trim($semesterDelete[0]), '') != 0) {
				for ($j=0; $j < count($semesterDelete) ; $j++) { 
					if ($semesterDelete[$j] == $i) {
						(new GradeController)->deleteGrade($i, $studentEdit, $studentEdit->grades[$semesterDelete[$j]]->semester_id);
					}
				}
			}
			(new GradeController)->editGrade($request,$i, $studentEdit, $studentEdit->grades[$i]->semester_id);
			
		}



		if (!array_key_exists( 'semesterCount', $request->all())) {
			$msg = 'Student with student_id '.$student_id.' is edit success. ';
			return redirect('')->with( 'msg',$msg);
		}else{
			$semesterCount = $request->all()['semesterCount'];
			for ($i=1; $i <= $semesterCount; $i++) { 
				if ((new SemesterController)->checkSemester($request, $i)) {
					$semester = $request->all()['semesterAdd'.$i];

					$semesterIdArray = Semester::where('semester', '=', $semester)->select('id')->get()->toArray();

					$semester_id = $semesterIdArray[0]['id'];
					(new GradeController)->addGrade($request,$i, $studentEdit, $semester_id);
				}else{
					$semester_id = (new SemesterController)->newSemester($request,$i);
					(new GradeController)->addGrade($request,$i, $studentEdit, $semester_id);
				}
			}
			
			$msg = 'Student with student_id '.$student_id.' is edit success. ';
			return redirect('')->with( 'msg',$msg);
		}

	}


	

	public function addForm()
	{
		$semesters = Semester::all();
		return view('addStudent', compact('semesters'));
	}

	public function add(Request $request)
	{
		$studentNew = new Student();
		$name = $request->all()['name'];
		$age = $request->all()['age'];

		// $studentNew->name = $name;
		// $studentNew->age = $age;
		// $studentNew->save();
		// $studentLast = Student::all()->last();

		$studentNew = [
			'name' => $name,
			'age' => $age
		];
		$studentLast = Student::create($studentNew);
		
		if (!array_key_exists( 'semesterCount', $request->all())) {
			$msg = 'Student added successfully. '.$studentLast->name.'\'s student ID is '.$studentLast->id;
			return redirect('')->with( 'msg',$msg);
		}

		
		$semesterCount = $request->all()['semesterCount'];
		for ($i=1; $i <= $semesterCount; $i++) { 
			if ((new SemesterController)->checkSemester($request, $i)) {
				$semester = $request->all()['semesterAdd'.$i];

				$semesterIdArray = Semester::where('semester', '=', $semester)->select('id')->get()->toArray();

				$semester_id = $semesterIdArray[0]['id'];
				(new GradeController)->addGrade($request,$i, $studentLast, $semester_id);
			}else{
				$semester_id = (new SemesterController)->newSemester($request,$i);
				(new GradeController)->addGrade($request,$i, $studentLast, $semester_id);
			}
		}
		$msg = 'Student added successfully. '.$studentLast->name.'\'s student ID is '.$studentLast->id;
		return redirect('')->with( 'msg',$msg);
	}

	

	public function delete(Request $request)
	{
		$toBeDeleted = array();
		foreach($request->all() as $key=>$val)
		{
			if (strcmp($val, 'checked') == 0) {
				$toBeDeleted[] = $key;
			}
		} 

		for ($i=0; $i < count($toBeDeleted); $i++) { 
			Student::where('id', $toBeDeleted[$i])->delete();
		}
		
		$msg = 'Delete successfully';
		return redirect('')->with( 'msg',$msg);
	}

}
