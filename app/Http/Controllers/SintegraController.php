<?php
namespace VmbTest\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use VmbTest\Http\Requests;
use VmbTest\Http\Controllers\Controller;
use VmbTest\Repositories\SintegraRepository;
use VmbTest\Repositories\UserRepository;
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
     * SintegraController constructor.
     * @param UserRepository $userRepository
     * @param SintegraRepository $sintegraRepository
     * @param SintegraService $service
     * @internal param UserRepository $repository
     */
    public function __construct(
        UserRepository $userRepository,
        SintegraRepository $sintegraRepository,
        SintegraService $service
    )
    {
        $this->userRepository = $userRepository;
        $this->sintegraRepository = $sintegraRepository;
        $this->service = $service;
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
}
