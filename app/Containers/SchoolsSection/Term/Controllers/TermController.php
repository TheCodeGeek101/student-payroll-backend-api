<?php

namespace App\Containers\SchoolsSection\Term\Controllers;

use App\Containers\SchoolsSection\Term\Data\Models\Term;
use App\Http\Controllers\Controller;
use App\Containers\SchoolsSection\Term\Requests\StoreTermRequest;
use App\Containers\SchoolsSection\Term\Requests\UpdateTermRequest;
use App\Containers\SchoolsSection\Term\Actions\UpdateTermAction;
use App\Containers\SchoolsSection\Term\Actions\CreateTermAction;
use Illuminate\Http\JsonResponse;

class TermController extends Controller
{
    public function index():JsonResponse
    {
        $terms = Term::all();
        return response()->json(['terms' => $terms], 200);
    }

    public function store(StoreTermRequest $request):JsonResponse
    {
        $term = app(CreateTermAction::class)->execute($request);
        return response()->json(['term' => $term], 201);
    }
    public function show(Term $term):JsonResponse
    {
        return response()->json(['term' => $term], 200);
    }
    public function update(UpdateTermRequest $request, Term $term):JsonResponse
    {
        $updatedTerm = app(UpdateTermAction::class)->execute($request, $term);
        return response()->json(['term' => $updatedTerm], 200);
    }
    public function destroy(Term $term):JsonResponse
    {
        $term->delete();
        return response()->json(['term' => $term], 200);
    }
}
