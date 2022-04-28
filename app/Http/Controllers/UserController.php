<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $url = 'http://127.0.0.1:8000/api/admin/users';

        $json = file_get_contents($url);

        $users = json_decode($json);

        return view('users.index',compact('users'))
                ->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string|unique:users',
            'document_number' => 'required|string|max:10|min:10|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);


        $url = 'http://127.0.0.1:8000/api/admin/users';

        $user = [
            'first_name',
            'last_name',
            'phone',
            'document_number',
            'email',
            'password',
            'password_confirmation',
        ];

        $user['first_name'] = $request->input('first_name');
        $user['last_name'] = $request->input('last_name');
        $user['phone'] = $request->input('phone');
        $user['document_number'] = $request->input('document_number');
        $user['password'] = $request->input('password');
        $user['password_confirmation'] = $request->input('password_confirmation');

        if (null !== $request->input('email')) {
            $user['email'] = $request->input('email');
        }



        $options = array(
            'http' => array(
              'method'  => 'POST',
              'content' => json_encode( $user ),
              'header'=>  "Content-Type: application/json\r\n" .
                          "Accept: application/json\r\n"
              )
          );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        return redirect()->route('users.index')
                ->with('success','Добавлен новый пользователь');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = 'http://127.0.0.1:8000/api/admin/users';

        $json = file_get_contents($url);

        $users = json_decode($json);

        $user = [
            'first_name',
            'last_name',
            'phone',
            'document_number',
            'email',
            'password',
        ];

        foreach ($users->data as $key) {
            if ($key->id == $id) {
                $user['first_name'] = $key->first_name;
                $user['last_name'] = $key->last_name;
                $user['phone'] = $key->phone;
                $user['document_number'] = $key->document_number;
                $user['email'] = $key->email;
            }
        }

        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url = 'http://127.0.0.1:8000/api/admin/users';

        $json = file_get_contents($url);

        $users = json_decode($json);

        $user = [
            'id',
            'first_name',
            'last_name',
            'phone',
            'document_number',
            'email',
            'password',
        ];

        foreach ($users->data as $key) {
            if ($key->id == $id) {
                $user['id'] = $id;
                $user['first_name'] = $key->first_name;
                $user['last_name'] = $key->last_name;
                $user['phone'] = $key->phone;
                $user['document_number'] = $key->document_number;
                $user['email'] = $key->email;
            }
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'document_number' => 'required|string|max:10|min:10',
        ]);

        $url = 'http://127.0.0.1:8000/api/admin/users/'.$id;

        $user = [
            'first_name',
            'last_name',
            'email',
            'phone',
            'document_number',
            'password',
        ];

        $user['first_name'] = $request->input('first_name');
        $user['last_name'] = $request->input('last_name');
        $user['phone'] = $request->input('phone');
        $user['document_number'] = $request->input('document_number');
        $user['password'] = $request->input('password');
        $user['password_confirmation'] = $request->input('password_confirmation');

        if (null !== $request->input('email')) {
            $user['email'] = $request->input('email');
        }

        $options = array(
            'http' => array(
              'method'  => 'PUT',
              'content' => json_encode( $user ),
              'header'=>  "Content-Type: application/json\r\n" .
                          "Accept: application/json\r\n"
              )
          );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        return redirect()->route('users.index')
                    ->with('success','Пользователь обновлен');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/admin/users/'.$id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = json_decode($result);
        curl_close($ch);

        return redirect()->route('users.index')
                ->with('success','Пользователь удален');
    }
}
