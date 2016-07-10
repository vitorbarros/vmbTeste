<?php
namespace VmbTest\Services;

class ParseService
{
    /**
     * @param $result
     * @return array
     */
    public function resultParse($result)
    {
        $matches = array();
        $filteredMatches = array();

        $re = '#<\s*?table\b[^>]*>(.*?)</table\b[^>]*>#s';
        preg_match_all($re, $result, $matches);

        foreach ($matches as $match) {
            foreach ($match as $item) {
                $filteredMatches[] = trim(str_replace("-->", "", utf8_encode($item)));
            }
        }

        return $filteredMatches;
    }

    /**
     * @param array $result
     * @return array
     */
    public function resultParsedFilter(array $result)
    {
        $string = implode("", $result);
        $noTags = trim(strip_tags($string));
        $filterData = explode(":", $noTags);

        $toArray = array();
        $filter = array();

        foreach ($filterData as $item) {
            $toArray[] = explode("\n", $item);
        }

        foreach ($toArray as $firstIndex) {
            foreach ($firstIndex as $value) {
                if (trim($value) != null) {
                    $filter[] = trim($value);
                }
            }
        }
        return $filter;
    }

    /**
     * @param array $result
     * @return string
     */
    public function toJson(array $result)
    {
        $arrayResult = array();
        foreach ($result as $key => $value) {

            $newString =
                str_replace(";", "",
                    str_replace("&nbsp", "",
                        str_replace("&nbsp;", "",
                            str_replace(" ", "_", strtolower(preg_replace(array(
                                "/(ç|Ç)/",
                                "/(á|à|ã|â|ä)/",
                                "/(Á|À|Ã|Â|Ä)/",
                                "/(é|è|ê|ë)/",
                                "/(É|È|Ê|Ë)/",
                                "/(í|ì|î|ï)/",
                                "/(Í|Ì|Î|Ï)/",
                                "/(ó|ò|õ|ô|ö)/",
                                "/(Ó|Ò|Õ|Ô|Ö)/",
                                "/(ú|ù|û|ü)/",
                                "/(Ú|Ù|Û|Ü)/",
                                "/(ñ)/",
                                "/(Ñ)/"
                            ), explode(' ', "c a A e E i I o O u U n N"), $value))))));

            switch ($newString) {
                case "cadastro_atualizado_ate" :
                    $arrayResult['dados_gerais']['data_cadastro'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
                case "cnpj" :
                    $arrayResult['dados_gerais']['cnpj'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
                case "inscricao_estadual" :
                    $arrayResult['dados_gerais']['inscricao_estadual'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
                case "razao_social" :
                    $arrayResult['dados_gerais']['razao_social'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
                case "logradouro" :
                    $arrayResult['endereco']['logradouro'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
                case "numero" :
                    $arrayResult['endereco']['numero'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
                case "complemento" :
                    $arrayResult['endereco']['complemento'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
                case "bairro" :
                    $arrayResult['endereco']['bairro'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
                case "municipio" :
                    $arrayResult['endereco']['municipio'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
                case "uf" :
                    $arrayResult['endereco']['uf'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
                case "cep" :
                    $arrayResult['endereco']['cep'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
                case "telefone" :
                    $arrayResult['dados_gerais']['telefone'] = str_replace("&nbsp;", "", $result[$key + 1]);
                    break;
            }
        }
        return json_encode($arrayResult);
    }
}