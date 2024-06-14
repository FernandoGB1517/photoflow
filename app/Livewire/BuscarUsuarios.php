<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;



class BuscarUsuarios extends Component
{

    public $busca = "";
    public $resultados = [];
    public $selectedIndex = -1;
    public $selectedUsername = null;

    public function render()
    {
        return view('livewire.buscar-usuarios');
    }

    public function buscar()
    {
        // Verificar si hay al menos una letra ingresada en el campo de búsqueda
        if (strlen($this->busca) >= 1) {
            $query = '%' . $this->busca . '%';
            $this->resultados = User::where('username', 'like', $query)->get();
        } else {
            // Si no hay una letra ingresada, establecer los resultados como vacíos
            $this->resultados = [];
        }
    }

    public function IrAlPerfil($username)
    {
        // Redirigir al usuario al perfil utilizando el nombre de usuario
        return redirect()->route('posts.index', $username);
    }

    public function moverSeleccion($direction)
    {
        if (count($this->resultados) === 0) {
            return;
        }

        if ($direction === 'up') {
            $this->selectedIndex = ($this->selectedIndex === 0) ? count($this->resultados) - 1 : $this->selectedIndex - 1;
        } elseif ($direction === 'down') {
            $this->selectedIndex = ($this->selectedIndex === count($this->resultados) - 1) ? 0 : $this->selectedIndex + 1;
        }

        $this->selectedUsername = $this->resultados[$this->selectedIndex]['username'];
    }

    public function redirectToProfile()
    {
        if ($this->selectedUsername !== null) {
            return redirect()->route('posts.index', $this->selectedUsername);
        }
    }
}

