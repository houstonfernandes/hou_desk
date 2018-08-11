<?php
namespace App\Domains;

use App\Product;
use App\ProductImage;
use App\Tag;
use App\Search\ProductSearch;
use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\DadosInvalidosException;
use App\Exceptions\ProductNotFoundException;
use Intervention\Image\Facades\Image;
use App\Exceptions\NaoPodeExcluirException;

class ProductRepository extends BaseRepository
{
    protected $modelClass = Product::class;
    protected $model;
    protected $orderBy = 'nome';
    protected $orderByDirection = 'asc';
    protected $perPage = 15;    
    
    /**
     * armazena produto
     * @param FormRequest $request
     * @return array 'sucesso', 'id','erro'
     */
    public function store(FormRequest $request)
    {
        try{
            $input = $request->all();
            $product = $this->model->fill($input);//dados do request passados para o model
            $product->save();//persiste no banco
            
            $tagNames = explode(',', $input['tags']);
            
            $tagIds = $this->storeTags($tagNames, $product->id);//armazena novas tags e mantem as atuais
//dd($tagIds);            
            return ['msg' => 'Produto criado com sucesso. - ' . $product->nome, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar produto', 'style' =>'danger'];            
        }
        
    }
    
    /**
     * armazena tags e retorna array com as ids das tags
     * @param array $tagNames
     * @return array tagIds
     */
    private function storeTags(array $tagNames, $productId)
    {
        $tagIds = [];
        if(count($tagNames > 0)){
            foreach($tagNames as $tagName){
                $tagName = trim($tagName);
                if ($tagName=='') continue;
                $tag = Tag::firstOrCreate(array('name' => $tagName));//cria se não existir
                $tagIds[] = $tag->id ;
            }
            $product = $this->findByID($productId);
            $product->tags()->sync($tagIds);//só mantén relacionadas as atuais
        }
        return $tagIds;
    }
    
    public function update($id, FormRequest $request)
    {
        try{
            $input = $request->all();
            $product = $this->findByID($id);
            $product->update($input);
            
            $tagNames = explode(',', $input['tags']);
            $tagIds = $this->storeTags($tagNames, $product->id);//armazena novas tags e mantem as atuais
            return ['msg' => 'Produto atualizado com sucesso. - ' . $product->nome, 'style' =>'success'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao atualizar produto', 'style' =>'danger'];
        }
    }
    
    public function delete($id)
    {
        try{
            $product = $this->findByID($id);
            $nome = $product->nome;
            if ($this->podeExcluir($product)){
                //imagens no db estao delete cascade
                $imagens = $product->images;
                foreach ($imagens as $imagem){//remover imagens de produto
                    $this->deleteImagem($imagem);
                }
                $product->tags()->sync([]);//remove em pivot
                $product->delete();                
                $msg = 'Produto ' . $nome . ' excluido com sucesso.';
                return ['msg' => $msg, 'style' =>'success'];
            }
            else {
                throw new NaoPodeExcluirException('Produto ' . $nome .' não pode ser excluído, pois possui pedidos.');
            }
        }
        catch (NaoPodeExcluirException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }        
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao excluir produto', 'style' =>'danger'];
        }
    }    
    
    private function podeExcluir(Product $produto)
    {
        // @todo verificar compras, ajustes, devolucoes *******
        $qtdItemPedidos = count($produto->itemPedidos);        
        return ($qtdItemPedidos == 0)? true:false;
    }
        
    /**
     * salva imagem de produto
     */
    public function storeImage(FormRequest $request, $id, ProductImage $productImage)
    {
        $saida = [];
        try{
            if ($request->hasFile('arquivo')) {
                $file = $request->file('arquivo');
                //dd($file);
                $filename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                
                if(!in_array($extension, config('uploads.image_types'))){//     extensoes Validas
                    throw new DadosInvalidosException("Extensão não permitida - " . $extension);                
                }
                
                //gravar no banco
                $image = $productImage::create([
                    'product_id' => $id,
                    'extension' => $extension
                ]);
                
                $newFileNameThumbnail = $image->id . '_thumbnail.' . $extension;
                $newFileName = $image->id . '.' . $extension;
                
                //  redimensiona imagem
                $imgMenor = Image::make($file->getRealPath());
                $imgMenor->resize(100, 100, function ($constraint) {
                    $constraint->aspectRatio();
                })->stream();
                //->save($destinationPath . DIRECTORY_SEPARATOR . $newFileName);
                
                //armazena no storage
                Storage::disk('product_images')->put($newFileNameThumbnail, $imgMenor); //File::get($file));//nome do arquivo id_imagem.extensao
                
                //  redimensiona imagem
                $imgMaior = Image::make($file->getRealPath());
                $imgMaior->resize(800, 800, function ($constraint) {
                    $constraint->aspectRatio();
                })->stream();
                //armazena no storage
                Storage::disk('product_images')->put($newFileName, $imgMaior); //File::get($file));//nome do arquivo id_imagem.extensao
                
                //prepara saida
                $saida['file'] = [
                    'fileName' =>$filename,
                    'size' => Storage::disk('product_images')->size($newFileName),
                    'url' => Storage::disk('product_images')->url($newFileName),
                    'size_thumbnail' => Storage::disk('product_images')->size($newFileNameThumbnail),
                    'url_thumbnail' => Storage::disk('product_images')->url($newFileNameThumbnail),
                    
                ];
                $saida['msg'] = 'armazenado no storage';
                $saida['statusCode'] = 200;
                $saida['style'] = 'success';                
            }
            else{
                throw new DadosInvalidosException("Nenhum arquivo recebido.");
            }
        }
        catch(DadosInvalidosException $e){
            $saida['msg'] = $e->getMessage();
            $saida['errors']['arquivo'] = [$e->getMessage()];
            $saida['statusCode'] = $e->getCode();
            $saida['style'] = 'error';
        }
        catch (\Exception $e){
            $saida['msg'] = 'Erro no servidor';
            $saida['statusCode'] = $e->getCode();
            $saida['style'] = 'error';
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
        }
        return $saida;
    }
    
    /**
     * deleta imagem de produto por id
     * @param integer $id
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function deleteImageByID($id)
    {
        try{
            $image = ProductImage::find($id);
            $imgName = $image->id . '.' . $image->extension;
            $this->deleteImagem($image);
            $saida = ['msg'=>'Imagem excluida. '. $imgName, 'style' =>'success'];
        }catch (\Exception $e){
            $saida  = ['msg' => 'falha ao excluir imagem', 'style' =>'danger'];
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
        }
        return $saida;        
    }
    
    /*
     * deleta a imagem de produto no storage e banco
     */
    private function deleteImagem(ProductImage $image)
    {
        $imgMaior = $image->id . '.' . $image->extension;
        $imgMenor = $image->id . '_thumbnail.' . $image->extension;
        
        if(Storage::disk('product_images')->exists($imgMaior)){
            Storage::disk('product_images')->delete($imgMaior);//remover arquivo
        }
        if(Storage::disk('product_images')->exists($imgMenor)){
            Storage::disk('product_images')->delete($imgMenor);//remover arquivo
        }
        $image->delete();//remove imagem no banco
    }
    
    /*
     * consulta produto por codigo de barras
     */
    public function consultarCodBarra($codBarra)
    {
        $saida=[];
        try{
            $produto = $this->scopeCodBarra($codBarra);
            $saida = [
                'msg' =>'Produto encontrado.',
                'produto' => $produto,
                'statusCode' => 200
            ];
        }
        catch (ProductNotFoundException $e){
            $saida = [
                'msg' => $e->notFound($codBarra),
                'statusCode' => $e->getCode()                
            ];
        }
        catch (\Exception $e){
            $saida = [
                'msg' => 'Erro no servidor.',
                'statusCode' => $e->getCode()
            ];            
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
        }
        return $saida;
    }    
    
    /*
     * consulta produto por ID API
     */
    public function consultarId($id)
    {
        $saida=[];
        try{
            $produto = $this->findByID($id);
            $saida = [
                'msg' =>'Produto encontrado.',
                'produto' => $produto,
                'statusCode' => 200
            ];
        }
        catch (ProductNotFoundException $e){
            $saida = [
                'msg' => $e->notFound($id),
                'statusCode' => $e->getCode()
            ];
        }
        catch (\Exception $e){
            $saida = [
                'msg' => 'Erro no servidor.',
                'statusCode' => $e->getCode()
            ];
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
        }
        return $saida;
    }   
    
    /**
     * procura produto por diversos campos
     * @param request [nome, marca, cod_barra]
     * @return array json
     */
    public function search(Request $request)
    {
        $saida =[];
        try{
            $productsQuery = ProductSearch::apply($request)
                ->orderBy($this->orderBy, $this->orderByDirection);
            $produtos = $productsQuery->get();
            if($produtos->count()==0){
                throw new ProductNotFoundException('Produto não encontrado.');
            }
            
            foreach ($produtos as $produto){
                $this->adicionarUrlImagem($produto);
            }
            
            $saida = [
                'msg' =>'Produto encontrado.',
                'produtos' => $produtos,
                'statusCode' => 200
            ];            
        }
        catch (ProductNotFoundException $e){
            $saida = [
                'msg' => $e->getMessage(),
                'statusCode' => $e->getCode()
            ];
            
        }
        catch (\Exception $e){
            $saida = [
                'msg' => $e->getMessage(),
                'statusCode' => $e->getCode()
            ];
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
        }
        return $saida;            
    }
    
        
    /**
     * adiciona a url da imagem ao produto      
     * @param Product $produto referencia
    */
    
    public function adicionarUrlImagem(Product &$produto){
        $imagem = $produto->firstImageName();
        $urlImagem = null;
        $urlImagemThumbnail = null;
        if(Storage::disk('product_images')->exists($imagem[0])){
            $urlImagem = Storage::disk('product_images')->url($imagem[0]);
        }
        if(Storage::disk('product_images')->exists($imagem[1])){
            $urlImagemThumbnail = Storage::disk('product_images')->url($imagem[1]);
        }
        $produto->urlImagem = $urlImagem;
        $produto->urlImagemThumbnail = $urlImagemThumbnail;        
    }
    
    /**
     * consulta produto pelo codigo de barras
     * @param $query
     * @return Product
     */
    public function scopeCodBarra($codBarra)
    {
        $query = $this->newQuery();
        $query->where('cod_barra', '=', $codBarra);        
        $produto = $query->first();
        if($produto){
            $this->adicionarUrlImagem($produto);
        }
        else{
            throw new ProductNotFoundException();
        }
        return $produto;
    }
    
}