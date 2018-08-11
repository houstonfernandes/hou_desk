<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductImageRequest;
use App\Search\ProductSearch;
use App\Product;

use App\ProductImage;
use App\Tag;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Intervention\Image\Exception\NotFoundException;
use App\Exceptions\ProductNotFoundException;
use App\Domains\ProductRepository;


class ProductsController extends Controller
{
    private $repository;
    
    public function __construct(ProductRepository $repository){
        $this->repository = $repository;
    }
    
    public function index()    
    {
        $products = $this->repository->listaPaginada();
        return view('admin.product.index', compact('products'));
    }
    
    public function create()
    {
        $categories = Category::all();
        $unidades = config('enums.unidades');
        return view('admin.product.create', compact('categories', 'unidades'));
    }
    
    public function store(ProductRequest $request)
    {
        $saida = $this->repository->store($request);        
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.products.index');
    }
    
    public function edit($id){
        $categories = Category::all();
        $unidades = config('enums.unidades');
        $product = $this->repository->findByID($id);
        $tags = $product->tags->pluck('name')->toArray();
        $tags = implode(", ", $tags);
        return view('admin.product.edit', compact('product', 'categories','unidades', 'tags'));
    }
    
    public function update($id, ProductRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.products.index');
    }
    
    public function delete( $id)
    {
        $saida = $this->repository->delete($id);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.products.index');
    }
    
     
    
    
    /**
     exibe a listagem de imagens
     @param $id - id de product
     */
    public function images($id)
    {
        $product = $this->repository->findByID($id);
        $images = $product->images()->paginate(15);
        return view('admin.product.images', compact('images', 'product'));
    }
    
    /**
     criar imagem para produto
     @param $id - id de product
     */    
     public function createImage($id)
     {
         $product = $this->repository->findByID($id);
         return view('admin.product.create_image', compact('product'));
    }
    
    /**
     * salvar imagem de produto
     */
    public function storeImage(ProductImageRequest $request, $id, ProductImage $productImage)
    {
        $saida = $this->repository->storeImage($request, $id, $productImage);
        return response()->json($saida, $saida['statusCode']);
    }
    
    public function deleteImage($id,$product_id)
    {
        $saida = $this->repository->deleteImageByID($id);
        flash($saida['msg'], $saida['style']);
        return redirect(route('admin.product_images.index', ['id' => $product_id]));
    }
    
    public function consultarCodBarra($codBarra)
    {
        $saida = $this->repository->consultarCodBarra($codBarra);
//dd($saida);        
        return response()->json($saida, $saida['statusCode']);
    }
    
    /**
     * busca por id API
     * @param id integer
     * @return Product Json
     */
    public function consultarId($id)
    {
        $saida = $this->repository->consultarId($id);
        //dd($saida);
        return response()->json($saida, $saida['statusCode']);
    }
    
    
    /**
     * procura produto por diversos campos 
     * @param request [nome, marca, cod_barra]
     * @return array json
     */
     public function search(Request $request){
         $saida = $this->repository->search($request);         
         return response()->json($saida, $saida['statusCode']);
    }
}
