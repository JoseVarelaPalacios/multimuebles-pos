<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductoSeeder extends Seeder
{
    public function run()
    {
        $muebles = [
            // --- COMEDORES ---
            [
                'nombre' => 'Comedor Rústico 6 Sillas',
                'categoria' => 'Comedores',
                'precio' => 12500.00,
                'cantidad_stock' => 5,
                'material' => 'Madera de Pino Auténtica',
                'color' => 'Nogal Oscuro',
                'dimensiones' => '160x90x75 cm',
                'descripcion' => 'Comedor estilo colono rústico con acabado entintado a mano y protección de barniz mate.',
            ],
            [
                'nombre' => 'Trinchador Clásico de Pino',
                'categoria' => 'Comedores',
                'precio' => 6800.00,
                'cantidad_stock' => 3,
                'material' => 'Madera de Pino y Herrajes',
                'color' => 'Roble',
                'dimensiones' => '150x45x90 cm',
                'descripcion' => 'Trinchador con 3 cajones y 3 puertas inferiores. Herrajes de hierro forjado.',
            ],
            [
                'nombre' => 'Bufetera Estilo Cabaña',
                'categoria' => 'Comedores',
                'precio' => 5400.00,
                'cantidad_stock' => 4,
                'material' => 'Madera Maciza',
                'color' => 'Caoba',
                'dimensiones' => '120x40x85 cm',
                'descripcion' => 'Mueble de apoyo para comedor, ideal para guardar vajilla y mantelería.',
            ],
            [
                'nombre' => 'Silla de Comedor Individual',
                'categoria' => 'Comedores',
                'precio' => 1200.00,
                'cantidad_stock' => 24,
                'material' => 'Pino Torneado',
                'color' => 'Nogal Oscuro',
                'dimensiones' => '45x45x105 cm',
                'descripcion' => 'Silla rústica tradicional con respaldo de barrotes.',
            ],

            // --- RECÁMARAS ---
            [
                'nombre' => 'Cama Individual Cabecera Alta',
                'categoria' => 'Recámaras',
                'precio' => 4800.00,
                'cantidad_stock' => 12,
                'material' => 'Madera Maciza Rústica',
                'color' => 'Roble Natural',
                'dimensiones' => '100x190 cm',
                'descripcion' => 'Base y cabecera individual de diseño tradicional, súper resistente.',
            ],
            [
                'nombre' => 'Cama Matrimonial Tallada a Mano',
                'categoria' => 'Recámaras',
                'precio' => 7500.00,
                'cantidad_stock' => 6,
                'material' => 'Encino y Pino',
                'color' => 'Chocolate',
                'dimensiones' => '140x190 cm',
                'descripcion' => 'Cama matrimonial con detalles florales tallados en la cabecera.',
            ],
            [
                'nombre' => 'Buró de Noche con Cajón',
                'categoria' => 'Recámaras',
                'precio' => 1800.00,
                'cantidad_stock' => 15,
                'material' => 'Madera de Pino',
                'color' => 'Nogal',
                'dimensiones' => '50x40x60 cm',
                'descripcion' => 'Buró clásico con un cajón superior y puerta inferior.',
            ],
            [
                'nombre' => 'Ropero Tradicional 3 Puertas',
                'categoria' => 'Recámaras',
                'precio' => 11200.00,
                'cantidad_stock' => 2,
                'material' => 'Madera Sólida',
                'color' => 'Caoba Oscuro',
                'dimensiones' => '180x60x200 cm',
                'descripcion' => 'Amplio ropero de tres secciones con tubos colgadores y cajonera interna.',
            ],
            [
                'nombre' => 'Baúl de Almacenamiento Fuerte',
                'categoria' => 'Recámaras',
                'precio' => 2900.00,
                'cantidad_stock' => 8,
                'material' => 'Madera y Hierro',
                'color' => 'Rústico Deslavado',
                'dimensiones' => '90x50x50 cm',
                'descripcion' => 'Baúl pie de cama ideal para guardar cobijas, con herrajes tipo hacienda.',
            ],

            // --- SALAS ---
            [
                'nombre' => 'Sofá 3 Plazas Tapiz Lino',
                'categoria' => 'Salas',
                'precio' => 9500.00,
                'cantidad_stock' => 4,
                'material' => 'Estructura Pino / Tela Lino',
                'color' => 'Gris Oxford / Madera',
                'dimensiones' => '210x90x85 cm',
                'descripcion' => 'Sofá amplio con estructura de madera visible y cojines de alta densidad.',
            ],
            [
                'nombre' => 'Sillón Ocasional con Herrería',
                'categoria' => 'Salas',
                'precio' => 3200.00,
                'cantidad_stock' => 8,
                'material' => 'Madera y Herrería Forjada',
                'color' => 'Chocolate',
                'dimensiones' => '70x80x95 cm',
                'descripcion' => 'Sillón individual con detalles de hierro forjado en los reposabrazos. Estilo hacienda.',
            ],
            [
                'nombre' => 'Mesa de Centro Hacienda',
                'categoria' => 'Salas',
                'precio' => 2500.00,
                'cantidad_stock' => 10,
                'material' => 'Madera de Encino',
                'color' => 'Roble',
                'dimensiones' => '100x60x45 cm',
                'descripcion' => 'Mesa de centro sólida con remaches decorativos en las esquinas.',
            ],
            [
                'nombre' => 'Mesa Lateral con Herrería',
                'categoria' => 'Salas',
                'precio' => 1400.00,
                'cantidad_stock' => 12,
                'material' => 'Pino y Hierro',
                'color' => 'Nogal Oscuro',
                'dimensiones' => '50x50x55 cm',
                'descripcion' => 'Mesa auxiliar para lámpara o adornos, hace juego con la mesa de centro Hacienda.',
            ],
            [
                'nombre' => 'Consola para TV Estilo Cabaña',
                'categoria' => 'Salas',
                'precio' => 4200.00,
                'cantidad_stock' => 7,
                'material' => 'Madera Maciza',
                'color' => 'Chocolate Deslavado',
                'dimensiones' => '160x45x65 cm',
                'descripcion' => 'Mueble para televisión con pasacables y estantes abiertos para consolas.',
            ],

            // --- OFICINA ---
            [
                'nombre' => 'Escritorio Secretero de Madera',
                'categoria' => 'Oficina',
                'precio' => 5600.00,
                'cantidad_stock' => 5,
                'material' => 'Pino Tratado',
                'color' => 'Cereza',
                'dimensiones' => '120x60x78 cm',
                'descripcion' => 'Escritorio rústico con 3 cajones laterales y un cajón central para teclado o papelería.',
            ],
            [
                'nombre' => 'Librero Rústico Abierto',
                'categoria' => 'Oficina',
                'precio' => 3800.00,
                'cantidad_stock' => 6,
                'material' => 'Madera de Pino',
                'color' => 'Nogal',
                'dimensiones' => '80x30x180 cm',
                'descripcion' => 'Librero alto de 5 niveles para exhibición de libros y objetos decorativos.',
            ],
            [
                'nombre' => 'Silla Ejecutiva Madera y Cuero',
                'categoria' => 'Oficina',
                'precio' => 3500.00,
                'cantidad_stock' => 4,
                'material' => 'Madera y Cuero Sintético',
                'color' => 'Marrón Oscuro',
                'dimensiones' => '65x65x110 cm',
                'descripcion' => 'Silla de escritorio con base giratoria de madera y tapiz capitonado.',
            ],

            // --- DECORACIÓN ---
            [
                'nombre' => 'Espejo Cuerpo Entero Marco Rústico',
                'categoria' => 'Decoración',
                'precio' => 2100.00,
                'cantidad_stock' => 9,
                'material' => 'Madera Reciclada y Cristal',
                'color' => 'Gris Envejecido',
                'dimensiones' => '60x170 cm',
                'descripcion' => 'Espejo de pie o para colgar, marco grueso de madera tratada estilo vintage.',
            ],
            [
                'nombre' => 'Credenza para Recibidor',
                'categoria' => 'Decoración',
                'precio' => 3900.00,
                'cantidad_stock' => 3,
                'material' => 'Pino y Herrería',
                'color' => 'Roble Oscuro',
                'dimensiones' => '110x35x80 cm',
                'descripcion' => 'Mueble angosto ideal para la entrada del hogar, incluye dos pequeños cajones.',
            ],
            [
                'nombre' => 'Perchero de Pie Torneado',
                'categoria' => 'Decoración',
                'precio' => 850.00,
                'cantidad_stock' => 15,
                'material' => 'Madera Torneada',
                'color' => 'Caoba',
                'dimensiones' => '40x40x175 cm',
                'descripcion' => 'Perchero clásico de pedestal con 6 brazos para sombreros y abrigos.',
            ],
        ];

        // Insertamos cada mueble asegurándonos de que no tengan imagen inicialmente
        foreach ($muebles as $mueble) {
            $mueble['imagen'] = null;
            Producto::create($mueble);
        }
    }
}