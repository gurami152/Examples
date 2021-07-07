<?php

namespace App\Http\Controllers;


use App\FormOfEducation;
use App\Repositories\FormOfEducationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FormOfEducationController extends Controller
{

    private $formOfEducationRepository;

    /**
     * FormOfEducationController constructor.
     * @param $formOfEducationRepository
     */
    public function __construct(FormOfEducationRepository $formOfEducationRepository)
    {
        $this->formOfEducationRepository = $formOfEducationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        if (!$request->has('size')) {
            $allForms = $this->formOfEducationRepository->all();
        } else {
            $allForms = $this->formOfEducationRepository->paginated($request->size);
        }

        return response()->json($allForms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        FormOfEducation::create([
            'name' => $request->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $formOfEducation = FormOfEducation::findOrFail($id);
        $formOfEducation->name = $request->name;
        $formOfEducation->save();
        return response(null, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->formOfEducationRepository->delete($id);
    }
}
