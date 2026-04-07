<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EstacionFactory extends Factory
{
    private static array $estaciones = [
        // Ciudad Universitaria / Moncloa
        ['nombre' => 'Estación Biblioteca Central', 'ubicacion' => 'Calle Gran Vía 28, Madrid', 'latitud' => 40.4200, 'longitud' => -3.7025],
        ['nombre' => 'Estación Facultad de Ingeniería', 'ubicacion' => 'Av. Complutense s/n, Ciudad Universitaria', 'latitud' => 40.4530, 'longitud' => -3.7270],
        ['nombre' => 'Estación Residencia Norte', 'ubicacion' => 'Calle Princesa 25, Moncloa', 'latitud' => 40.4310, 'longitud' => -3.7170],
        ['nombre' => 'Estación Polideportivo UCM', 'ubicacion' => 'Av. de Séneca 2, Ciudad Universitaria', 'latitud' => 40.4480, 'longitud' => -3.7310],
        ['nombre' => 'Estación Rectorado', 'ubicacion' => 'Calle Alberto Aguilera 23, Chamberí', 'latitud' => 40.4290, 'longitud' => -3.7110],
        ['nombre' => 'Estación Parque del Oeste', 'ubicacion' => 'Paseo de Moret s/n, Moncloa', 'latitud' => 40.4330, 'longitud' => -3.7280],
        ['nombre' => 'Estación Facultad de Medicina', 'ubicacion' => 'Plaza Ramón y Cajal s/n, Ciudad Universitaria', 'latitud' => 40.4460, 'longitud' => -3.7240],
        ['nombre' => 'Estación Argüelles', 'ubicacion' => 'Calle Marqués de Urquijo 10, Moncloa', 'latitud' => 40.4305, 'longitud' => -3.7145],

        // San Blas / Vicálvaro / Las Rosas / Suanzes
        ['nombre' => 'Estación UDIT Suanzes', 'ubicacion' => 'Calle Alcalá 580, frente a Metro Suanzes', 'latitud' => 40.4378, 'longitud' => -3.6106],
        ['nombre' => 'Estación Metro Las Rosas', 'ubicacion' => 'Av. de Guadalajara 55, Las Rosas', 'latitud' => 40.4318, 'longitud' => -3.6078],
        ['nombre' => 'Estación San Blas', 'ubicacion' => 'Calle Arcos de Jalón 10, San Blas', 'latitud' => 40.4280, 'longitud' => -3.6130],
        ['nombre' => 'Estación Vicálvaro Centro', 'ubicacion' => 'Calle Real de Arganda 39, Vicálvaro', 'latitud' => 40.4040, 'longitud' => -3.6080],
        ['nombre' => 'Estación Valdebernardo', 'ubicacion' => 'Av. de la Democracia 17, Vicálvaro', 'latitud' => 40.4020, 'longitud' => -3.6170],
        ['nombre' => 'Estación Canillejas', 'ubicacion' => 'Av. de Aragón 312, Canillejas', 'latitud' => 40.4410, 'longitud' => -3.6120],

        // Salamanca / Retiro
        ['nombre' => 'Estación Barrio Salamanca', 'ubicacion' => 'Calle Serrano 45, Salamanca', 'latitud' => 40.4260, 'longitud' => -3.6850],
        ['nombre' => 'Estación Retiro Norte', 'ubicacion' => 'Calle Alcalá 65, junto al Retiro', 'latitud' => 40.4210, 'longitud' => -3.6880],
        ['nombre' => 'Estación Goya', 'ubicacion' => 'Calle Goya 32, Salamanca', 'latitud' => 40.4245, 'longitud' => -3.6780],
        ['nombre' => 'Estación Retiro Sur', 'ubicacion' => 'Av. Menéndez Pelayo 67, Retiro', 'latitud' => 40.4100, 'longitud' => -3.6790],

        // Moratalaz / La Elipa / Ventas / Ciudad Lineal
        ['nombre' => 'Estación Moratalaz', 'ubicacion' => 'Calle Camino de los Vinateros 100, Moratalaz', 'latitud' => 40.4070, 'longitud' => -3.6480],
        ['nombre' => 'Estación La Elipa', 'ubicacion' => 'Calle de Honduras 8, La Elipa', 'latitud' => 40.4180, 'longitud' => -3.6500],
        ['nombre' => 'Estación Ventas', 'ubicacion' => 'Calle Alcalá 237, junto a Plaza de Toros', 'latitud' => 40.4315, 'longitud' => -3.6630],
        ['nombre' => 'Estación Ciudad Lineal', 'ubicacion' => 'Calle Arturo Soria 120, Ciudad Lineal', 'latitud' => 40.4440, 'longitud' => -3.6510],

        // Pozuelo de Alarcón
        ['nombre' => 'Estación Pozuelo Centro', 'ubicacion' => 'Plaza del Padre Vallet 1, Pozuelo de Alarcón', 'latitud' => 40.4350, 'longitud' => -3.8130],
        ['nombre' => 'Estación Somosaguas', 'ubicacion' => 'Campus de Somosaguas, Pozuelo de Alarcón', 'latitud' => 40.4270, 'longitud' => -3.7940],

        // Latina
        ['nombre' => 'Estación Latina', 'ubicacion' => 'Paseo de Extremadura 100, Latina', 'latitud' => 40.4020, 'longitud' => -3.7410],
        ['nombre' => 'Estación Puerta del Ángel', 'ubicacion' => 'Calle Illescas 14, Latina', 'latitud' => 40.3970, 'longitud' => -3.7330],
        ['nombre' => 'Estación Batán', 'ubicacion' => 'Paseo de la Virgen del Puerto 8, Latina', 'latitud' => 40.4050, 'longitud' => -3.7290],

        // Vallecas
        ['nombre' => 'Estación Puente de Vallecas', 'ubicacion' => 'Av. de la Albufera 72, Vallecas', 'latitud' => 40.3980, 'longitud' => -3.6680],
        ['nombre' => 'Estación Villa de Vallecas', 'ubicacion' => 'Calle del Congosto 20, Villa de Vallecas', 'latitud' => 40.3810, 'longitud' => -3.6210],
        ['nombre' => 'Estación Nueva Numancia', 'ubicacion' => 'Av. de la Albufera 15, Puente de Vallecas', 'latitud' => 40.4020, 'longitud' => -3.6730],
        ['nombre' => 'Estación Sierra de Guadalupe', 'ubicacion' => 'Calle Sierra de Guadalupe 3, Vallecas', 'latitud' => 40.3890, 'longitud' => -3.6520],

        // Madrid Centro
        ['nombre' => 'Estación Sol', 'ubicacion' => 'Puerta del Sol 1, Centro', 'latitud' => 40.4168, 'longitud' => -3.7038],
        ['nombre' => 'Estación Atocha', 'ubicacion' => 'Glorieta de Carlos V, junto a Atocha', 'latitud' => 40.4065, 'longitud' => -3.6937],
        ['nombre' => 'Estación Plaza España', 'ubicacion' => 'Plaza de España, Centro', 'latitud' => 40.4235, 'longitud' => -3.7122],
        ['nombre' => 'Estación Ópera', 'ubicacion' => 'Plaza de Isabel II, junto al Teatro Real', 'latitud' => 40.4180, 'longitud' => -3.7100],
        ['nombre' => 'Estación Cibeles', 'ubicacion' => 'Plaza de Cibeles, Centro', 'latitud' => 40.4195, 'longitud' => -3.6930],
        ['nombre' => 'Estación Castellana Norte', 'ubicacion' => 'Paseo de la Castellana 150, Chamartín', 'latitud' => 40.4620, 'longitud' => -3.6910],
        ['nombre' => 'Estación Lavapiés', 'ubicacion' => 'Plaza de Lavapiés, Centro', 'latitud' => 40.4090, 'longitud' => -3.7010],
        ['nombre' => 'Estación La Latina', 'ubicacion' => 'Plaza de la Cebada 10, La Latina', 'latitud' => 40.4115, 'longitud' => -3.7090],
        ['nombre' => 'Estación Malasaña', 'ubicacion' => 'Plaza del Dos de Mayo, Malasaña', 'latitud' => 40.4265, 'longitud' => -3.7030],
        ['nombre' => 'Estación Chueca', 'ubicacion' => 'Plaza de Chueca, Centro', 'latitud' => 40.4225, 'longitud' => -3.6975],
        ['nombre' => 'Estación Tribunal', 'ubicacion' => 'Glorieta de Bilbao, Centro', 'latitud' => 40.4290, 'longitud' => -3.7010],
        ['nombre' => 'Estación Conde Duque', 'ubicacion' => 'Calle Conde Duque 11, Centro', 'latitud' => 40.4260, 'longitud' => -3.7130],

        // Nuevas zonas estratégicas
        ['nombre' => 'Estación Chamartín', 'ubicacion' => 'Estación de Chamartín, Chamartín', 'latitud' => 40.4720, 'longitud' => -3.6830],
        ['nombre' => 'Estación Nuevos Ministerios', 'ubicacion' => 'Paseo de la Castellana 67, Chamberí', 'latitud' => 40.4460, 'longitud' => -3.6930],
        ['nombre' => 'Estación Príncipe Pío', 'ubicacion' => 'Paseo de la Florida s/n, Moncloa', 'latitud' => 40.4190, 'longitud' => -3.7200],
        ['nombre' => 'Estación Méndez Álvaro', 'ubicacion' => 'Calle Méndez Álvaro 20, Arganzuela', 'latitud' => 40.3990, 'longitud' => -3.6870],
        ['nombre' => 'Estación Legazpi', 'ubicacion' => 'Plaza de Legazpi, Arganzuela', 'latitud' => 40.3920, 'longitud' => -3.6940],
        ['nombre' => 'Estación Usera', 'ubicacion' => 'Av. de Rafaela Ybarra 43, Usera', 'latitud' => 40.3870, 'longitud' => -3.7040],
        ['nombre' => 'Estación Carabanchel', 'ubicacion' => 'Calle Eugenia de Montijo 55, Carabanchel', 'latitud' => 40.3880, 'longitud' => -3.7310],
    ];

    private static int $indice = 0;

    public function definition(): array
    {
        $i = self::$indice % count(self::$estaciones);
        $data = self::$estaciones[$i];
        self::$indice++;

        return [
            'nombre' => $data['nombre'],
            'ubicacion' => $data['ubicacion'],
            'capacidad' => fake()->numberBetween(8, 25),
            'latitud' => $data['latitud'],
            'longitud' => $data['longitud'],
        ];
    }
}


