<?php
namespace App\Jobs;
 
use App\Models\User;
use App\Services\WeatherService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Events\UpdateWeatherDispatch;

    
class UpdateWeatherJob implements ShouldQueue 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new event instance.
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;   
    }
    
    public function handle(WeatherService $weatherService)
    {
        $data = $weatherService->updateCachedWeather($this->user->latitude, $this->user->longitude);
        event(new UpdateWeatherDispatch($this->user, $data));
    }
}
