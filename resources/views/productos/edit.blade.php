<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Mueble: {{ $producto->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                        <div class="md:col-span-2 bg-gray-50 p-6 rounded-md border border-gray-200 mt-4">
                            <x-input-label value="Imagen del Mueble" class="font-bold text-indigo-700 mb-4" />
                            
                            <div class="flex flex-col md:flex-row items-center gap-6">
                                <div class="flex-shrink-0">
                                    @if($producto->imagen)
                                        <p class="text-xs text-gray-500 mb-2 uppercase font-bold text-center">Imagen Actual</p>
                                        <img src="{{ asset('storage/' . $producto->imagen) }}" class="h-32 w-32 object-cover rounded-lg shadow-md border-2 border-white">
                                    @else
                                        <div class="h-32 w-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-xs text-center p-2">
                                            Sin imagen<br>registrada
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-grow w-full">
                                    <x-input-label for="imagen" value="¿Deseas cambiar la imagen?" class="text-sm" />
                                    <input id="imagen" type="file" name="imagen" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer" accept="image/jpeg, image/png, image/jpg">
                                    <p class="text-xs text-gray-400 mt-2 italic">Selecciona un archivo solo si quieres reemplazar la foto actual. Máximo 2MB.</p>
                                    <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        </div>

                    <div class="flex items-center justify-end mt-6 border-t pt-4">
                        <a href="{{ route('productos.index') }}" class="mr-4 text-gray-600 font-medium hover:text-gray-900 transition">Cancelar</a>
                        <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">Guardar Cambios</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputImagen = document.getElementById('imagen');
            
            inputImagen.addEventListener('change', function() {
                const archivo = this.files[0];
                
                if (archivo) {
                    const tamañoMaximo = 2 * 1024 * 1024; // 2 MB en bytes
                    
                    if (archivo.size > tamañoMaximo) {
                        alert("⚠️ ¡ALTO AHÍ!\n\nLa imagen que intentas subir es muy pesada (" + (archivo.size / 1024 / 1024).toFixed(2) + " MB).\nEl tamaño máximo permitido es de 2 MB para no saturar el sistema.\n\nPor favor, elige una imagen más ligera.");
                        this.value = ''; // Limpiamos el input para evitar que se envíe
                    }
                }
            });
        });
    </script>
</x-app-layout>