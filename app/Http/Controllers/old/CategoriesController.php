<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\CategoryRequest;
use App\Domains\CategoryRepository;

class CategoriesController extends Controller
{
    private $repository;
    public function __construct(CategoryRepository $repository){
        $this->repository = $repository;
    }
    public function index()    
    {
        $categories = $this->repository->listaPaginada();
        return view('admin.category.index', compact('categories'));
    }
    
    public function create()
    {
        return view('admin.category.create');
    }
    
    public function store(CategoryRequest $request)
    {
        $saida = $this->repository->store($request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.categories.index');
    }
    
    public function edit($id){
        $category = $this->repository->findByID($id);
        return view('admin.category.edit', compact('category'));
    }
    
    public function update($id, CategoryRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.categories.index');
    }
    
    public function delete( $id)
    {
        $saida = $this->repository->delete($id);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.categories.index');
    }
    
    /**
     * lista json 
     */
    public function list()
    {
        $categories = $this->categories->all();
        return response()->json($categories);        
    }
    
}
