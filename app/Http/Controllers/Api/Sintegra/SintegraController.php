<?php
namespace VmbTest\Http\Controllers\Api\Sintegra;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use VmbTest\Http\Controllers\Controller;
use VmbTest\Http\Requests\SintegraRequest;
use VmbTest\Repositories\SintegraRepository;
use VmbTest\Repositories\UserRepository;
use VmbTest\Services\ParseService;
use VmbTest\Services\SintegraService;

class SintegraController extends Controller
{
    /**
     * @var SintegraRepository
     */
    private $sintegraRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
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
     * @param SintegraRepository $sintegraRepository
     * @param UserRepository $userRepository
     * @param SintegraService $service
     * @param ParseService $parseService
     */
    public function __construct(
        SintegraRepository $sintegraRepository,
        UserRepository $userRepository,
        SintegraService $service,
        ParseService $parseService
    )
    {
        $this->sintegraRepository = $sintegraRepository;
        $this->userRepository = $userRepository;
        $this->service = $service;
        $this->parseService = $parseService;
    }

    public function index()
    {
        $userId = Authorizer::GetResourceOwnerId();
        $sintegras = $this->sintegraRepository->scopeQuery(function ($query) use ($userId) {
            return $query->where('user_id', '=', $userId);
        })->paginate();

        return $sintegras;
    }

    public function show($id)
    {
        $userId = Authorizer::GetResourceOwnerId();
        if (!$id) {
            $sintegras = $this->sintegraRepository->scopeQuery(function ($query) use ($userId) {
                return $query->where('user_id', '=', $userId);
            })->paginate();

            return $sintegras;
        }
        $sintegra = $this->sintegraRepository->find($id);
        if ($sintegra->user->id == $userId) {
            return $sintegra;
        }
    }

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
                'user_id' => Authorizer::GetResourceOwnerId()
            );

            return $this->service->store($data);
        } catch (\Exception $e) {
            return response()->json(array('messages' => $e->getMessage()), 400);
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $sintegra = $this->sintegraRepository->find($id);
            if ($sintegra) {
                $this->sintegraRepository->delete($id);
                return $sintegra;
            }
        }
    }
}