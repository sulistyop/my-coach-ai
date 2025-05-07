<?php

namespace App\Http\Controllers;

use App\Models\Goal;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\OpenAiService;
use App\Models\Habit;

class GoalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $goals = $user->goals()->latest()->get();

        return view('goals.index', compact('goals'));
    }

    public function create()
    {
        return view('setup.goals');
    }

    public function storeHabitResult(Request $request)
    {
        $request->validate([
            'goal_name' => 'required|string|max:255',
        ]);

        $goalName = $request->input('goal_name');
        $goals = $request->input('goals');

        try {
            \DB::beginTransaction();

            $goal = new Goal();
            $goal->title = $goalName;
            $goal->user_id = Auth::id();
            $goal->save();

            foreach ($goals as $goalData) {
                $habit = new Habit();
                $habit->name = $goalData['habit'];
                $habit->strategy = $goalData['strategy'];
                $habit->goal_id = $goal->id;
                $habit->user_id = Auth::id();
                $habit->frequency = 'daily';
                $habit->save();
            }

            \DB::commit();

            return response()->json(['success' => true, 'message' => 'Habit berhasil ditambahkan']);
        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat menambahkan habit', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Goal $goal)
    {
        $habits = $goal->habits()->with(['logs' => function ($query) {
            $query->whereDate('created_at', now()->toDateString());
        }])->get();

        $habits = $goal->habits()->with('logs')->get();
        $habitsDone = $habits->filter(fn($habit) => $habit->logs->isNotEmpty())->count();
        $habitsTotal = $habits->count();

        return view('goals.show',  compact('goal', 'habits', 'habitsDone', 'habitsTotal'));
    }

    public function edit($id)
    {
        $goal = Goal::findOrFail($id);
        return view('goals.edit', compact('goal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_date' => 'required|date',
        ]);

        $goal = new Goal();
        $goal->title = $request->input('title');
        $goal->description = $request->input('description');
        $goal->target_date = $request->input('target_date');
        $goal->user_id = Auth::id();
        $goal->save();

        return redirect()->route('goals')->with('success', 'Tujuan berhasil ditambahkan');
    }

    public function update(Request $request, Goal $goal)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_date' => 'required|date',
        ]);

        $goal->title = $request->input('title');
        $goal->description = $request->input('description');
        $goal->target_date = $request->input('target_date');
        $goal->user_id = Auth::id();
        $goal->save();

        return redirect()->route('goals')->with('success', 'Tujuan berhasil diperbarui');
    }

    public function destroy(Goal $goal)
    {
        $goal->delete();

        return redirect()->route('goals.index')->with('success', 'Tujuan berhasil dihapus');
    }

    public function createGoal()
    {
        return view('goal.goal');
    }

    public function storeGoal(Request $request)
    {
        $request->validate([
            'goal' => 'required|string|max:255',
        ]);

        return OpenAiService::make()->getResponse($request->goal);

        // $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=AIzaSyBGXHGhP1mi7uuW29QdqGNkCSjrEnk5w10";

        // $body = [
        //     "system_instruction" => [
        //         "parts" => [
        //             ["text" => "MyCoachAi: Berikan output JSON array berisi daftar list dari goals. Tidak ada teks pembuka atau penutup. gunakan kata 'biasakan' atau 'selalu'"],
        //             ["text" => "Format Array Json, key nya habit, strategy"],
        //             ["text" => "10 List data"],
        //             ["text" => "Scope: Pola Hidup Sehat, produktifitas kesehatan, olahraga"]
        //         ]
        //     ],
        //     "contents" => [
        //         [
        //             "parts" => [
        //                 ["text" => "naikin berat badan 5 kg dalam 1 bulan "]
        //             ]
        //         ]
        //     ]
        // ];

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        // ])->post($url, $body);

        // if ($response->successful()) {
        //     $responseData = $response->json();

        //     $jsonString = $responseData['candidates'][0]['content']['parts'][0]['text'] ?? '';

        //     $cleaned = trim($jsonString);
        //     $cleaned = preg_replace('/^```json|```$/', '', $cleaned);
        //     $cleaned = trim($cleaned);

        //     return json_decode($cleaned, true);
        // }

        // return null;
    }


    public function indexGoals(Request $request)
    {
        $request->validate([
            'goal' => 'required|string|max:255',
        ]);

        $userPrompt = $request->input('goal');
        

        $user = Auth::user();

        return view('goal.goal-ai', compact('user', 'userPrompt'));
    }



}
