<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\Semester;
use App\Grade;
use DB;

class SemesterController extends Controller
{
    public function newSemester(Request $request, $i)
	{
		$semesterNew = new Semester();

		$semester = $request->all()['semesterAdd'.$i];
		$startDate = $request->all()['startDateAdd'.$i];
		$endDate = $request->all()['endDateAdd'.$i];
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


		$semester = $request->all()['semesterAdd'.$i];
		for ($i=0; $i < count($semesters) ; $i++) { 
			if ($semesters[$i]->semester == $semester) {
				return true;
			}
		}
		return false;
	}
}
