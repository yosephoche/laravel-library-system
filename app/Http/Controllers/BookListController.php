<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Yajra\DataTables\Html\Builder;
use Yajra\Datatables\Datatables;
use Storage;
use Response;
use File;
use App\Book;
use Laratrust\LaratrustFacade as Laratrust;

class BookListController extends Controller
{
     public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()) {
            $books = Book::with('author');
            return Datatables::of($books)
                ->addColumn('stock', function($book){
                    return $book->stock;
                })

                ->addColumn('tipe', function ($book) {
                    return $book->tipe == 1 ? "Ebook" : "Fisik";
                })
               
                ->addColumn('action', function($book){
                    if (Laratrust::hasRole('admin')) return '';

                    if ($book->tipe == 1) {
                        return '<a class="btn btn-xs btn-primary" href="' . route('booklist.show', $book->id) . '">View</a>';
                    }
                    return '<a class="btn btn-xs btn-primary" href="'.route('booklist.show', $book->id).'">Details</a>';
                })->make(true);
        }

        $html = $htmlBuilder
            ->addColumn(['data' => 'kode_buku', 'name'=>'kode_buku', 'title'=>'Kode Buku'])
            ->addColumn(['data' => 'title', 'name'=>'title', 'title'=>'Judul'])
            ->addColumn(['data' => 'stock', 'name'=>'stock', 'title'=>'Stok', 'orderable'=>false, 'searchable'=>false])
            ->addColumn(['data' => 'no_rak', 'name'=>'no_rak', 'title'=>'Nomor Rak'])
            ->addColumn(['data' => 'author.name', 'name'=>'author.name', 'title'=>'Penulis'])
            ->addColumn(['data' => 'tipe', 'name'=>'tipe', 'title'=>'Tipe Buku'])
            ->addColumn(['data' => 'action', 'name'=>'action', 'title'=>'', 'orderable'=>false, 'searchable'=>false]);

        return view('books.list')->with(compact('html'));

        
    }

    public function ebook($id)
    {
        $books = Book::where('id', $id)->first();
        $filePath = public_path('ebook/' . $books->path_file);
        // dd($filePath);
        // file not found
        if (!File::exists($filePath)) {
            abort(404);
        }

        $file = File::get($filePath);
        $type = File::mimeType($filePath);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
        
    }


}
