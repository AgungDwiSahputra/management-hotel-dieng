<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService
{

  private User $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function create($request): User
  {
    return $this->user->firstOrCreate($request);
  }

  public function createDeveloper($request): User
  {
    $user = $this->create($request);
    $user->assignRole(User::DEVELOPER);
    return $user;
  }

  public function get(): Collection
  {
    return $this->user->get();
  }

  public function getPaginate($count = 10): LengthAwarePaginator
  {
    return $this->user->paginate($count);
  }

  public function getDevelopers(): LengthAwarePaginator
  {
    return $this->user->role(User::DEVELOPER)->paginate();
  }

  // ADMIN
  public function getAdmins(): LengthAwarePaginator
  {
    return $this->user->role(User::ADMIN)->paginate();
  }
  public function getAdminById($id): User
  {
    return $this->user->role(User::ADMIN)->find($id);
  }
  public function createAdmin($request): User
  {
    $user = $this->create($request);
    $user->assignRole(User::ADMIN);
    return $user;
  }
  public function updateAdmin($id, $request): bool
  {
    $datas = [
      'name' => $request['name'],
      'email' => $request['email'],
      'email_verified_at' => now(),
    ];

    if (!empty($request['password'])) {
      $datas['password'] = bcrypt($request['password']);
    }

    $user = $this->getAdminById($id);
    if (!$user) {
      throw new \Exception('Admin not found');
    }
    return $user->update($datas);
  }
  public function deleteAdmin($id): bool
  {
    $user = $this->getAdminById($id);

    $product = FetchAPIDelete(env('URL_API') . '/api/v1/product/owner/' . $user->email);
    if (!$user) {
      throw new \Exception('Admin not found');
    }
    return $user->delete();
  }

  // PARTNER
  public function getPartners()
  {
    return $this->user->role(User::PARTNER)->get();
  }
  public function getPartnerById($id): User
  {
    return $this->user->role(User::PARTNER)->find($id);
  }
  public function createPartner($request): User
  {
    $user = $this->create($request);
    $user->assignRole(User::PARTNER);
    return $user;
  }
  public function updatePartner($id, $request): bool
  {
    $datas = [
      'name' => $request['name'],
      'email' => $request['email'],
      'email_verified_at' => now(),
    ];

    if (!empty($request['password'])) {
      $datas['password'] = bcrypt($request['password']);
    }

    $user = $this->getPartnerById($id);
    if (!$user) {
      throw new \Exception('Partner not found');
    }
    return $user->update($datas);
  }
  public function deletePartner($id): bool
  {
    $user = $this->getPartnerById($id);

    $product = FetchAPIDelete(env('URL_API') . '/api/v1/product/owner/' . $user->email);
    if (!$user) {
      throw new \Exception('Partner not found');
    }
    return $user->delete();
  }

  // COLLAB
  public function getCollabs()
  {
    return $this->user->role(User::COLLAB)->get();
  }
  public function getCollabById($id): User
  {
    return $this->user->role(User::COLLAB)->find($id);
  }
  public function createCollab($request): User
  {
    $user = $this->create($request);
    $user->assignRole(User::COLLAB);
    return $user;
  }
  public function updateCollab($id, $request): bool
  {
    $datas = [
      'name' => $request['name'],
      'email' => $request['email'],
      'email_verified_at' => now(),
    ];

    if (!empty($request['password'])) {
      $datas['password'] = bcrypt($request['password']);
    }

    $user = $this->getCollabById($id);
    if (!$user) {
      throw new \Exception('Collab not found');
    }
    return $user->update($datas);
  }
  public function deleteCollab($id): bool
  {
    $user = $this->getCollabById($id);

    $product = FetchAPIDelete(env('URL_API') . '/api/v1/product/owner/' . $user->email);
    if (!$user) {
      throw new \Exception('Collab not found');
    }
    return $user->delete();
  }

  public function findById($id): User
  {
    return $this->user->find($id);
  }

  public function update($id, $request): bool
  {
    if (!$request['password']) unset($request['password']);
    return $this->findById($id)->update($request);
  }

  public function delete($id): bool
  {
    return $this->findById($id)->delete();
  }
}
