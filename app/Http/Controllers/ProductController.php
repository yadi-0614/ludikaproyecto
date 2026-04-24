<?php

namespace App\Http\Controllers;

// use App\Http\Requests\ProductStoreRequest;
// use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Services\FileService;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
// use Illuminate\View\View;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }
    public function index(Request $request)
    {
        // $products = Product::all();

        return view("products.index", [
            "products" => collect(),
            "categories" => Category::all(),
        ]);
    }

    /**
     * Display paginated products for the welcome page
     */
    public function welcome(Request $request)
    {
        $search = $request->input('search', '');
        $selected_category = $request->input('category', '');

        $query = Product::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function ($cq) use ($search) {
                      $cq->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($selected_category) {
            $query->where('category_id', $selected_category);
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $categories = Category::withCount('products')->get();

        return view("welcome-simple", compact('products', 'search', 'categories', 'selected_category'));
    }

    public function create(Request $request)
    {
        $categories = Category::all();
        return view("products.form", compact('categories'));
    }

    /**
     * Muestra el detalle público de un producto (accesible sin autenticación)
     */
    public function show(Product $product)
    {
        $product->load(['reviews' => function($query) {
            $query->whereNull('parent_id')->with('user', 'replies.user')->latest();
        }]);
        return view('products.show', compact('product'));
    }

    public function store(Request $request)
    {
        try {
            // Debug: Verificar si hay archivo
            Log::info("Store method called");
            Log::info("All request data:", $request->all());
            Log::info("All files:", $request->allFiles());
            Log::info(
                "Has file image: " .
                ($request->hasFile("image") ? "YES" : "NO"),
            );
            if ($request->hasFile("image")) {
                $file = $request->file("image");
                Log::info(
                    "File info: " .
                    json_encode([
                        "name" => $file->getClientOriginalName(),
                        "size" => $file->getSize(),
                        "mime" => $file->getMimeType(),
                        "valid" => $file->isValid(),
                        "error" => $file->getError(),
                    ]),
                );
            }

            // validar los inputs del request (sin validación de imagen por ahora)
            $validated = $request->validate([
                "name" => "required|string|max:40",
                "price" => "required|numeric|min:1|max:9999999",
                "stock" => "required|integer|min:0",
                "description" => "required|string",
                "category_id" => "nullable", // Se valida manualmente o se acepta 'new'
                "new_category" => "required_if:category_id,new|nullable|string|max:255",
            ]);

            if (!empty($validated['new_category'])) {
                $category = Category::firstOrCreate([
                    'name' => $validated['new_category']
                ]);
                $validated['category_id'] = $category->id;
            }

            // Si se seleccionó 'new' pero no se creó (no debería pasar por validation required_if)
            // o simplemente limpiar el valor para evitar error de tipo en el modelo
            if (($validated['category_id'] ?? '') === 'new') {
                $validated['category_id'] = null;
            }

            unset($validated['new_category']);

            // No agregar imagen al validated array ya que no está validada
            // La procesaremos por separado

            $id = $request->input("id", null);

            if ($id) {
                // actualizar producto existente
                $product = Product::findOrFail($id);
                $oldImage = $product->image;

                // Manejar eliminación de imagen actual si se solicita
                if ($request->input('remove_image') === '1' && !$request->hasFile('image')) {
                    if ($oldImage) {
                        $this->fileService->delete($oldImage);
                    }
                    $product->image = null;
                }

                // Actualizar campos básicos
                $product->fill($validated);
                $product->save();

                // Procesar nueva imagen si se subió
                if ($request->hasFile("image")) {
                    $uploadResult = $this->fileService->upload(
                        $request->file("image"),
                        "products",
                    );

                    if ($uploadResult["success"]) {
                        $product->image = $uploadResult["path"];
                        $product->save();

                        // Eliminar imagen anterior si existe
                        if ($oldImage) {
                            $this->fileService->delete($oldImage);
                        }
                    }
                }
            } else {
                // agregar producto nuevo (sin imagen primero)
                $product = Product::create($validated);

                // Procesar imagen para producto nuevo
                if ($request->hasFile("image")) {
                    Log::info("Processing new product image");
                    $uploadResult = $this->fileService->upload(
                        $request->file("image"),
                        "products",
                    );

                    Log::info("Upload result: " . json_encode($uploadResult));

                    if ($uploadResult["success"]) {
                        $product->image = $uploadResult["path"];
                        $product->save();
                        Log::info(
                            "Image path saved: " . $uploadResult["path"],
                        );
                    } else {
                        Log::error(
                            "Image upload failed: " . $uploadResult["message"],
                        );
                    }
                }
            }
            return redirect()
                ->route("products.index")
                ->with("success", "Producto registrado exitosamente.");
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with("error", $e->getMessage());
        }
    }

    public function edit(Request $request, Product $product)
    {
        $categories = Category::all();
        return view("products.form", [
            "product" => $product,
            "categories" => $categories,
        ]);
    }

    // public function update(ProductUpdateRequest $request, Product $product)
    // {
    //     $product->update($request->validated());

    //     session()->flash('Product.name', $product->name);

    //     return redirect()->route('products.index');
    // }

    public function destroy(Request $request, Product $product)
    {
        // Eliminar imagen si existe
        if ($product->image) {
            $this->fileService->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route("products.index")
            ->with("success", "Producto eliminado exitosamente!!!");
    }

    public function dataTable(Request $request)
    {
        // Validar params de DataTables (opcional, pero seguro)
        $request->validate([
            "draw" => "integer",
            "start" => "integer|min:0",
            "length" => "integer|min:1|max:100",
            "search.value" => "nullable|string|max:255",
        ]);

        // Query base
        $query = Product::with('category');

        // Búsqueda en varios campos
        $search = $request->input("search.value");
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where("name", "like", "%{$search}%")
                    ->orWhere("description", "like", "%{$search}%")
                    ->orWhere("price", "like", "%{$search}%");
            });
        }

        // Total de registros sin filtros (para recordsTotal)
        $totalRecords = Product::count();

        // Registros filtrados (recordsFiltered)
        $filteredRecords = clone $query;
        $recordsFiltered = $filteredRecords->count();

        // get y set Ordenación (columna y dirección)
        $columns = ["name", "description", "price", "stock", "id"]; // Orden de columnas en tabla
        $orderColumn = $request->input("order.0.column", 0);
        $orderDir = $request->input("order.0.dir", "asc");
        $query->orderBy($columns[$orderColumn] ?? "id", $orderDir);

        // Paginación
        $start = $request->input("start", 0);
        $length = $request->input("length", 10);
        $data = $query->skip($start)->take($length)->get();

        // Formatear los datos para el componente DataTables
        // TODO: Formatear del lado del cliente
        $data = $data->map(function ($product) {
            $imageHtml = "";
            if (
                $product->image &&
                Storage::disk("images")->exists($product->image)
            ) {
                $imageHtml =
                    '<img src="' .
                    asset("images/" . $product->image) .
                    '" alt="' .
                    $product->name .
                    '" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">';
            } else {
                $imageHtml =
                    '<div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 4px;"><i class="bi bi-image text-muted"></i></div>';
            }

            return [
                "image" => $imageHtml,
                "name" => $product->name,
                "category" => $product->category ? $product->category->name : '<span class="text-muted">Sin categoría</span>',
                "description" => $product->description,
                "price" => '$' . number_format($product->price, 2),
                "stock" => $product->stock,
                "actions" =>
                    '<div class="d-flex flex-column gap-2" style="width: 85px; margin-left: auto;">
                        <button class="btn-edit w-100 justify-content-center" onclick="execute(\'/products/' . $product->id . '/edit\')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                            Editar
                        </button>
                        <button class="btn-del w-100 justify-content-center" onclick="deleteRecord(\'/products/' . $product->id . '\')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            Eliminar
                        </button>
                    </div>',
            ];
        });

        // Respuesta JSON en formato requerido por DataTables
        return response()->json([
            "draw" => (int) $request->input("draw"), // Eco del draw para sync
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data,
        ]);
    }

    /**
     * Descargar imagen de producto
     */
    public function downloadImage(Product $product)
    {
        if (!$product->image) {
            abort(404, "Imagen no encontrada");
        }

        try {
            return $this->fileService->download(
                $product->image,
                "producto_" . $product->id . "_" . basename($product->image),
            );
        } catch (\Exception $e) {
            abort(404, "Archivo no encontrado");
        }
    }
}
