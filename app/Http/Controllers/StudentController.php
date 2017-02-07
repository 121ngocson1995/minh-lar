<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

	public function Edit(Request $request)
	{
		$student_id = $request->all()['student_id'];

		$studentEdit = Student::with('grades')->find($student_id);

		$name = $request->all()['name'];
		$age = $request->all()['age'];

		$studentEdit->name = $name;
		$studentEdit->age = $age;
		$studentEdit->save();
		for ($i=0; $i < count($studentEdit->grades) ; $i++) { 
			$this->editGrade($request,$i, $studentEdit, $studentEdit->grades[$i]->semester_id);
		}
		if (!array_key_exists( 'semesterCount', $request->all())) {
			$msg = 'Student with student_id '.$student_id.' is edit success. ';
			return redirect('')->with( 'msg',$msg);
		}else{
			$semesterCount = $request->all()['semesterCount'];
			for ($i=1; $i <= $semesterCount; $i++) { 
				$semester_id = $this->newSemester($request,$i);
				$this->addGrade($request,$i, $studentEdit, $semester_id);
			}
			
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

		$studentNew->name = $name;
		$studentNew->age = $age;
		$studentNew->save();
		$studentLast = Student::all()->last();
		
		if (!array_key_exists( 'semesterCount', $request->all())) {
			$msg = 'Student added success. Your student_id is '.$studentLast->id;
			return redirect('')->with( 'msg',$msg);
		}

		
		$semesterCount = $request->all()['semesterCount'];
		for ($i=1; $i <= $semesterCount; $i++) { 
			if ($this->checkSemester($request, $i)) {
				$semester = $request->all()['semester'.$i];
				$semesterIdArray = Semester::where('semester', '=', $semester)->select('id')->get()->toArray();

				$semester_id = $semesterIdArray[0]['id'];
				$this->addGrade($request,$i, $studentLast, $semester_id);
			}else{
				$semester_id = $this->newSemester($request,$i);
				$this->addGrade($request,$i, $studentLast, $semester_id);
			}
		}
		$msg = 'Student added success. Your student_id is '.$studentLast->id;
		return redirect('')->with( 'msg',$msg);
	}

	public function addGrade(Request $request, $i, $studentLast, $semester_id)
	{
		$gradeNew = new Grade();
		$semester = $request->all()['semester'.$i];
		$math = $request->all()['semester'.$semester.'MathGrade'];
		$physics = $request->all()['semester'.$semester.'PhysicsGrade'];
		$chemistry = $request->all()['semester'.$semester.'ChemistryGrade'];

		$gradeNew->student_id = $studentLast->id;
		$gradeNew->semester_id = $semester_id;
		$gradeNew->math = $math;
		$gradeNew->physics = $physics;
		$gradeNew->chemistry = $chemistry;
		$gradeNew->save();
	}

	public function newSemester(Request $request, $i)
	{
		$semesterNew = new Semester();

		$semester = $request->all()['semester'.$i];
		$startDate = $request->all()['startDate'.$i];
		$endDate = $request->all()['endDate'.$i];

		$semesterNew->semester = $semester;
		$semesterNew->startDate = $startDate;
		$semesterNew->endDate = $endDate;

		$semesterNew->save();
		$semesterLast = Semester::all()->last();
		return $semesterLast->id;
	}

	public function checkSemester(Request $request, $i)
	{
		$semesters = Semester::all();
		$semesters->toArray();


		$semester = $request->all()['semester'.$i];
		for ($i=0; $i < count($semesters) ; $i++) { 
			if ($semesters[$i]->semester == $semester) {
				return true;
			}
		}
		return false;
	}

	public function editGrade(Request $request, $i, $studentEdit, $semester_id)
	{
		$gradeEdit = $studentEdit->grades[$i];
		$semester = $gradeEdit->semester->semester;
		$math = $request->all()['math'.$gradeEdit->semester->semester];

		$physics = $request->all()['chemistry'.$gradeEdit->semester->semester];
		$chemistry = $request->all()['physics'.$gradeEdit->semester->semester];

		$gradeEdit->student_id = $studentEdit->id;
		$gradeEdit->semester_id = $semester_id;
		$gradeEdit->math = $math;
		$gradeEdit->physics = $physics;
		$gradeEdit->chemistry = $chemistry;
		$gradeEdit->save();
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
		
		return redirect('');
	}

}
