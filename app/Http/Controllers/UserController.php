<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class UserController extends Controller
{
    public function processForm(Request $request)
    {
        try {

            $request->validate([
                'nome' => 'required',
                'cognome' => 'required',
                'email' => 'required|email',
                'codice_tessera' => 'required',
            ]);

            $codiceTessera = $request->input('codice_tessera');

            // Esegui la chiamata server to server al web service REST
            $response = Http::withOptions([
                'verify' => false,
            ])->post("https://www.aicod.it/test_data/user_info.php?codice_tessera=$codiceTessera");


            $userData = $response->json();

        } catch (\Exception $e) {
            // Visualizza l'errore nella console
            dd($e->getMessage());
        }
    }
}
