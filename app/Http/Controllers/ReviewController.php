<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $isReply = $request->has('parent_id');

        $rules = [
            'rating' => $isReply ? 'nullable|integer|min:1|max:5' : 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:reviews,id',
        ];

        $messages = [
            'rating.required' => 'Debes seleccionar una calificación para tu comentario.',
            'comment.required' => 'El comentario no puede estar vacío.',
        ];

        $request->validate($rules, $messages);

        $product->reviews()->create([
            'user_id' => Auth::id(),
            'rating' => $isReply ? ($request->rating ?? 5) : $request->rating,
            'comment' => $request->comment,
            'parent_id' => $request->parent_id,
        ]);

        // Update product statistics (only for top-level reviews)
        $this->updateProductStats($product);

        return redirect()->route('product.show', $product->id)->with('success', $isReply ? 'Respuesta enviada.' : '¡Gracias por tu comentario!');
    }

    public function destroy(Review $review)
    {
        $product = $review->product;
        $review->delete();

        // Update product statistics after deletion
        $this->updateProductStats($product);

        // Redirect explicitly to the product page to ensure we stay on the same page
        return redirect()->route('product.show', $product->id)
            ->with('success', 'Reseña eliminada correctamente.');
    }

    protected function updateProductStats(Product $product)
    {
        // Solo promediar reseñas principales (sin parent_id)
        $query = $product->reviews()->whereNull('parent_id');
        $count = $query->count();
        $avg = $query->avg('rating');
        
        $product->update([
            'rating' => $avg ?? 0,
            'reviews_count' => $count,
        ]);
    }
}
