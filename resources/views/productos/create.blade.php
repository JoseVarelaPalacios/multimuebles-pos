<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Añadir Nuevo Mueble
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="md:col-span-2 border-b pb-4 mb-2">
                                <h3 class="text-lg font-medium text-gray-900">Información Principal</h3>
                                <p class="text-sm text-gray-500">Datos requeridos para el punto de venta.</p>
                            </div>

                            <div>
                                <x-input-label for="nombre" value="Nombre del Mueble *" />
                                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required autofocus />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="categoria" value="Categoría *" />
                                <select id="categoria" name="categoria" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="" disabled selected>Selecciona una opción</option>
                                    <option value="Salas" {{ old('categoria') == 'Salas' ? 'selected' : '' }}>Salas</option>
                                    <option value="Comedores" {{ old('categoria') == 'Comedores' ? 'selected' : '' }}>Comedores</option>
                                    <option value="Recámaras" {{ old('categoria') == 'Recámaras' ? 'selected' : '' }}>Recámaras</option>
                                    <option value="Oficina" {{ old('categoria') == 'Oficina' ? 'selected' : '' }}>Oficina</option>
                                    <option value="Decoración" {{ old('categoria') == 'Decoración' ? 'selected' : '' }}>Decoración</option>
                                </select>
                                <x-input-error :messages="$errors->get('categoria')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="precio" value="Precio de Venta ($) *" />
                                <x-text-input id="precio" class="block mt-1 w-full" type="number" step="0.01" min="0" name="precio" :value="old('precio')" required />
                                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="cantidad_stock" value="Cantidad en Stock *" />
                                <x-text-input id="cantidad_stock" class="block mt-1 w-full" type="number" min="0" name="cantidad_stock" :value="old('cantidad_stock')" required />
                                <x-input-error :messages="$errors->get('cantidad_stock')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2 border-b pb-4 mt-6 mb-2">
                                <h3 class="text-lg font-medium text-gray-900">Características Físicas</h3>
                                <p class="text-sm text-gray-500">Detalles logísticos y de diseño (Opcionales).</p>
                            </div>

                            <div>
                                <x-input-label for="color" value="Color" />
                                <x-text-input id="color" class="block mt-1 w-full" type="text" name="color" :value="old('color')" placeholder="Ej. Gris Oxford" />
                            </div>

                            <div>
                                <x-input-label for="material" value="Material" />
                                <x-text-input id="material" class="block mt-1 w-full" type="text" name="material" :value="old('material')" placeholder="Ej. Madera de Pino y Lino" />
                            </div>

                            <div>
                                <x-input-label for="dimensiones" value="Dimensiones" />
                                <x-text-input id="dimensiones" class="block mt-1 w-full" type="text" name="dimensiones" :value="old('dimensiones')" placeholder="Ej. 200x150x80 cm" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="descripcion" value="Descripción Adicional" />
                                <textarea id="descripcion" name="descripcion" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="3">{{ old('descripcion') }}</textarea>
                            </div>

                            <div class="md:col-span-2 bg-gray-50 p-4 rounded-md border border-gray-200 mt-2">
                                <x-input-label for="imagen" value="Foto del Mueble (Opcional)" class="font-bold text-indigo-700" />
                                <input id="imagen" type="file" name="imagen" class="mt-2 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer" accept="image/jpeg, image/png, image/jpg">
                                <p class="text-xs text-gray-500 mt-2">Formatos aceptados: JPG, JPEG, PNG. Tamaño máximo: 2MB.</p>

                                <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('productos.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                Cancelar
                            </a>
                            <x-primary-button class="bg-indigo-600 hover:bg-indigo-700">
                                Guardar Mueble
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputImagen = document.getElementById('imagen');
            
            inputImagen.addEventListener('change', function() {
                const archivo = this.files[0];
                
                if (archivo) {
                    const tamañoMaximo = 2 * 1024 * 1024; // 2 Megabytes en bytes
                    
                    if (archivo.size > tamañoMaximo) {
                        // Lanzamos la alerta al usuario
                        alert(" ¡ALTO AHÍ!\n\nLa imagen que intentas subir es muy pesada (" + (archivo.size / 1024 / 1024).toFixed(2) + " MB).\nEl tamaño máximo permitido es de 2 MB para no saturar el sistema.\n\nPor favor, elige una imagen más ligera.");
                        
                        // Vaciamos el input para que no lo deje enviar
                        this.value = '';
                    }
                }
            });
        });
    </script>
</x-app-layout>