<?php

namespace Service\Helpers;

class DynamicTable {

    /**
     * [tableGenerate description]
     * @return [string] retorna o html da tabela montada   
     * @param [$tableArray] [array] O valor é o padrão do retorno da função pg_fetch_all
     * @param [$tableLabels] [array] A key do array é o nome do campo e a value é como vai ficar o nome na tabela
     * @param [$tableAction] [array] Ações de edição dos registros
     * @param [$tableStyles] [array] Definição de style para tr, td e table
     * @param [$tableClass] [array] Definição de class para tr, td e table
     * */
    public $tableArray = null,
            $tableLabels = null,
            $tableAction = null,
            $tableClass = null,
            $tableAttr = null,
            $tableId = null,
            $tableMessages = null,
            $tableHidden = null,
            $tableAdd = null;

    private function valueFormat($valueData = null, $key = null) {
        $arrayType = NULL;
        $arrayType = $this->arrayType;
        $valueReturn = $valueData;
        if (!empty($arrayType)) {
            foreach ($arrayType as $keyType => $valueType) {
                if ($key == $keyType) {
                    foreach ($valueType as $keyDataType => $valueDataType) {
                        if ($keyDataType == "boolean") {
                            if ($valueData == 't') {
                                $valueReturn = $valueDataType["true"];
                            }
                            if ($valueData == 'f') {
                                $valueReturn = $valueDataType["false"];
                            }
                        }
                        if ($keyDataType == "format") {
                            $valueReturn = $valueDataType["after"] . $valueReturn . $valueDataType["before"];
                        }
                        if ($keyDataType == "custom") {
                            $valueReturn = $valueDataType[$valueReturn];
                        }
                    }
                }
            }
        }

        return $valueReturn;
    }

    public function tableGenerate() {

        $Array = null;
        $labels = null;
        $attr = null;
        $styles = null;
        $class = null;
        $messages = null;
        $countArray = null;
        $keyArray = null;
        $hidden = null;
        $tableId = null;

        $hidden = $this->tableHidden;
        $attr = $this->tableAttr;
        $Array = $this->tableArray;
        $labels = $this->tableLabels;
        $action = $this->tableAction;
        $class = $this->tableClass;
        $messages = $this->tableMessages;
        $tableId = $this->tableId;

        $messages['no_data']['title'] = (empty($messages['no_data']['title'])) ? "Aviso!" : $messages['no_data']['title'];
        $messages['no_data']['text'] = (empty($messages['no_data']['text'])) ? "Não existem registros!" : $messages['no_data']['text'];
        $class["table"] = (empty($class["table"])) ? "table  table-striped  table-bordered  table-hover" : $class["table"];
        $tableId['tableId'] = (empty($tableId['tableId'])) ? "myTable" : $tableId['tableId'];

        $returnTable = NULL;

        $qtArray = count($Array);

        if(!isset($_POST['search'])) {
            $searchData = '';
        } else {
            $searchData = $_POST['search'];
        }
        
        if (!empty($searchData) && $attr['search'] == true) {
            $returnTable .= '
                            <div class="alert alert-info" id="tableGenerateError">
                            Resposta para a busca de: <strong>' . $searchData . '</strong>
                            </div>
                            <table align="center" class="table  table-striped  table-bordered  table-hover" id="tasksTable" style="display:none;">
<thead><tr><th></th><th>  </th></tr></thead><tbody></tbody></table>
                        ';
        }

        if (empty($Array[0])) {
            $returnTable .= '
                            <div class="alert alert-block" id="tableGenerateError">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <h4>' . $messages['no_data']['title'] . '</h4>
                            ' . $messages['no_data']['text'] . '
                            </div>
                            <table align="center" class="table  table-striped  table-bordered  table-hover" id="tasksTable" style="display:none;">
<thead><tr><th></th><th>  </th></tr></thead><tbody></tbody></table>
                        ';
            return $returnTable;
        }

        $returnTable .= "<table align=\"center\" class=\"" . $class["table"] . "\" id=\"" . $tableId['tableId'] . "\">";
        $returnTable .= "<thead>";
        $returnTable .= "<tr>";
        if ($action['start'] == TRUE) {
            if (!empty($action['checkbox'])) {
                $returnTable .= "<th></th>";
            }
        }
        foreach ($Array[0] as $key => $value) {
            $showRow = TRUE;
            $keyLabels = $key;
            if (!empty($labels)) {
                foreach ($labels as $labelsKey => $labelsValue) {
                    if ($key == $labelsKey) {
                        $keyLabels = ($key == $labelsKey) ? $labelsValue : $key;
                        break;
                    }
                }
            }

            if (!empty($hidden)) {
                foreach ($hidden as $valueHidden) {
                    if ($key == $valueHidden) {
                        $showRow = FALSE;
                    }
                }
            }

            if (empty($countArray) && $showRow == TRUE) {
                $returnTable .= "<th>" . $keyLabels . "</th>";
            }
        }
        if ($action['start'] == TRUE && (!empty($action['edit']) || !empty($action['deleted']))) {
            $returnTable .= "<th>Ações</th>";
        }
        $returnTable .= "</tr>";
        $returnTable .= "</thead>";
        for ($countArray = 0; $qtArray > $countArray; $countArray++) {

            if ($labels) {
                foreach ($labels as $key => $value) {
                    if ($value == 'key') {
                        $keyArray = $Array[$countArray][$key];
                        break;
                    }
                }
            }


            $returnTable .= "<tr id=\"" . $keyArray . "\">";
            if ($action['start'] == TRUE) {
                if (!empty($action['checkbox'])) {

                    $requiredArrayActionCheckbox = array(
                        'id',
                        'class',
                        'name',
                        'value'
                    );

                    foreach ($requiredArrayActionCheckbox as $value) {
                        if (empty($action['checkbox'][$value])) {
                            $action['checkbox'][$value] = null;
                        }
                    }

                    $classCheckbox = str_replace("|key|", $keyArray, $action['checkbox']['class']);
                    $idCheckbox = str_replace("|key|", $keyArray, $action['checkbox']['id']);
                    $nameCheckbox = str_replace("|key|", $keyArray, $action['checkbox']['name']);
                    $valueCheckbox = str_replace("|key|", $keyArray, $action['checkbox']['value']);

                    $returnTable .= "
                    <td style=\"width:15px;\">
                        <input type=\"checkbox\" name=\"" . $nameCheckbox . "\" value=\"" . $valueCheckbox . "\" id=\"" . $idCheckbox . "\" class=\"" . $classCheckbox . "\" />
                    </td>
                    ";
                }
            }
            foreach ($Array[$countArray] as $key => $value) {
                $showRow = TRUE;

                if (!empty($hidden)) {
                    foreach ($hidden as $valueHidden) {
                        if ($key == $valueHidden) {
                            $showRow = FALSE;
                        }
                    }
                }

                if ($showRow == TRUE) {
                    $returnTable .= "<td>" . $value . "</td>";
                }
            }
            if ($action['start'] == TRUE) {
                $deletedCod = null;
                $editCod = null;

                $requiredArrayAction = array(
                    'id',
                    'class',
                    'link'
                );

                if (!empty($action['deleted']) || !empty($action['edit'])) {
                    foreach ($requiredArrayAction as $value) {
                        if (empty($action['edit'][$value]) && !empty($action['edit'])) {
                            $action['edit'][$value] = null;
                        }
                        if (empty($action['deleted'][$value]) && !empty($action['deleted'])) {
                            $action['deleted'][$value] = null;
                        }
                    }
                }
                if (!empty($action['edit'])) {

                    $linkEdit = str_replace("|key|", $keyArray, $action['edit']['link']);
                    $idEdit = str_replace("|key|", $keyArray, $action['edit']['id']);
                    $classEdit = str_replace("|key|", $keyArray, $action['edit']['class']);
                    $dataToogle = (empty($action['edit']['dataToogle'])) ? null : $action['edit']['dataToogle'];

                    $editCod .= "<a class=\"" . $classEdit . "\" id=\"" . $idEdit . "\" href=\"" . $linkEdit . "\" data-toggle=\"" . $dataToogle . "\"><i class=\"icon-edit\"></i></a>";
                }
                if (!empty($action['deleted'])) {

                    $classDeleted = str_replace("|key|", $keyArray, $action['deleted']['class']);
                    $linkDeleted = str_replace("|key|", $keyArray, $action['deleted']['link']);
                    $idDeleted = str_replace("|key|", $keyArray, $action['deleted']['id']);
                    $dataToogle = (empty($action['deleted']['dataToogle'])) ? null : $action['deleted']['dataToogle'];

                    $deletedCod .= "<a class=\"" . $classDeleted . "\" id=\"" . $idDeleted . "\" href=\"" . $linkDeleted . "\"  data-toggle=\"" . $dataToogle . "\"><i class=\"icon-trash\"></i></a>";
                }
                if (!empty($action['deleted']) || !empty($action['edit'])) {
                    $returnTable .= "
                    <td style=\"width:110px;\"> 
                        " . $editCod . "
                        " . $deletedCod . "
                    </td>";
                }
            }
            $returnTable .= "</tr>";
        }


        $returnTable .= "</table>";

        if (!empty($attr)) {

            $pagNumber = NULL;

            for ($countPag = 1; $countPag <= $attr['pages']; $countPag++) {
                $dataGet = $_GET;
                $getData = null;
                foreach ($dataGet as $keyGet => $valueGet) {
                    if ($keyGet != 'page' && $keyGet != 'msgType') {
                        $getData .= $keyGet . "=" . $valueGet . "&";
                    }
                }
                if ($attr['currentPage'] == $countPag) {
                    $classPage = "active";
                } else {
                    $classPage = null;
                }
                $pagNumber .= "<li class=\"" . $classPage . "\"><a href=\"?page=" . $countPag . "&" . $getData . "\">" . $countPag . "</a></li>";
            }

            $nextButton = ($attr['currentPage'] + 1);

            $previousButton = ($attr['currentPage'] - 1);

            if ($attr['currentPage'] == 1) {
                $previousClass = "disabled";
                $previousGet = "javascript:void(0);";
            } else {
                $dataGet = $_GET;
                $getData = null;

                foreach ($dataGet as $keyGet => $valueGet) {
                    if ($keyGet != 'page' && $keyGet != 'msgType') {
                        $getData .= $keyGet . "=" . $valueGet . "&";
                    }
                }
                $previousGet = "?page=" . $previousButton . "&" . $getData;
                $previousClass = null;
            }
            if ($attr['currentPage'] == $attr['pages']) {
                $nextClass = "disabled";
                $nextGet = "javascript:void(0);";
            } else {
                $nextClass = null;
                $dataGet = $_GET;
                $getData = null;
                foreach ($dataGet as $keyGet => $valueGet) {
                    if ($keyGet != 'page' && $keyGet != 'msgType') {
                        $getData .= $keyGet . "=" . $valueGet . "&";
                    }
                }
                $nextGet = "?page=" . $nextButton . "&" . $getData;
            }

            $returnTable .= "
        <div class=\"pagination  pagination-centered\">
            <ul>
              <li class=\"" . $previousClass . "\"><a href=\"" . $previousGet . "\">&larr;</a></li>
              " . $pagNumber . "
              <li class=\"" . $nextClass . "\"><a href=\"" . $nextGet . "\">&rarr;</a></li>
            </ul>
        </div>";
        }
    
        
        return $returnTable;
    }

}
