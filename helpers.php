<?php

if (!function_exists('Meses_Do_Ano')) {
    function Meses_Do_Ano() {
        $meses = [];
        for ($i = 1; $i < 13; $i++) {
            $mes = str_pad($i, 2, '0', STR_PAD_LEFT); // Usando str_pad em vez de Preenche_Texto
            $meses[$mes] = Nome_Do_Mes($mes);
        }
        return $meses;
    }
}

if (!function_exists('Nome_Do_Mes')) {
    function Nome_Do_Mes($mes) {
        switch ($mes) {
            case '01': return 'Janeiro';
            case '02': return 'Fevereiro';
            case '03': return 'Março';
            case '04': return 'Abril';
            case '05': return 'Maio';
            case '06': return 'Junho';
            case '07': return 'Julho';
            case '08': return 'Agosto';
            case '09': return 'Setembro';
            case '10': return 'Outubro';
            case '11': return 'Novembro';
            case '12': return 'Dezembro';
            default: return 'Mês Inválido';
        }
    }
}
