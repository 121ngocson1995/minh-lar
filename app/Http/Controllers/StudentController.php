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
		if (array_key_exists( 'optionAdd', $request->all())) {
			$semesters = Semester::all();
			return view('addStudent', compact('semesters'));
		}else{
			$combobox;
			$isCombobox = array_key_exists( 'combobox', $request->all());
			if ($isCombobox) {
				$combobox = $request->all()['combobox'];
			}else{
				$combobox = 'All semester';
			}

			$semesters = Semester::all();
			$student = Student::with('grades')->get();

			return view('show', compact(['student', 'combobox', 'semesters']));
		}
		
	}

	public function edit()
	{
		return view('editStudent');
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

		$semesterCount = $request->all()['semesterCount'];
		for ($i=1; $i <= $semesterCount; $i++) { 
			if ($this->checkSemester($request, $i)) {
				$this->addGrade($request,$i, $studentLast);
			}else{
				$this->addSemester($request,$i);
				$this->addGrade($request,$i, $studentLast);
			}
		}
		return redirect('');
	}

	public function addGrade(Request $request, $i, $studentLast)
	{
		$gradeNew = new Grade();

		$semester = $request->all()['semester'.$i];
		$math = $request->all()['semester'.$semester.'MathGrade'];
		$physics = $request->all()['semester'.$semester.'PhysicsGrade'];
		$chemistry = $request->all()['semester'.$semester.'ChemistryGrade'];

		$gradeNew->student_id = $studentLast->id;
		$gradeNew->semester_id = $semester;
		$gradeNew->math = $math;
		$gradeNew->physics = $physics;
		$gradeNew->chemistry = $chemistry;
		$gradeNew->save();
	}

	public function addSemester(Request $request, $i)
	{
		$semesterNew = new Semester();

		$semester = $request->all()['semester'.$i];
		$startDate = $request->all()['startDate'.$i];
		$endDate = $request->all()['endDate'.$i];

		$semesterNew->semester = $semester;
		$semesterNew->startDate = $startDate;
		$semesterNew->endDate = $endDate;

		$semesterNew->save();
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

}
