<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CollabService;
use App\Services\UserService;
use Illuminate\Http\Request;

class CollabController extends Controller
{
    private UserService $userService;
    private CollabService $collabService;

    public function __construct(UserService $userService, CollabService $collabService)
    {
        $this->userService = $userService;
        $this->collabService = $collabService;
    }
    
    private function getAllCollabs()
    {
        return $this->userService->getCollabs();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Collabs = $this->getAllCollabs() ?? [];

        return view('collab.index', [
            'title' => 'Collabs',
            'description' => 'Halaman untuk mengelola collab',
            'collabs'=> $Collabs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = getAllProducts() ?? array();

        return view('collab.create', [
            'title' => 'Create Collab',
            'description' => 'Halaman untuk membuat collab baru',
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'permission_product' => 'nullable|array',
            'permission_product.*' => 'nullable',
        ], [
            'name.required' => 'Nama collab harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            $user = $this->userService->createCollab([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'email_verified_at' => now(),
                'password' => bcrypt($validatedData['password']),
            ]);
            if (isset($validatedData['permission_product'])) {
                foreach ($validatedData['permission_product'] as $productId) {
                    $this->collabService->createCollabPermission([
                        'user_id' => $user->id,
                        'product_id' => $productId,
                    ]);
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('collab.create')->withErrors([
                'error' => 'Terjadi kesalahan saat membuat collab. Silakan coba lagi.',
            ]);
        }

        return redirect()->route('collab.index')->with([
            'success' => 'Collab berhasil dibuat',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $collab = $this->userService->getCollabById($id);

        $products = getAllProducts() ?? array();

        $collab_permissions = $this->collabService->getCollabPermissions()
            ->where('user_id', $collab->id)
            ->pluck('product_id')
            ->toArray();

        return view('collab.show', [
            'title' => 'Collab Details',
            'description' => 'Halaman untuk mengelola collab',
            'collab'=> $collab,
            'collab_permissions' => $collab_permissions,
            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $collab = $this->userService->getCollabById($id);

        $products = getAllProducts() ?? array();

        $collab_permissions = $this->collabService->getCollabPermissions()
            ->where('user_id', $collab->id)
            ->pluck('product_id')
            ->toArray();

        return view('collab.show', [
            'title' => 'Collab Details',
            'description' => 'Halaman untuk mengelola collab',
            'collab'=> $collab,
            'collab_permissions' => $collab_permissions,
            'products' => $products
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'password_confirmation' => 'nullable',
            'permission_product' => 'nullable|array',
            'permission_product.*' => 'nullable',
        ], [
            'name.required' => 'Nama collab harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $datas = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'email_verified_at' => now(),
        ];

        if (!empty($validatedData['password'])) {
            $datas['password'] = bcrypt($validatedData['password']);
        }

        try {
            $this->userService->updateCollab($id, $datas);

            // Update permissions
            if (isset($validatedData['permission_product'])) {
                // Delete existing permissions
                $this->collabService->deleteCollabPermission($id);
                // Create new permissions
                foreach ($validatedData['permission_product'] as $productId) {
                    $this->collabService->createCollabPermission([
                        'user_id' => $id,
                        'product_id' => $productId,
                    ]);
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('collab.edit', $id)->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui collab. Silakan coba lagi.',
            ]);
        }

        return redirect()->route('collab.index')->with([
            'success' => 'Collab berhasil diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->userService->deleteCollab($id);
        } catch (\Exception $e) {
            return redirect()->route('collab.index')->withErrors([
                'error' => 'Terjadi kesalahan saat menghapus collab. Silakan coba lagi.',
            ]);
        }
        return redirect()->route('collab.index')->with([
            'success' => 'Collab berhasil dihapus',
        ]);
    }
}
