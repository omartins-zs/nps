<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class TestConnectionController extends Controller
{
    public function testConnection()
    {
        try {
            // Substitua 'nome_da_tabela' pelo nome da tabela que você deseja testar.
            $result = DB::table('notas')->limit(4)->get();

            return response()->json([
                'status' => 'Conexão bem-sucedida',
                'data' => $result,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Erro de conexão',
                'message' => $e->getMessage(),
            ]);
        }
    }
    public function testConnectionMysql()
    {
        try {
            // Tente obter alguns registros da tabela 'notas'
            $result = DB::table('notas')->limit(4)->get();

            return response()->json([
                'status' => 'Conexão bem-sucedida',
                'data' => $result,
            ]);
        } catch (Exception $e) {
            // Registra o erro no log
            Log::error("Erro de conexão com o banco de dados: " . $e->getMessage());

            return response()->json([
                'status' => 'Erro de conexão',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getDataFromFirebird()
    {

        $this->clearLogs();

        // try {
        //     DB::connection('firebird_ulp')->getPdo();
        //     return "Conexão com o banco de dados bem-sucedida!";
        // } catch (\Exception $e) {
        //     return "Erro ao conectar com o banco de dados: " . $e->getMessage();
        // }

        try {
            $result = DB::connection('firebird_ulp')->table('SUDEPARTAMENTO')->get();

            // Converter os dados para UTF-8, se necessário
            $result = $result->map(function ($item) {
                return (object) array_map(function ($value) {
                    return is_string($value) ? iconv('ISO-8859-1', 'UTF-8//IGNORE', $value) : $value;
                }, (array) $item);
            });

            return response()->json([
                'status' => 'Conexão Firebird bem-sucedida',
                'data' => $result,
            ]);
        } catch (\PDOException $e) {
            return response()->json([
                'status' => 'Erro de conexão Firebird',
                'message' => 'Erro de PDO: ' . $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'Erro de conexão Firebird',
                'message' => 'Erro geral: ' . $e->getMessage(),
            ]);
        }
    }


    public function index()
    {
        try {
            DB::connection()->getPdo();
            return "Conexão com o banco de dados bem-sucedida!";
        } catch (\Exception $e) {
            return "Erro ao conectar com o banco de dados: " . $e->getMessage();
        }
    }

    // Método para limpar os logs
    private function clearLogs()
    {
        $logFile = storage_path('logs/laravel.log');
        if (file_exists($logFile)) {
            file_put_contents($logFile, ""); // Limpa o conteúdo do arquivo de log
            Log::info('Logs foram limpos.');
        } else {
            Log::warning('Arquivo de log não encontrado.');
        }
    }
}
