<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CollabPermission;
use App\Models\User;
use Illuminate\Http\Request;

class ProductUserController extends Controller
{
    /**
     * Get users connected to a specific product.
     *
     * @param string $id Product ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersByProduct($id)
    {
        // Get product data from external API
        $product = getProductById($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $connectedUsers = [];

        // Find owner user (likely partner)
        if (isset($product['owner'])) {
            $ownerUser = User::where('email', $product['owner'])->first();
            if ($ownerUser) {
                $connectedUsers[] = [
                    'id' => $ownerUser->id,
                    'name' => $ownerUser->name,
                    'email' => $ownerUser->email,
                    'roles' => $ownerUser->getRoleNames(),
                ];
            }
        }

        // Find collab users with permission to this product
        $collabUserIds = CollabPermission::where('product_id', $id)->pluck('user_id');
        $collabUsers = User::whereIn('id', $collabUserIds)->get();

        foreach ($collabUsers as $user) {
            $connectedUsers[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
            ];
        }

        // Find users with roles that have general access to all products (admin and developer)
        $generalUsers = User::role(['admin', 'developer'])->get();

        foreach ($generalUsers as $user) {
            $connectedUsers[] = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'roles' => $user->getRoleNames(),
            ];
        }

        return response()->json([
            'product_id' => $id,
            'product_name' => $product['name'] ?? 'Unknown',
            'connected_users' => $connectedUsers,
        ]);
    }
}