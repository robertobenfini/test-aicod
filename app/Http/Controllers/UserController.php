<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class UserController extends Controller
{
    public function processForm(Request $request)
    {
        // Validazione dei dati del form
        $request->validate([
            'nome' => 'required',
            'cognome' => 'required',
            'email' => 'required|email',
            'codice_tessera' => 'required',
            'note' => 'nullable',
            'livello' => 'nullable|numeric'
        ]);

        // Assegnazione del valore del campo 'codice_tessera'
        $codiceTessera = $request->input('codice_tessera');

        // Esegui la chiamata server-to-server al web service REST
        $response = Http::withOptions([
            'verify' => false,
        ])->post("https://www.aicod.it/test_data/user_info.php?codice_tessera=$codiceTessera");

        // Estrazione dei dati JSON dalla risposta HTTP
        $userData = $response->json();

        if (isset($userData['user_type'])) {
            if ($userData['user_type'] == 'subscriber') {
                // Aggiungi una riga alla tabella users
                User::create([
                    'nome' => $request->input('nome'),
                    'cognome' => $request->input('cognome'),
                    'email' => $request->input('email'),
                    'codice_tessera' => $codiceTessera,
                    'note' => $request->input('note'),
                    'livello' => $request->input('livello')
                ]);

                return "Utente aggiunto con successo.";
            } elseif ($userData['user_type'] == 'unsubscriber') {
                // Rimuovi l'utente dal database
                User::where('email', $request->input('email'))
                    ->where('codice_tessera', $codiceTessera)
                    ->delete();
                return "Utente rimosso con successo.";
            } else{
                return "La tua utenza non è attiva.";
            }
        } else {
            // La chiave 'user_type' non è presente nell'array $userData
            return "Dati utente non validi o mancanti nella risposta.";
        }
    }
}