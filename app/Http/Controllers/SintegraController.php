<?php
namespace VmbTest\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use VmbTest\Http\Requests;
use VmbTest\Http\Controllers\Controller;
use VmbTest\Http\Requests\SintegraRequest;
use VmbTest\Repositories\SintegraRepository;
use VmbTest\Repositories\UserRepository;
use VmbTest\Services\ParseService;
use VmbTest\Services\SintegraService;

class SintegraController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var SintegraRepository
     */
    private $sintegraRepository;
    /**
     * @var SintegraService
     */
    private $service;
    /**
     * @var ParseService
     */
    private $parseService;

    /**
     * SintegraController constructor.
     * @param UserRepository $userRepository
     * @param SintegraRepository $sintegraRepository
     * @param SintegraService $service
     * @param ParseService $parseService
     * @internal param UserRepository $repository
     */
    public function __construct(
        UserRepository $userRepository,
        SintegraRepository $sintegraRepository,
        SintegraService $service,
        ParseService $parseService
    )
    {
        $this->userRepository = $userRepository;
        $this->sintegraRepository = $sintegraRepository;
        $this->service = $service;
        $this->parseService = $parseService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $userId = $this->userRepository->find(Auth::user()->id)->id;
        $sintegras = $this->sintegraRepository->scopeQuery(function ($query) use ($userId) {
            return $query->where('user_id', '=', $userId);
        })->paginate();

        return view('sintegra.index', compact('sintegras'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function consulta()
    {
        return view('sintegra.consulta');
    }

    /**
     * @param SintegraRequest $request
     * @return mixed|string
     */
    public function sintegraRequest(SintegraRequest $request)
    {
        try {
            $result = $this->service->sintegraRequest($request->get('cnpj'));
            return $this->parseService->resultParse($result);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param SintegraRequest $request
     * @return mixed|string
     */
    public function store(SintegraRequest $request)
    {
        try {
            $result = $this->service->sintegraRequest($request->get('cnpj'));
            $parsed = $this->parseService->resultParse($result);
            $filtered = $this->parseService->resultParsedFilter($parsed);
            $json = $this->parseService->toJson($filtered);

            $data = array(
                'cnpj' => $request->get('cnpj'),
                'resultado_json' => $json,
                'user_id' => $this->userRepository->find(Auth::user()->id)->id
            );

            return $this->service->store($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
