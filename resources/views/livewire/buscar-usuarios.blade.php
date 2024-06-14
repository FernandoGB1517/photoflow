<div wire:keydown.window.arrow-up.prevent="moverSeleccion('up')" 
    wire:keydown.window.arrow-down.prevent="moverSeleccion('down')" 
    wire:keydown.enter.prevent="redirectToProfile">

    <div class="flex gap-2 flex-col" style="position: relative;">
        <input wire:model="busca" wire:keyup="buscar" type="text" class="border w-full px-3 py-2 pl-2" placeholder="Buscar Usuarios..." style="padding-right: 30px;">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
          
        
        <ul style="padding: 0; margin: 0; background-color: white; position: absolute; z-index: 999; top: calc(100% + 5px); left: 0; right: 0; list-style: none;">
            @foreach ($resultados as $key => $user)
                <li 
                    wire:click="IrAlPerfil('{{ $user->username }}')" 
                    wire:mouseover="$set('selectedIndex', {{ $key }})"
                    class="hover:bg-purple-200 cursor-pointer {{ $selectedIndex === $key ? 'bg-purple-200' : '' }} {{ $selectedIndex === $key ? 'text-black' : '' }}"
                    style="border-bottom: 1px solid #ccc; line-height: 40px; padding: 0 10px; ">

                    {{ $user->username }}
                </li>
            @endforeach
        </ul>
        
    </div>
</div>








