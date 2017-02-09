<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Semester;
use App\Grade;
use DB;

class GradeController extends Controller
{
    public function addGrade(Request $request, $i, $studentLast, $semester_id)
	{
		$gradeNew = new Grade();
		$semester = $request->all()['semesterAdd'.$i];
		$math = $request->all()['semesterAdd'.$semester.'MathGrade'];
		$physics = $request->all()['semesterAdd'.$semester.'PhysicsGrade'];
		$chemistry = $request->all()['semesterAdd'.$semester.'ChemistryGrade'];
		$gradeNew->student_id = $studentLast->id;
		$gradeNew->semester_id = $semester_id;
		$gradeNew->math = $math;
		$gradeNew->physics = $physics;
		$gradeNew->chemistry = $chemistry;
		$gradeNew->save();
	}

	public function deleteGrade($i, $studentEdit, $semester_id)
	{	
		$deleteGrade = Grade::where('student_id',$studentEdit->id)->where('semester_id', $semester_id)->delete();
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
}
