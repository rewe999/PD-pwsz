<?php

namespace App\Http\Controllers;

use App\Http\Models\People;
use App\Http\Models\Scientific;
use App\Http\Requests\ScientificRequest;
use Exception;
use Illuminate\Http\Request;

class ScientificController extends Controller
{
    public function index($id)
    {
        $scientific_exist = Scientific::where('people_id',$id)->get();

        if(count($scientific_exist) > 0){
            return redirect()->route('scientific.edit',$id);
        }else {
            return redirect()->route('scientific.create',$id);
        }
    }

    public function create($id)
    {
        $person = People::where('id',$id)->first();
        return view('scientific.create',compact('person'));
    }


    public function store(ScientificRequest $request,$id)
    {
        $scientific = new Scientific();
        $scientific->data = $request['data'];
        $scientific->people_id = $id;
        $scientific->save();

        $PersonData = $scientific->people->title . " " . $scientific->people->name . " " . $scientific->people->surname;
        session()->flash('message','Utworzono sekcje naukową ' . $PersonData);
        return redirect()->route('people.edit');
    }

    public function show($id)
    {
        $section_not_exist = Scientific::where('people_id',$id)->first();
        $person = Scientific::with(['people.didactic','people.organizational','people.scientific'])->where('people_id',$id)->get();

        if($section_not_exist == []){
            return redirect('pracownicy/'.$id);
        }
        return view('scientific.show',compact('person'));
    }

    public function edit($id)
    {
        $scientific_exist = Scientific::where('people_id',$id)->get();
//        dd($scientific_exist);
        if(count($scientific_exist) > 0){
            $person = Scientific::with('people')->where('people_id',$id)->first();
            return view('scientific.edit',compact('person'));
        }

        return redirect()->route('peoples.index');
    }


    public function update(ScientificRequest $request, $id)
    {
        $person = Scientific::where('people_id',$id)->first();
        $person->data = $request['data'];
        $person->save();
        $PersonData = $person->people->title . " " . $person->people->name . " " . $person->people->surname;

        session()->flash('message','Edytowano sekcje naukową ' . $PersonData);
        return redirect()->route('peoples.index');
    }

    public function destroy($id)
    {
        try {
            $person = Scientific::where('people_id',$id)->first();
            if ($person != null) {
                $person->delete();
                $PersonData = $person->people->title . " " . $person->people->name . " " . $person->people->surname;
                session()->flash('message','Usunięto sekcje naukową ' . $PersonData);
                return redirect()->route('people.edit');
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Wystąpił błąd!'
            ])->setStatusCode(500);
        }
    }
}
