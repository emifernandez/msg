<?php

namespace App\Models;

use App\Notifications\PasswordReset;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    private $pass;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification($this, $this->getPass()));
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class)->withTimestamps();
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'user_id');
    }

    public function authorizeRoles($roles)
    {
        abort_unless($this->hasAnyRole($roles), 401);
        return true;
    }
    public function hasAnyRole($roles)
    {
        if (isset($roles)) {
            if ($roles->count() > 1) {
                foreach ($roles as $role) {
                    if ($this->hasRole($role)) {
                        return true;
                    }
                }
            } else {
                if ($this->hasRole($roles)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        if ($this->roles()->where('roles.id', $role->id)->first()) {
            return true;
        }
        return false;
    }

    public function isAdmin()
    {
        return $this->roles->first()->nombre == 'admin';
    }

    public function getPermisos()
    {
        return  $this->isAdmin() ? Acceso::where('modulo', '!=', null)->get() : $this->roles->first()->accesos;
    }

    public function getPermiso($acceso)
    {
        return $this->getPermisos()->where('nombre', $acceso)->first();
    }

    public function getMenu()
    {
        $accesos = Acceso::all();
        $permisos = $this->getPermisos();
        $menu = collect([]);
        foreach ($accesos as $acceso) {
            if ($permisos->contains($acceso)) {
                $modulo = $accesos->where('id', $acceso->modulo)->first();
                if ($menu->contains($modulo)) {
                    $menu->where('id', $modulo->id)->first()->submenus->push($acceso);
                } else {
                    $menu->push($modulo);
                    if (isset($modulo->id)) {
                        $submenus = collect([]);
                        $submenus->push($acceso);
                        $menu->where('id', $modulo->id)->first()->submenus = $submenus;
                    }
                }
            }
        }
        return $menu;
    }

    public function generatePassword()
    {
        $arr = explode("@", $this->email, 2);
        $string = $arr[0];
        return substr(md5($string), 10, 10);
    }

    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    public function getPass()
    {
        return isset($this->pass) ? $this->pass : $this->generatePassword();
    }
}
