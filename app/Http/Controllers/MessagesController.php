<?php

namespace App\Http\Controllers;

use App\Notifications\MessageReply;
use App\User;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inbox()
    {
        return view('admin.messages.inbox');

    }

    public function unread()
    {

        return view('admin.messages.unread');

    }


    public function compose()
    {
        $users = User::all();
        return view('admin.messages.compose',compact('users'));

    }


    public function send()
    {$message = request()->validate([
        'title' => ['required'],
        'comment' => ['required'],
        'data_id' => ['nullable'],
        'user' => ['required'],
    ]);

        $userId = request('user');

        $user = User::find($userId);
        //dd($user->id);

        $user->notify(
            new MessageReply($message)
        );

        return back()->with('message','Message sent');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function read($notification)
    {
        //
        $userNotification = auth()->user()
            ->notifications
            ->where('id', $notification)
            ->first();

        //dd($userNotification->data['title']);

        if($userNotification) {
            $userNotification->markAsRead();
        }
        return view('admin.messages.read',compact('userNotification'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reply()
    {
        //
        $message = request()->validate([
            'title' => ['required'],
            'comment' => ['required'],
            'data_id' => ['nullable'],
            'user' => ['required'],
        ]);

        $userId = request('user');
        $user = User::find($userId);


        //dd($user->id);

        $user->notify(
            new MessageReply($message)
        );

        return back()->with('message','Message sent');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
