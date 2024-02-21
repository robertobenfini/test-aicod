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

            // Validazione dei dati del form
            $request->validate([
                'nome' => 'required',
                'cognome' => 'required',
                'email' => 'required|email',
                'codice_tessera' => 'required',
            ]);

            // Assegnazione del valore del campo 'codice_tessera'
            $codiceTessera = $request->input('codice_tessera');

            // Esegui la chiamata server to server al web service REST
            $response = Http::withOptions([
                'verify' => false,
            ])->post("https://www.aicod.it/test_data/user_info.php?codice_tessera=$codiceTessera");

            // Estrazione dei dati JSON dalla risposta HTTP
            $userData = $response->json();

            // In base al valore di user_type
            switch ($userData['user_type']) {
                case 'subscriber':
                    // Aggiungi una riga alla tabella users
                    User::create([
                        'nome' => $request->input('nome'),
                        'cognome' => $request->input('cognome'),
                        'email' => $request->input('email'),
                        'codice_tessera' => $codiceTessera,
                    ]);

                    return "Utente aggiunto con successo.";

                case 'unsubscriber':
                    // Rimuovi l'utente dal database
            //         User::where('email', $request->input('email'))
            //             ->where('codice_tessera', $codiceTessera)
            //             ->delete();

                    // Visualizza un messaggio nella console
                    // dd("Utente rimosso con successo.");

                    return "Utente rimosso con successo.";

                case 'blocked':
                    // Mostra un messaggio di utenza non attiva
                    return "La tua utenza non è attiva.";

            }
        } catch (\Exception $e) {
            // Visualizza l'errore nella console
            dd($e->getMessage());
        }
    }
}
