<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class СommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = 'http://127.0.0.1:8000/api/admin/comments';

        $json = file_get_contents($url);

        $comments = json_decode($json);

        return view('comments.index',compact('comments'))
                ->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $url = 'http://127.0.0.1:8000/api/admin/comments';

        $request->validate([
            'comment' => 'required',
            'nameUser' => 'required',
        ]);

        $comment = [
            'nameUser',
            'comment',
            'status',
        ];

        $comment['nameUser'] = $request->input('nameUser');
        $comment['comment'] = $request->input('comment');
        $comment['status'] = $request->input('status');

        $options = array(
            'http' => array(
              'method'  => 'POST',
              'content' => json_encode( $comment ),
              'header'=>  "Content-Type: application/json\r\n" .
                          "Accept: application/json\r\n"
              )
          );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        return redirect()->route('comments.index')
            ->with('success','Комментарий добавлен');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = 'http://127.0.0.1:8000/api/admin/comments';

        $json = file_get_contents($url);

        $comments = json_decode($json);

        $commentShow = [
            'nameUser',
            'comment',
            'status',
        ];

        foreach ($comments->data as $comment) {
            if ($comment->id == $id) {
                $commentShow['nameUser'] = $comment->nameUser;
                $commentShow['comment'] = $comment->comment;
                $commentShow['status'] = $comment->status;
            }
        }

        return view('comments.show',compact('commentShow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url = 'http://127.0.0.1:8000/api/admin/comments';

        $json = file_get_contents($url);

        $comments = json_decode($json);

        $commentShow = [
            'id',
            'nameUser',
            'comment',
            'status',
        ];

        foreach ($comments->data as $comment) {
            if ($comment->id == $id) {
                $commentShow['id'] = $id;
                $commentShow['nameUser'] = $comment->nameUser;
                $commentShow['comment'] = $comment->comment;
                $commentShow['status'] = $comment->status;
            }
        }

        return view('comments.edit',compact('commentShow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required',
            'nameUser' => 'required',
        ]);

        $comment = [
            'nameUser',
            'comment',
            'status',
        ];

        $url = 'http://127.0.0.1:8000/api/admin/comments/'.$id;

        $comment['nameUser'] = $request->input('nameUser');
        $comment['comment'] = $request->input('comment');
        $comment['status'] = $request->input('status');

        $options = array(
            'http' => array(
              'method'  => 'PUT',
              'content' => json_encode( $comment ),
              'header'=>  "Content-Type: application/json\r\n" .
                          "Accept: application/json\r\n"
              )
          );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        return redirect()->route('comments.index')
            ->with('success', 'Коментарий изменен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/admin/comments/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = json_decode($result);
        curl_close($ch);

        return redirect()->route('comments.index')
            ->with('success', 'Коментарий удален');
    }
}
