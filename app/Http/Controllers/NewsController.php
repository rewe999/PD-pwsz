<?php

namespace App\Http\Controllers;

use App\Http\Models\News;
use App\Http\Requests\NewsRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::orderBy('date','DESC')->get();
        return view('news.index',['news' => $news]);
    }

    public function create()
    {
        return view('news.create');
    }

    public function showNews()
    {
        $news = News::orderBy('date','DESC')->get();
        return view('news.showNews',['news' => $news]);
    }

    public function store(NewsRequest $request)
    {
        $new = new News();
        $new->title = $request['title'];
        $new->content = $request['content'];
        $new->date = Carbon::now();
        $new->save();

        return redirect()->route('news.edit')->with('message',"Aktualność {$new->title} została dodana");
    }

    public function show($id)
    {
        $news = News::findOrFail($id);
        return view('news.show',['new'=>$news]);
    }

    public function edit($id)
    {
        $new = News::findOrFail($id);
        return view('news.edit',['new'=>$new]);
    }

    public function update(NewsRequest $request, $id)
    {
        $new = News::findOrFail($id);
        $new->fill($request->all());
        $new->save();

        return redirect()->route('news.edit')->with('message',"Aktualność {$new->title} została edytowana");
    }

    public function destroy($id)
    {
        try {
            $new = News::findOrFail($id);
            $new->delete();
            session()->flash('message','Usunięto aktualność '.$new->title);
            return response()->json([
                'message' => 'success'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Wystąpił błąd!'
            ])->setStatusCode(500);
        }
    }
}
