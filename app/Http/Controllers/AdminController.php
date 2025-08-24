<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    private function getAllAdmins()
    {
        return $this->userService->getAdmins();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Admins = $this->getAllAdmins() ?? [];

        return view('admin.index', [
            'title' => 'Admins',
            'description' => 'Halaman untuk mengelola admin',
            'admins'=> $Admins,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create', [
            'title' => 'Create Admin',
            'description' => 'Halaman untuk membuat admin baru',
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
            'password_confirmation' => 'required',
        ], [
            'name.required' => 'Nama admin harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $datas = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'email_verified_at' => now(),
            'password' => bcrypt($validatedData['password']),
        ];

        try {
            $this->userService->createAdmin($datas);
        } catch (\Exception $e) {
            return redirect()->route('admin.create')->withErrors([
                'error' => 'Terjadi kesalahan saat membuat admin. Silakan coba lagi.',
            ]);
        }

        return redirect()->route('admin.index')->with([
            'success' => 'Admin berhasil dibuat',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $admin = $this->userService->getAdminById($id);

        $products = getProductsByOwner($admin) ?? array();
        // filter data array product hanya 'name, unit, harga_weekday, harga_weekend'
        $products = array_map(function ($product) {
            return [
                'id' => $product['id'],
                'name' => $product['name'],
                'unit' => $product['unit'],
                'harga_weekday' => $product['harga_weekday'],
                'harga_weekend' => $product['harga_weekend'],
            ];
        }, $products);

        return view('admin.show', [
            'title' => 'Admin Details',
            'description' => 'Halaman untuk mengelola admin',
            'admin'=> $admin,
            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $admin = $this->userService->getAdminById($id);

        return view('admin.show', [
            'title' => 'Admin Details',
            'description' => 'Halaman untuk mengelola admin',
            'admin'=> $admin
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
        ], [
            'name.required' => 'Nama admin harus diisi.',
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
            $this->userService->updateAdmin($id, $datas);
        } catch (\Exception $e) {
            return redirect()->route('admin.edit', $id)->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui admin. Silakan coba lagi.',
            ]);
        }

        return redirect()->route('admin.index')->with([
            'success' => 'Admin berhasil diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->userService->deleteAdmin($id);
        } catch (\Exception $e) {
            return redirect()->route('admin.index')->withErrors([
                'error' => 'Terjadi kesalahan saat menghapus admin. Silakan coba lagi.',
            ]);
        }
        return redirect()->route('admin.index')->with([
            'success' => 'Admin berhasil dihapus',
        ]);
    }
}
