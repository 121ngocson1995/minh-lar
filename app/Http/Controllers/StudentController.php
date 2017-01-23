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
