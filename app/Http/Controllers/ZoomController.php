<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ZoomController extends Controller
{
    private $apiKey;
    private $apiSecret;
    private $baseUrl = 'https://api.zoom.us/v2';

    public function __construct()
    {
        $this->apiKey = env('ZOOM_API_KEY');
        $this->apiSecret = env('ZOOM_API_SECRET');
    }

    /**
     * Generar JWT Token para Zoom API
     */
    private function generateZoomToken()
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'iss' => $this->apiKey,
            'exp' => time() + 3600
        ]);

        $headerEncoded = $this->base64UrlEncode($header);
        $payloadEncoded = $this->base64UrlEncode($payload);

        $signature = hash_hmac('sha256', $headerEncoded . "." . $payloadEncoded, $this->apiSecret, true);
        $signatureEncoded = $this->base64UrlEncode($signature);

        return $headerEncoded . "." . $payloadEncoded . "." . $signatureEncoded;
    }

    private function base64UrlEncode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    /**
     * Mostrar formulario para crear reunión
     */
    public function mostrarFormulario()
    {
        return view('docente.zoom.crear');
    }

    /**
     * Crear reunión de Zoom
     */
    public function crearReunion(Request $request)
    {
        try {
            $token = $this->generateZoomToken();

            $meetingData = [
                'topic' => $request->input('topic', 'Reunión de Clase'),
                'type' => 2,
                'start_time' => $request->input('start_time', now()->addMinutes(5)->toISOString()),
                'duration' => $request->input('duration', 60),
                'timezone' => 'America/La_Paz',
                'settings' => [
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => false,
                    'mute_upon_entry' => true,
                    'watermark' => false,
                    'use_pmi' => false,
                    'approval_type' => 0,
                    'audio' => 'both',
                    'auto_recording' => 'none'
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/users/me/meetings', $meetingData);

            if ($response->successful()) {
                $meeting = $response->json();

                return view('docente.zoom.resultado', [
                    'success' => true,
                    'meeting' => [
                        'id' => $meeting['id'],
                        'topic' => $meeting['topic'],
                        'start_url' => $meeting['start_url'],
                        'join_url' => $meeting['join_url'],
                        'password' => $meeting['password'] ?? '',
                        'start_time' => $meeting['start_time']
                    ]
                ]);
            } else {
                return view('docente.zoom.resultado', [
                    'success' => false,
                    'message' => 'Error al crear la reunión: ' . $response->body()
                ]);
            }

        } catch (\Exception $e) {
            return view('docente.zoom.resultado', [
                'success' => false,
                'message' => 'Error al crear la reunión: ' . $e->getMessage()
            ]);
        }
    }
}