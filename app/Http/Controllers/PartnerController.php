<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    private function getAllPartners()
    {
        return $this->userService->getPartners();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Partners = $this->getAllPartners() ?? [];

        return view('partner.index', [
            'title' => 'Partners',
            'description' => 'Halaman untuk mengelola partner',
            'partners'=> $Partners,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('partner.create', [
            'title' => 'Create Partner',
            'description' => 'Halaman untuk membuat partner baru',
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
            'name.required' => 'Nama partner harus diisi.',
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
            $this->userService->createPartner($datas);
        } catch (\Exception $e) {
            return redirect()->route('partner.create')->withErrors([
                'error' => 'Terjadi kesalahan saat membuat partner. Silakan coba lagi.',
            ]);
        }

        return redirect()->route('partner.index')->with([
            'success' => 'Partner berhasil dibuat',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $partner = $this->userService->getPartnerById($id);

        $products = getProductsByOwner($partner) ?? array();
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

        return view('partner.show', [
            'title' => 'Partner Details',
            'description' => 'Halaman untuk mengelola partner',
            'partner'=> $partner,
            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $partner = $this->userService->getPartnerById($id);

        return view('partner.show', [
            'title' => 'Partner Details',
            'description' => 'Halaman untuk mengelola partner',
            'partner'=> $partner
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
            'name.required' => 'Nama partner harus diisi.',
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
            $this->userService->updatePartner($id, $datas);
        } catch (\Exception $e) {
            return redirect()->route('partner.edit', $id)->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui partner. Silakan coba lagi.',
            ]);
        }

        return redirect()->route('partner.index')->with([
            'success' => 'Partner berhasil diperbarui',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $this->userService->deletePartner($id);
        } catch (\Exception $e) {
            return redirect()->route('partner.index')->withErrors([
                'error' => 'Terjadi kesalahan saat menghapus partner. Silakan coba lagi.',
            ]);
        }
        return redirect()->route('partner.index')->with([
            'success' => 'Partner berhasil dihapus',
        ]);
    }
}
