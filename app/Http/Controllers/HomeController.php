<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\WeatherService;
use App\Models\User;
use App\Models\Task;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->middleware('auth');
        $this->weatherService = $weatherService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //  Show All Tasks Function
    public function index()
    {
        $tasks = Auth::user()->tasks()->withTrashed()->paginate(5); // Only fetch tasks for the authenticated user
        // $tasks = Task::paginate(5);
        return view('index', compact('tasks'));
    }
    //  Show All Tasks Function end

    //  Create Tasks Function
    public function create()
    {
        return view('home');
    }
    //  Create Tasks Function end

    //  Store Tasks Function
    public function insert(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'location' => 'nullable|string',
        ]);

        $latitude = $request->input('latitude');
	    $longitude = $request->input('longitude');

        $task = new Task([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'location' => $request->input('location'),
            'weather_info' => $request->has('enable_weather'),
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        Auth::user()->tasks()->save($task);

        // Update weather information if weather is enabled
        if ($task->weather_info) {
            $weatherInfo = $this->weatherService->getWeatherInfo($task->due_date, $task->latitude, $task->longitude);

            if ($weatherInfo) {
                $temperatureKelvin = $weatherInfo['main']['temp'];
                
                // Convert temperature to Celsius
                $temperatureCelsius = $temperatureKelvin - 273.15;
                
                $task->update([
                    'weather_info' => json_encode($weatherInfo), // Store the entire array as JSON
                    'temperature' => $temperatureCelsius,
                    'weather_condition' => $weatherInfo['weather'][0]['description'],
                ]);
            }
        }

        return redirect('home')->with('status', 'Task Created Successfully');
    }
    //  Store Tasks Function end

    //  Edit Tasks Function
    public function edit(Task $task)
    {
        return view('edit', compact('task'));
    }
    //  Edit Tasks Function end

    //  Update Tasks Function
    public function update(Request $request, Task $task)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'location' => 'nullable|string',
        ]);

        // Update the task attributes
        $task->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'location' => $request->input('location'),
            'weather_info' => $request->has('enable_weather'),
        ]);

        // Update latitude and longitude if available
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');

            if ($latitude !== null && $longitude !== null) {
                $task->update([
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                ]);
            }    

        // Update weather information if weather is enabled
        if ($task->weather_info) {
            $weatherInfo = $this->weatherService->getWeatherInfo($task->due_date, $task->latitude, $task->longitude);

            if ($weatherInfo) {
                $temperatureKelvin = $weatherInfo['main']['temp'];
                $temperatureCelsius = $temperatureKelvin - 273.15;

                $task->update([
                    'weather_info' => json_encode($weatherInfo),
                    'temperature' => $temperatureCelsius,
                    'weather_condition' => $weatherInfo['weather'][0]['description'],
                ]);
            }
        } else {
            // If weather is disabled, clear weather information
            $task->update([
                'weather_info' => null,
                'temperature' => null,
                'weather_condition' => null,
            ]);
        }

        // Redirect back to the task details page
        return redirect('home')->with('status', 'Task Updated Successfully');
    }
    //  Update Tasks Function end

    // Delete Tasks Function
    public function destroy(Task $task)
    {
        // Perform a soft delete
        $task->delete();

        // Redirect back to the task listing page
        return redirect('home')->with('status', 'Task Deleted Successfully');
    }
    // Delete Tasks Function end
}
