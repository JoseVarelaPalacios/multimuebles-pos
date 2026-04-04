<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Mueble: {{ $producto->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('productos.update', $producto) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="nombre" value="Nombre del Mueble *" />
                            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $producto->nombre)" required />
                        </div>

                        <div>
                            <x-input-label for="categoria" value="Categoría *" />
                            <select name="categoria" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach(['Salas', 'Comedores', 'Recámaras', 'Oficina', 'Decoración'] as $cat)
                                    <option value="{{ $cat }}" {{ $producto->categoria == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="precio" value="Precio ($) *" />
                            <x-text-input id="precio" class="block mt-1 w-full" type="number" step="0.01" name="precio" :value="old('precio', $producto->precio)" required />
                        </div>

                        <div>
                            <x-input-label for="cantidad_stock" value="Stock *" />
                            <x-text-input id="cantidad_stock" class="block mt-1 w-full" type="number" name="cantidad_stock" :value="old('cantidad_stock', $producto->cantidad_stock)" required />
                        </div>

                        <div>
                            <x-input-label for="material" value="Material" />
                            <x-text-input id="material" class="block mt-1 w-full" type="text" name="material" :value="old('material', $producto->material)" />
                        </div>

                        <div>
                            <x-input-label for="color" value="Color" />
                            <x-text-input id="color" class="block mt-1 w-full" type="text" name="color" :value="old('color', $producto->color)" />
                        </div>
                        <div>
                            <x-input-label for="dimensiones" value="Dimensiones" />
                            <x-text-input id="dimensiones" class="block mt-1 w-full" type="text" name="dimensiones" :value="old('dimensiones', $producto->dimensiones)" placeholder="Ej. 200x150x80 cm" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="descripcion" value="Descripción Completa" />
                            <textarea name="descripcion" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 border-t pt-4">
                        <a href="{{ route('productos.index') }}" class="mr-4 text-gray-600">Cancelar</a>
                        <x-primary-button class="bg-indigo-600">Guardar Cambios</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>