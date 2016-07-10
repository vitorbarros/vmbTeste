<?php
namespace VmbTest\Services;

use VmbTest\Repositories\SintegraRepository;

class SintegraService
{
    /**
     * @var SintegraRepository
     */
    private $repository;

    /**
     * SintegraService constructor.
     * @param SintegraRepository $repository
     */
    public function __construct(SintegraRepository $repository)
    {
        $this->repository = $repository;
    }

    public function store($data)
    {
        return $this->repository->create($data);
    }

    public function sintegraRequest($cnpj)
    {
        return $this->sintegraCurl($cnpj);
    }

    private function sintegraCurl($cnpj)
    {
        $cnpj = preg_replace('/[^0-9\_]/', '', $cnpj);
        $post = array('num_cnpj' => $cnpj, 'botao' => 'Consultar');

        $curl = curl_init('http://www.sintegra.es.gov.br/resultado.php');

        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0");
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, (is_array($post) ? http_build_query($post, '', '&') : $post));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HEADER, 1);

        try {
            $result = curl_exec($curl);
            curl_close($curl);
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}