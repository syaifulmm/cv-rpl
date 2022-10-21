<?php

namespace App\Http\Controllers;
use Session;
use File;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{   
   public function __construct()
   {
     $this->middleware('admin')->except('index');
   }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Siswa::all();
        return view('MasterSiswa' , compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('TambahSiswa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message=[
            'required' => ':attribute harus diisi gaesss',
            'min' => ':attribute minimal :min karakter ya coy',
            'max' => ':attribute maksimal :max karakter gaess',
            'numeric' => ':attribute kudu diisi angka cak!!',
            'mimes'  => 'file :attribute harus bertipe jpg,png, jpeg'
        ];

        //validasi form
        $this->validate($request,[
            'nama' => 'required|min:7|max:30',
            'nisn'=> 'required|numeric',
            'alamat' => 'required',
            'jk' => 'required',
            'foto' =>'required',
            'about'=>'required|min:10'
        ], $message);

        //ambil informasi file yang diupload
        $file = $request->file('foto');

        //rename
        $nama_file = time()."_".$file->getClientOriginalName();

        //_firman.jpg

        //proses upload
        $tujuan_upload = './template/img';
		$file->move($tujuan_upload,$nama_file);

        //insert data
        Siswa::create([
            'nama' => $request-> nama,
            'nisn'=> $request-> nisn,
            'alamat' => $request-> alamat,
            'jk' => $request-> jk,
            'foto' => $nama_file,
            'about'=> $request-> about
        ]);

        Session::flash('success', 'Data Berhasil ditambahkan');
        return redirect('/mastersiswa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa=Siswa::find($id);
        $kontaks = $siswa->kontak()->get();
        // return($kontak);
        return view ('ShowSiswa', compact('siswa', 'kontaks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $siswa=Siswa::find($id);
        return view ('EditSiswa', compact('siswa'));
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
        $message=[
            'required' => ':attribute harus diisi gaesss',
            'min' => ':attribute minimal :min karakter ya coy',
            'max' => ':attribute maksimal :max karakter gaess',
            'numeric' => ':attribute kudu diisi angka cak!!',
            'mimes'  => 'file :attribute harus bertipe jpg,png, jpeg'
        ];

        //validasi form
        $this->validate($request,[
            'nama' => 'required|min:7|max:30',
            'nisn'=> 'required|numeric',
            'alamat' => 'required',
            'jk' => 'required',
            'about'=>'required|min:10'
        ], $message);

        if($request->foto != ''){

            //1. menghapus file foto lama
            $siswa=Siswa::find($id);
            file::delete('./template/img/'.$siswa->foto);

            //2. ambil informasi file foto baru yang diupload
            $file = $request->file('foto');

            //rename
            $nama_file = time()."_".$file->getClientOriginalName();

            //proses upload
            $tujuan_upload = './template/img';
		    $file->move($tujuan_upload,$nama_file);

            //5. menyimpan ke database
            $siswa->nama = $request->nama;
            $siswa->nisn = $request->nisn;
            $siswa->alamat = $request->alamat;
            $siswa->jk = $request->jk;
            $siswa->foto = $nama_file;
            $siswa->about = $request->about;
            $siswa->save();
            Session::flash('success', 'Data Berhasil diedit');
            return redirect ('mastersiswa');

        }else{
            $siswa=Siswa::find($id);
            $siswa->nama = $request->nama;
            $siswa->nisn = $request->nisn;
            $siswa->alamat = $request->alamat;
            $siswa->jk = $request->jk;
            $siswa->about = $request->about;
            $siswa->save();
            Session::flash('success', 'Data Berhasil diedit');
            return redirect ('mastersiswa');
        }
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

    public function hapus($id)
    {
        $siswa=Siswa::find($id);
        $siswa->delete();
        Session::flash('success', 'Data Berhasil dihapus');
        return redirect('/mastersiswa');
    }
}
