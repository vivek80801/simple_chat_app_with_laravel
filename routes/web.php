<?php

use App\Events\ChatEvent;
use App\Jobs\SendChat;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name("home");

Route::group(["middleware" => "guest"], function(){
    Route::get("/login", function(){
        return view("auth.login");
    })->name("login");

    Route::post("/login", function(Request $request){
        $request->validate([
            "email" => "required",
            "password" => "required",
        ]);

        $credentials = $request->only("email", "password");

        if(Auth::attempt($credentials))
        {
            return redirect()->to(
                route("dashboard")
            );
        }

        return redirect()->back();
    });
});

Route::group(["middleware" => "auth"], function(){
    Route::get("/dashboard", function(){
        $users = User::where(
            "id", "!=", auth()->user()->id
        )->pluck("name", "id");

        return view(
            "auth.dashboard",
            compact(
                "users"
            )
        );
    })->name("dashboard");

    Route::post("/logout", function(){
        Auth::logout();
        return redirect()->to(route("login"));
    })->name("logout");

    Route::get("/chat", function(){
        $user = User::find(
            request()
                ->query("user")
        );

        $chats = Chat::where(
            function($query) use ($user)
            {
                $query->where("sender_id", auth()->id())
                    ->where("recevier_id", $user->id);
            }
        )->orWhere(
            function($query) use ($user)
            {
                $query->where("sender_id", $user->id)
                    ->where("recevier_id", auth()->id());
            }
        )->get();

        return view(
            "user.chat",
            compact(
                "user",
                "chats"
            )
        );
    })->name("chat");

    Route::post("/chat",function(Request $request)
        {
            $chat  = Chat::create([
                "sender_id" => auth()->user()->id,
                "recevier_id" => $request->recevier_id,
                "message" => $request->chat,
            ]);
            SendChat::dispatch($chat);

            return response()->json($chat, 201);
    });
});
