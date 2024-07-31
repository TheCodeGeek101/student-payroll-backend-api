<?php
namespace App\Containers\SchoolsSection\Subjects\Controllers;

use App\Containers\SchoolsSection\Subjects\Actions\GetSubjectTutorsAction;
use App\Containers\SchoolsSection\Subjects\Actions\UpdateSubjectAction;
use App\Containers\SchoolsSection\Subjects\Data\Models\Subject;
use App\Containers\SchoolsSection\Subjects\Requests\UpdateSubjectRequest;
use App\Containers\UsersSection\Adminstrator\Data\Models\Admin;
use App\Http\Controllers\Controller;
use App\Containers\SchoolsSection\Subjects\Requests\StoreSubjectRequest;
use App\Containers\SchoolsSection\Subjects\Actions\CreateSubjectAction;
use Illuminate\Http\JsonResponse;
use App\Containers\SchoolsSection\Subjects\Resources\SubjectResource;
use App\Containers\SchoolsSection\Subjects\Actions\GetSubjectByClassAction;
use Illuminate\Http\Request;
use App\Containers\SchoolsSection\Subjects\Actions\AssignSubjectToTutor;
use App\Containers\UsersSection\Tutors\Actions\GetTutorSubjectsAction;
class SubjectsController extends Controller
{
    /**
     * Create a new subject.
     *
     * @param \App\Containers\SchoolsSection\Subjects\Requests\StoreSubjectRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $subjects = Subject::join('departments', 'departments.id', '=', 'subjects.department_id')
            ->select('subjects.*', 'departments.name as department_name')
            ->get();
        return response()->json(['subjects'=>$subjects],200);
    }

    public function show(Subject $subject): JsonResponse
    {
        $singleSubject = Subject::join('departments', 'departments.id', '=', 'subjects.department_id')
            ->where('subjects.id','=',$subject->id)
            ->select('subjects.*', 'departments.name as department_name')
            ->first();
        return response()->json($singleSubject,200);
    }

    public function create(StoreSubjectRequest $request): JsonResponse
    {
        // Call the CreateSubjectAction to handle the creation logic
        $subject = app(CreateSubjectAction::class)->run($request);

        // Return a JSON response with a success message and the created subject
        return response()->json([
            'message' => 'Subject created successfully',
            'subject' => $subject
        ],201);
    }

    public function update(UpdateSubjectRequest $request, Subject $subject): JsonResponse
    {
        $subject = app(UpdateSubjectAction::class)->run($request, $subject);
        return response()->json(['message' => 'Subject updated successfully','Subject'=>$subject],200);
    }

    public function delete(Subject $subject): JsonResponse
    {
        $subject->delete();
        return response()->json(['message' => 'Subject deleted successfully'],200);
    }

    public function assignSubjectToTutor(Request $request, Subject $subject, Admin $admin): JsonResponse
    {
        \Log::info('Admin Type: ' . get_class($admin));
        \Log::info('Subject Type: ' . get_class($subject));

        try {
            $result = app(AssignSubjectToTutor::class)->run($request, $admin, $subject);

            if ($result['status'] === 'success') {
                return response()->json(['message' => 'Subject assigned successfully', 'Subject' => $subject], 200);
            } else {
                return response()->json(['message' => $result['message']], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to assign subject to tutor: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to assign subject to tutor'], 500);
        }
    }

    public function getSubjectByClass(Request $request): JsonResponse
    {
        $subjects = app(GetSubjectByClassAction::class)->run($request);
        return response()->json(['Subjects'=>$subjects],200);
    }

    public function getSubjectTutors(): JsonResponse
    {
        $subjects = app(GetSubjectTutorsAction::class)->run();
        return response()->json(['message' => 'Data retrieved successfully','subjects'=>$subjects],200);
    }
}

