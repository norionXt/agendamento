<?php


class Agendamento {

    function __construct() {}

    private function validcomando(Agenda $agenda) {
        try {
            if ($agenda->comando == '') {
                throw new Exception('Comando está vazio');
            } else {
                return true;
            }
        } catch (Exception $e) {
            echo "Erro capturado: ". $e->getMessage(). "\n";
            return false;
        }
    }

    function agendar(Agenda $agenda): bool {
        $output = shell_exec("crontab -l");
        $output = $output? $this->removerLinhaVazia($output): '';
        $comando = $agenda->minutos.' '.$agenda->horas.' '. $agenda->dias.' '.$agenda->mes.' '. $agenda->diaSemana.' ';
        if ( !$this->validcomando($agenda) ) {
            return false;
        }
        $comando .= $agenda->comando;
        $comando .= '#id'. sha1(count(explode("\n", $output))+1); 
        $final = $output.$comando;
        shell_exec('echo  "'.$final.'" > /tmp/crontab.txt');
        shell_exec("crontab /tmp/crontab.txt");
        return true;
    }

    private function removerLinhaVazia($texto) {
        $resultado = '';
        foreach (explode("\n", $texto) as $key => $value) {
            if ( $value != "") {
                $resultado .= $value."\n";
            }
        }
        return $resultado;
    }

    function remover($id): bool {
        $output = $this->listar();
        if ( $output == '' ) {
            return false;
        }
        $linha = explode("\n",$output);
        $final = '';
        foreach ($linha as $key => $value) {
            if ( !stripos($value, '#id'.$id ) ) {
                if ( $value != '') {
                    $final .= $value."\n";
                }
            }    
        }

        $final = substr($final,0, -1);
        shell_exec('echo "'. $final.'" > /tmp/crontab.txt');
        shell_exec("crontab /tmp/crontab.txt");
        return true;
    }

    function listar(): string {
        return shell_exec('crontab -l')?: '';
    }


    function atualizar(Agenda $agenda): bool {
        $output = shell_exec("crontab -l");
        $output = $output?: '';
        $final = '';
        $achou = false;
        foreach (explode("\n", $output) as $key => $value) {
            if ( stripos($value, " #id$agenda->id" ) ) {
                $achou = true;
                $final .= "$agenda->minutos $agenda->horas $agenda->dias $agenda->mes $agenda->diaSemana $agenda->comando #id$agenda->id \n";
            } else {
                if ( $value != '') {
                    $final .= $value. PHP_EOL;
                }
            }
        }
        if ( !$achou ) return $achou;

        $final = substr($final,0, -1);
        shell_exec('echo "'.$final.'" > /tmp/crontab.txt');
        shell_exec("crontab /tmp/crontab.txt");
        return $achou;
    }

}
