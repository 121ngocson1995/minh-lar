<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Semester;
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

	public function add(Request $request)
	{
		$semesterCount = $request->all()['semesterCount'];
		for ($i=1; $i <= semesterCount; $i++) { 
			$semester = $i;
			$math = $request->all()['semester'+$i+'MathGrade'];

		}
		$semesters = Semester::all();
		$student = Student::with('grades')->get();

		return view('show', compact(['student', 'combobox', 'semesters']));
	}
}
