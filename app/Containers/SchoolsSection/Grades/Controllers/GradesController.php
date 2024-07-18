<?php

namespace App\Containers\SchoolsSection\Grades\Controllers;

use App\Http\Controllers\Controller;
use App\Containers\SchoolsSection\Grades\Requests\StoreGradesRequest;
use App\Containers\SchoolsSection\Grades\Requests\UpdateGradesRequest;
use App\Containers\SchoolsSection\Grades\Data\Models\Grades;
use App\Containers\SchoolsSection\Grades\Actions\CreateGradesAction;
use App\Containers\SchoolsSection\Grades\Actions\UpdateGradesAction;
use App\Containers\SchoolsSection\Grades\Resources\GradesResource;
use App\Containers\SchoolsSection\Grades\Actions\GetSubjectGrade;

class GradesController extends Controller
{
    public function index()
    {
        $grades = Grades::all();
        return response()->json(['grades'=>$grades],200);
    }
    public function store(StoreGradesRequest $request){
        $newGrade = app(CreateGradesAction::class)->run($request);
        return response()->json(['message'=>'Grade created successfully','grade'=>$newGrade],201);
    }
    public function show(Grades $grades){
        return response()->json(new GradesResource($grades),200);
    }
    public function update(UpdateGradesRequest $request, Grades $grades){
        $updateGrades = app(UpdateGradesAction::class)->run($request, $grades);
        return response()->json(['message'=>'Grade updated successfully','grade'=>$updateGrades],200);
    }
    public function destroy(Grades $grades){
        $grades->delete();
        return response()->json(['message'=>'Grade deleted successfully'],200);
    }

    public function getSubjectGrades(){
        $subjectGrade = app(GetSubjectGrade::class)->run();
        return response()->json(['grades'=>$subjectGrade],200);
    }
}
