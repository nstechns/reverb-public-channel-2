<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/message-sent', function (\Illuminate\Http\Request $request){
    if(!session()->has('username'))
        session()->put('username', Faker\Factory::create()->userName);
    \App\Events\MessageSent::dispatch(session()->get('username'), $request->message);
    return response()->json(['error'=> false, 'message'=> 'Message sent!']);
});
