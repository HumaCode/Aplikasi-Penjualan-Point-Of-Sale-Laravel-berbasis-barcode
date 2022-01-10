<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    // menampilkan data user menggunakan datatable serverside
    public function data()
    {
        $user = User::isNotAdmin()->orderBy('id', 'desc')->get();

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                <center>
                    <div class="btn-group">
                        <button type="button" onclick="editForm(`'. route('user.update', $user->id) .'`)" class="btn btn-xs btn-info btn-flat" title="Edit"><i class="fa fa-pencil"></i></button>
                        <button type="button" onclick="deleteData(`'. route('user.destroy', $user->id) .'`)" class="btn btn-xs btn-danger btn-flat" title="Hapus"><i class="fa fa-trash"></i></button>
                    </div>
                </center>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->level = 2;
        $user->foto = '/img/user.png';
        $user->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // tampilkan data pengeluaran berdasarkan id
        $user = User::find($id);

        return response()->json($user);
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if($request->has('password') && $request->password != "") 
            $user->password = bcrypt($request->password);

        $user->update(); 

        return response()->json('Data berhasil diedit', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response(null, 204);
    }


    public function profil()
    {
        $profil = auth()->user();

        return view('user.profil', compact('profil'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();
        $user->name = $request->name;

        // cek old password apakah sama dengan password yang ada di database..
        // dan di cek juga, apakah password tidak kosong.
        // dan di cek juga apakah password konfirmasi sama dengan password lainya.
        if($request->has('password') && $request->password != "") {
            if(Hash::check($request->old_password, $user->password)) {
                if($request->password == $request->password_confirmation) {
                    $user->password = bcrypt($request->password);
                }else {
                    return response()->json('Password tidak cocok.!!', 422);
                }
            } else {
                return response()->json('Password lama salah.!!', 422);
            }
        }

        // hapus foto lama
        if($user->foto == "user.png") {
            unlink(public_path('') . $user->foto);
        }

        // cek apakah mengupload foto
        if($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama1 = $file->hashName();
            $file->move(public_path('/img'), $nama1);

            $user->foto = "/img/$nama1";
        }

        $user->update();
        return response()->json($user, 200);
    }
}
