<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\WeatherService;
use App\Jobs\UpdateWeatherJob;

class UserController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function getWeather($userId)
    {
        $user = User::find($userId);
        if (!$user) {
            abort(404, 'User not found');
        }
        $data = $this->weatherService->getWeatherData($user->latitude, $user->longitude);
        UpdateWeatherJob::dispatch($user);
        return response()->json(['data' => $data]);
    }
}