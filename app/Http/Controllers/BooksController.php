<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use App\Book;
use Illuminate\Support\Facades\Session;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if($request->ajax())
        {
            $books = Book::with('author');
            return Datatables::of($books)
            ->addColumn('action',function($book){
                return view('datatable._action',
                    [
                    'model'   => $book,
                    'form_url'=>route('books.destroy',$book->id),
                    'edit_url'=>route('books.edit',$book->id),
                    'confirm_message'=>'Yakin mau menghapus'.$book->title.'?'
                    ]);
        })->make(true);

        }
        $html = $htmlBuilder 
       -> addColumn(['data'=>'title','name'=>'title','title'=>'Judul'])
       -> addColumn(['data'=>'amount','name'=>'amount','title'=>'Jumlah'])
       -> addColumn(['data'=>'author.name','name'=>'author.name','title'=>'Penulis'])
       -> addColumn(['data'=>'action','name'=>'action','title'=>'','orderable'=>false,
        '\searchable'=>false]);
        return view('books.index')->with(compact('html'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|unique:books,title',
            'author_id'=>'required|exists:authors,id',
            'amount'=>'required|numeric',
            'cover' =>'image'
            ]);
        $book = Book::create($request->except('cover'));
        //isi field cover jika ada cover yang inngin di upload
        if($request->hasFile('cover'))
        {
            //Mengambil File yang di upload
            $uploaded_cover = $request->file('cover');

            //mengambil extension file
            $extension = $uploaded_cover->getClientOriginalExtension();

            //membuat nama file random berikut extesion
            $filename=md5(time()).'.'.$extesion;

            //menyimpan cover ke folder public/img
            $destinationPath = public_path().DIRECTORY_SEPARATOR.'img';
            $uploaded_cover->move($destinationPath,$filename);

            //mengisi fild cover di book dengan filename yang baru dibuat
            $book->cover=$filename;
            $book=save();
        }

        Session::flash("flash_notification", [
                "level"=>"succes",
                "message"=>"Berhasil menyimpan $book->title"
            ]);
        return redirect('admin/books');
        
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
        $author = Book::find($id);
        return view('book.edit')->with(compact('book'));
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
