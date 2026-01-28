<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SermonResource;
use App\Http\Resources\SermonCollection;
use App\Models\Sermon;
use Illuminate\Http\Request;

class SermonController extends Controller
{
    /**
     * Get latest 3 sermons
     */
    public function latest()
    {
        $sermons = Sermon::with(['pastor', 'tags', 'author'])
            ->orderBy('sermon_date', 'desc')
            ->take(3)
            ->get();

        return SermonResource::collection($sermons);
    }

    /**
     * Get paginated sermons
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');
        
        $query = Sermon::with(['pastor', 'tags', 'author'])
            ->orderBy('sermon_date', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhereHas('pastor', function ($q) use ($search) {
                      $q->where('name', 'ilike', "%{$search}%");
                  });
            });
        }
            
        $sermons = $query->paginate($perPage);

        return new SermonCollection($sermons);
    }

    /**
     * Get sermon detail by UUID or slug
     */
    public function show($identifier)
    {
        // Check if identifier is a valid UUID
        $isUuid = preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $identifier);
        
        // Query by UUID or slug based on format
        $sermon = Sermon::with(['pastor', 'tags', 'author'])
            ->where($isUuid ? 'uuid' : 'slug', $identifier)
            ->first();

        if (!$sermon) {
            return response()->json([
                'success' => false,
                'message' => 'Sermon not found',
            ], 404);
        }

        return new SermonResource($sermon);
    }
}
