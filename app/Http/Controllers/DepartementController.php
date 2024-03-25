<?php

namespace App\Http\Controllers;

use App\Models\DepartementModel;
use App\Models\ProdyModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = DepartementModel::all();

        return view('admin.data-departements.data-departements', ['departements' => $departements]);
    }

    public function storeDepartement(Request $request)
    {

        $validation = [
            'name' => 'required'
        ];

        $messages = [
            'name.required' => 'Masukkan nama jurusan',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        try {
            DepartementModel::create([
                'name' => $request->name,
                'created_by' => auth()->user()->user_id ,
                'updated_by' => auth()->user()->user_id ,
            ]);
            return back()->with('toast_success', 'Berhasil menambahkan jurusan');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', $th->getMessage());
        }
    }

    public function updateDepartement(Request $request)
    {
        $validation = [
            'name' => 'required,',
        ];

        $messages = [
            'name.required' => 'Masukkan Nama Jurusan',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        try {
            $oldDepartement = DepartementModel::find($request->id);
            $oldDepartement->update([
                'name' => $request->name,
                'updated_by' => auth()->user()->user_id ,
            ]);

            return back()->with('toast_success', 'Berhasil memperbarui nama jurusan');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', $th->getMessage());
        }

    }

    public function deleteDepartement(Request $request)
    {
        $validation = [
            'departementId' => 'required',
        ];

        $messages = [
            'departementId.required' => 'Wajib mengikutsertakan id',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        try {
            $departement = DepartementModel::find($request->departementId);

            $departement->delete([
                'deleted_by' => auth()->user()->user_id
            ]);

            return back()->with('toast_success', 'Berhasil menghapus jurusan');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', $th->getMessage());

        }

    }

    public function getProdyByDepartement($departementId)
    {
        $departement = DepartementModel::find($departementId);
        $prodys = ProdyModel::where('departement_id', $departementId)->get();

        return view('admin.data-departements.data-prody.data-prody', [
            'departement' => $departement,
            'prodys' => $prodys,
        ]);
    }

    public function storeProgramStudy(Request $request)
    {
        $validation = [
            'name' => 'required',
            'departement_id' => 'required'
        ];

        $messages = [
            'name.required' => 'Masukkan nama program studi',
            'departement_id.required' => 'Wajib mengikutsertakan departement id',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        try {
            ProdyModel::create([
                'name' => $request->name,
                'departement_id' => $request->departement_id,
                'created_by' => auth()->user()->user_id ,
                'updated_by' => auth()->user()->user_id ,
            ]);
            
            return back()->with('toast_success', 'Berhasil menambahkan program studi');
        } catch (\Throwable $th) {  
            return back()->with('toast_warning', $th->getMessage());
        }
    }

    public function updateProgramStudy(Request $request)
    {
        $validation = [
            'name' => 'required',
            'departement_id' => 'required'
        ];

        $messages = [
            'name.required' => 'Masukkan nama program studi',
            'departement_id.required' => 'Wajib mengikutsertakan departement id',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        try {
            $oldPrody = ProdyModel::find($request->id);
            $oldPrody->update([
                'name' => $request->name,
                'updated_by' => auth()->user()->user_id ,
            ]);

            return back()->with('toast_success', 'Berhasil memperbarui nama program studi');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', $th->getMessage());
        }

    }

    public function deleteProgramStudy(Request $request)
    {
        $validation = [
            'prodyId' => 'required',
        ];

        $messages = [
            'prodyId.required' => 'Wajib mengikutsertakan id',
        ];

        $validator = Validator::make($request->all(), $validation, $messages);

        if($validator->fails()){
            return back()
            ->with('toast_error', $validator->messages()->all());
        }

        try {
            $prody = ProdyModel::find($request->prodyId);

            $prody->delete([
                'deleted_by' => auth()->user()->user_id
            ]);

            return back()->with('toast_success', 'Berhasil menghapus program studi');
        } catch (\Throwable $th) {
            return back()->with('toast_warning', $th->getMessage());

        }

    }

}
