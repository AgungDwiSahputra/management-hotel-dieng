<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserService {

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

  public function createAdmin($request): User
  {
    $user = $this->create($request);
    $user->assignRole(User::ADMIN);
    return $user;
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
    if (!$user) {
        throw new \Exception('Partner not found');
    }
    return $user->delete();
  }

  public function get(): Collection
  {
    return $this->user->get();
  }

  public function getPaginate($count = 10): LengthAwarePaginator
  {
    return $this->user->paginate($count);
  }

  public function getAdmins(): LengthAwarePaginator
  {
    return $this->user->role(User::ADMIN)->paginate();
  }
  public function getDevelopers(): LengthAwarePaginator
  {
    return $this->user->role(User::DEVELOPER)->paginate();
  }
  public function getPartners()
  {
    return $this->user->role(User::PARTNER)->get();
  }
  public function getPartnerById($id): User
  {
    return $this->user->role(User::PARTNER)->find($id);
  }

  public function findById($id): User
  {
    return $this->user->find($id);
  }

  public function update($id, $request): bool
  {
    if(!$request['password']) unset($request['password']);
    return $this->findById($id)->update($request);
  }

  public function delete($id): bool
  {
    return $this->findById($id)->delete();
  }
}