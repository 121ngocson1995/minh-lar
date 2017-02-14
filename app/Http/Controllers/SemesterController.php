<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Semester;
use App\Grade;
use DB;

class SemesterController extends Controller
{
    public function newSemester(Request $request, $semesterNumber)
	{
		$semesterNew = new Semester();

		$semester = $request->all()['semesterAdd'.$semesterNumber];
		$startDate = $request->all()['startDateAdd'.$semesterNumber];
		$endDate = $request->all()['endDateAdd'.$semesterNumber];
		$semesterNew->semester = $semester;
		$semesterNew->startDate = $startDate;
		$semesterNew->endDate = $endDate;

		$semesterNew->save();
		$semesterLast = Semester::all()->last();
		return $semesterLast->id;
	}


	public function checkSemester(Request $request, $semesterNumber)
	{
		$semesters = Semester::all();
		$semesters->toArray();

		$semester = $request->all()['semesterAdd'.$semesterNumber];
		for ($i=0; $i < count($semesters) ; $i++) { 
			if ($semesters[$i]->semester == $semester) {
				return true;
			}
		}
		return false;
	}
}
