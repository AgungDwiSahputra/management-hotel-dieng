<?php

namespace App\Services;

use App\Models\CollabPermission;
use Illuminate\Database\Eloquent\Collection;

class CollabService
{
    /**
     * Create a new collab permission.
     *
     * @param  array  $data
     * @return \App\Models\CollabPermission
     */
    public function createCollabPermission(array $data): CollabPermission
    {
        return CollabPermission::create($data);
    }

    /**
     * Get all collab permissions.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCollabPermissions(): Collection
    {
        return CollabPermission::all();
    }

    /**
     * Get a collab permission by id.
     *
     * @param  int  $id
     * @return \App\Models\CollabPermission|null
     */
    public function getCollabPermissionById(int $id): ?CollabPermission
    {
        return CollabPermission::find($id);
    }

    /**
     * Update a collab permission.
     *
     * @param  int  $id
     * @param  array  $data
     * @return bool
     */
    public function updateCollabPermission(int $id, array $data): bool
    {
        return CollabPermission::where('id', $id)->update($data);
    }

    /**
     * Delete a collab permission.
     *
     * @param  int  $id
     * @return bool
     */
    public function deleteCollabPermission(int $user_id): bool
    {
        return (bool) CollabPermission::where('user_id', $user_id)->delete();
    }
}
?>