<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = 'http://127.0.0.1:8000/api/admin/feedbacks';

        $json = file_get_contents($url);

        $feedbacks = json_decode($json);

        return view('feedbacks.index',compact('feedbacks'))
            ->with('i',(request()->input('page',1)-1)*5);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = 'http://127.0.0.1:8000/api/admin/feedbacks';

        $json = file_get_contents($url);

        $feedbacks = json_decode($json);

        $fbShow = [
            'nameUser',
            'connection',
            'message',
            'status',
        ];
        foreach ($feedbacks->data as $feedback) {
            if ($feedback->id == $id) {
                $fbShow['nameUser'] = $feedback->nameUser;
                $fbShow['connection'] = $feedback->connection;
                $fbShow['message'] = $feedback->message;
                $fbShow['status'] = $feedback->status;
            }
        }

        return view('feedbacks.show',compact('fbShow'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $url = 'http://127.0.0.1:8000/api/admin/feedbacks';

        $json = file_get_contents($url);

        $feedbacks = json_decode($json);

        $fbShow = [
            'id',
            'nameUser',
            'connection',
            'message',
            'status',
        ];

        foreach ($feedbacks->data as $feedback) {
            if ($feedback->id == $id) {
                $fbShow['id'] = $id;
                $fbShow['nameUser'] = $feedback->nameUser;
                $fbShow['connection'] = $feedback->connection;
                $fbShow['message'] = $feedback->message;
                $fbShow['status'] = $feedback->status;
            }
        }

        return view('feedbacks.edit',compact('fbShow'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'nameUser' => 'required',
            'connection' => 'required',
            'message' => 'required',
            'status' => 'required'
        ]);

        $fbShow = [
            'nameUser',
            'connection',
            'message',
            'status',
        ];

        $url = 'http://127.0.0.1:8000/api/admin/feedbacks/'.$id;

        $fbShow['nameUser'] = $request->input('nameUser');
        $fbShow['connection'] = $request->input('connection');
        $fbShow['message'] = $request->input('message');
        $fbShow['status'] = $request->input('status');

        $options = array(
            'http' => array(
              'method'  => 'PUT',
              'content' => json_encode( $fbShow ),
              'header'=>  "Content-Type: application/json\r\n" .
                          "Accept: application/json\r\n"
              )
          );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        return redirect()->route('feedbacks.index')
            ->with('success','Заявка обработана');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://127.0.0.1:8000/api/admin/feedbacks/' . $id);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $result = json_decode($result);
        curl_close($ch);

        return redirect()->route('feedbacks.index')
            ->with('success','Заявка удалена');
    }
}
